<?php
header('Content-Type: application/json');

class UsersController
{
    var $varPDOModelObj;
    public $json, $actionevents;
    public $params = array();

    public $userId, $name, $role_id, $role_name, $username, $password;
    public $email, $phoneNumber, $companies, $image, $createdDate, $ReturnData, $userStatus;
    public $permissions, $decodedData;

    function __construct()
    {
        $this->varPDOModelObj = new CommonPDOModel();

        $this->json = file_get_contents("php://input");
        $data = json_decode($this->json, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            if (!empty($_POST)) {
                $data = $_POST;
            } else if (!empty($_REQUEST)) {
                $data = $_REQUEST;
            } else if (!empty($this->json)) {
                parse_str($this->json, $parsedPost);
                if (!empty($parsedPost)) {
                    if (isset($parsedPost[0]) && is_string($parsedPost[0])) {
                        $decodedFirst = json_decode($parsedPost[0], true);
                        $data = is_array($decodedFirst) ? $decodedFirst : $parsedPost;
                    } else {
                        $data = $parsedPost;
                    }
                }
            }
        }

        if (!is_array($data)) {
            $data = [];
        }

        $this->decodedData = $data;

        // User fields
        $this->userId = $data['user_id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->role_id = $data['role_id'] ?? null;
        $this->role_name = $data['role_name'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->password = $data['password'] ?? null;

        $this->email = $data['email'] ?? null;
        $this->phoneNumber = $data['phoneNumber'] ?? null;
        $this->permissions = $data['permissions'] ?? [];

        // Multiple companies → store as JSON (Super Admin gets all companies automatically if empty)
        $inputCompanies = $data['companies'] ?? [];
        if (($this->role_name === 'Super Admin' || $this->role_id == 3) && empty($inputCompanies)) {
            $allCompsStmt = $this->varPDOModelObj->selectexecuteQuery("SELECT ids, company_name FROM tbl_company");
            if ($allCompsStmt && $allCompsStmt instanceof PDOStatement) {
                $compList = [];
                foreach ($allCompsStmt->fetchAll(PDO::FETCH_ASSOC) as $c) {
                    $compList[] = ['ids' => strval($c['ids']), 'company_name' => $c['company_name']];
                }
                $inputCompanies = $compList;
            }
        }
        $this->companies = json_encode($inputCompanies);

        $this->image = $data['image'] ?? 'default.jpg';

        $action = $data['action'] ?? $_POST['action'] ?? $_GET['action'] ?? null;
        if (empty($action) && isset($_SERVER['REQUEST_URI'])) {
            $uriPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
            $parts = explode('/', $uriPath);
            $action = end($parts);
        }
        $this->actionevents = $action;

        $this->userStatus = $data['status'] ?? null;

        date_default_timezone_set('Asia/Bahrain');
        $this->createdDate = date('Y-m-d H:i:s');
    }

    function SQLArray()
    {
        $array = array();

        $array[0] = "INSERT INTO tbl_users
                    (
                        profile_name,
                        user_role_id,
                        user_role_name,
                        user_name,
                        user_passkey,
                        user_email,
                        user_mobile,
                        company_json,
                        profile_image,
                        created_date
                    )
                    VALUES
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $this->params[0] = [
            $this->name,
            $this->role_id,
            $this->role_name,
            $this->username,
            $this->password,
            $this->email,
            $this->phoneNumber,
            $this->companies,
            $this->image,
            $this->createdDate
        ];

        $array[1] = "SELECT 
                        user_id,
                        profile_name,
                        user_role_id,
                        user_role_name,
                        user_name,
                        user_passkey,
                        user_email,
                        user_mobile,
                        company_json,
                        profile_image,
                        user_status
                    FROM tbl_users  order by user_id desc";

        $array[2] = "UPDATE tbl_users SET user_status = :status WHERE user_id = :user_id";

        $array[3] = "UPDATE tbl_users SET
                        profile_name = ?,
                        user_role_id = ?,
                        user_role_name = ?,
                        user_name = ?,
                        user_email = ?,
                        user_mobile = ?,
                        company_json = ?,
                        profile_image = ?
                    WHERE user_id = ?";

        $this->params[1] = [
            $this->name,
            $this->role_id,
            $this->role_name,
            $this->username,
            $this->email,
            $this->phoneNumber,
            $this->companies,
            $this->image,
            $this->userId
        ];

        $array[4] = "UPDATE tbl_users SET user_passkey = :password WHERE user_id = :user_id";

        $this->params[2] = [
            ':password' => $this->password,
            ':user_id' => $this->userId
        ];

        return $array;
    }

    function DataRequest($action)
    {
        $var = $this->SQLArray();

        switch ($action) {

            case 'InsertUserInformation':

                $loggedInRoleIds = array_map('intval', explode(',', $_SESSION['user_role_id'] ?? ''));
                $isSuperAdminLoggedIn = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || in_array(3, $loggedInRoleIds);
                
                $targetRoleIds = array_map('intval', explode(',', strval($this->role_id)));
                $targetRoleNames = array_map('trim', explode(',', strval($this->role_name)));
                $hasAdminOrSuperAdmin = in_array(1, $targetRoleIds) || in_array(3, $targetRoleIds) || in_array('Administrator', $targetRoleNames) || in_array('Super Admin', $targetRoleNames);

                if (!$isSuperAdminLoggedIn && $hasAdminOrSuperAdmin) {
                    echo json_encode([
                        'status' => false,
                        'message' => 'Permission denied: Administrators can only create standard User accounts.'
                    ]);
                    break;
                }

                $this->ReturnData = $this->varPDOModelObj
                    ->AddToTableAndReturnSpecifiedColumn(
                        $var[0],
                        'ids',
                        'tbl_users',
                        $this->params[0]
                    );

                Logger::ActivityLog(
                    'InsertUserInformation',
                    "Send to Client",
                    [$this->ReturnData]
                );

                $User_id = json_decode(
                    json_decode($this->ReturnData, true)['data']['return_ids_value'],
                    true
                )['data'][0]['ids'] ?? null;

                $outSend = json_encode([
                    'status' => true,
                    'message' => "User Successfully Added",
                    'user_id' => $User_id
                ]);

                Logger::ActivityLog(
                    'InsertUserInformation',
                    "Send to Client",
                    [json_decode($outSend)]
                );

                echo $outSend;

                break;

            case 'LoadRoles':
                $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || (($_SESSION['user_role_id'] ?? 0) == 3);

                if ($isSuperAdmin) {
                    $sql = "SELECT role_id, role_name FROM tbl_roles WHERE status='Active' ORDER BY role_id ASC";
                } else {
                    // Administrator can only create regular 'User' accounts
                    $sql = "SELECT role_id, role_name FROM tbl_roles WHERE status='Active' AND role_name NOT IN ('Super Admin', 'Administrator') AND role_id NOT IN (1, 3) ORDER BY role_id ASC";
                }

                $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql);
                echo json_encode(["status" => true, "data" => json_decode($this->ReturnData, true)['data'] ?? []]);
                break;


            case 'LoadCompanies':

                $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || (($_SESSION['user_role_id'] ?? 0) == 3);

                if ($isSuperAdmin) {
                    $sql = "SELECT ids, company_name FROM tbl_company where status='Active' ORDER BY ids ASC";
                    $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql);
                    echo json_encode([
                        "status" => true,
                        "data" => json_decode($this->ReturnData, true)['data'] ?? []
                    ]);
                } else {
                    $loggedInCompanyId = strval($_SESSION['company_id'] ?? '1');
                    $userCompanyIds = [$loggedInCompanyId];

                    if (!empty($_SESSION['company_json'])) {
                        $cArr = json_decode($_SESSION['company_json'], true);
                        if (is_array($cArr)) {
                            foreach ($cArr as $c) {
                                if (!empty($c['ids'])) {
                                    $userCompanyIds[] = strval($c['ids']);
                                }
                            }
                        }
                    }
                    $userCompanyIds = array_unique($userCompanyIds);
                    $idListStr = implode("','", array_map('addslashes', $userCompanyIds));

                    $sql = "SELECT ids, company_name FROM tbl_company WHERE status='Active' AND ids IN ('{$idListStr}') ORDER BY ids ASC";
                    $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql);

                    echo json_encode([
                        "status" => true,
                        "data" => json_decode($this->ReturnData, true)['data'] ?? []
                    ]);
                }

                break;

            case 'CheckUsername':

                $input = json_decode(file_get_contents("php://input"), true);
                $username = trim($input['username'] ?? '');
                $userId = $input['user_id'] ?? null;

                if (!empty($userId)) {
                    $sql = "SELECT COUNT(*) AS total FROM tbl_users WHERE LOWER(user_name) = LOWER(?) AND user_id != ?";
                    $params = [$username, $userId];
                } else {
                    $sql = "SELECT COUNT(*) AS total FROM tbl_users WHERE LOWER(user_name) = LOWER(?)";
                    $params = [$username];
                }

                $result = $this->varPDOModelObj->ListFromTable($sql, $params);
                $decoded = json_decode($result, true);

                $count = $decoded['data'][0]['total'] ?? 0;

                echo json_encode([
                    "exists" => ($count > 0)
                ]);

                break;

            case 'LoadUserList':

                $rawResult = $this->varPDOModelObj->ListFromTable($var[1]);
                $resData = json_decode($rawResult, true);

                $loggedInRoleIds = array_map('intval', explode(',', $_SESSION['user_role_id'] ?? ''));
                $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || in_array(3, $loggedInRoleIds);

                if ($isSuperAdmin) {
                    echo json_encode([
                        'status' => true,
                        'data' => $resData['data'] ?? []
                    ]);
                } else {
                    $loggedInCompanyId = strval($_SESSION['company_id'] ?? '1');
                    $userCompanyIds = [$loggedInCompanyId];

                    if (!empty($_SESSION['company_json'])) {
                        $cArr = json_decode($_SESSION['company_json'], true);
                        if (is_array($cArr)) {
                            foreach ($cArr as $c) {
                                if (!empty($c['ids'])) {
                                    $userCompanyIds[] = strval($c['ids']);
                                }
                            }
                        }
                    }
                    $userCompanyIds = array_unique($userCompanyIds);

                    $loggedInUserId = intval($_SESSION['user_id'] ?? 0);
                    $filteredUsers = [];
                    if (!empty($resData['data']) && is_array($resData['data'])) {
                        foreach ($resData['data'] as $uRow) {
                            $uRoleIds = array_map('intval', explode(',', $uRow['user_role_id'] ?? ''));
                            $uRoleNames = array_map('trim', explode(',', $uRow['user_role_name'] ?? ''));
                            $isTargetSuperAdmin = in_array(3, $uRoleIds) || in_array('Super Admin', $uRoleNames);
                            $isTargetAdmin = in_array(1, $uRoleIds) || in_array('Administrator', $uRoleNames);
                            $uId = intval($uRow['user_id'] ?? 0);

                            // Non-superadmin users should NOT see Super Admin accounts at all
                            if ($isTargetSuperAdmin) {
                                continue;
                            }

                            // Administrator cannot manage or view other Administrators (only regular Users & their own profile)
                            if ($isTargetAdmin) {
                                if ($uId !== $loggedInUserId) {
                                    continue;
                                }
                            }

                            $uComps = json_decode($uRow['company_json'] ?? '[]', true);
                            $hasAccess = false;
                            if (is_array($uComps)) {
                                foreach ($uComps as $cItem) {
                                    if (!empty($cItem['ids']) && in_array(strval($cItem['ids']), $userCompanyIds)) {
                                        $hasAccess = true;
                                        break;
                                    }
                                }
                            }
                            if ($hasAccess) {
                                $filteredUsers[] = $uRow;
                            }
                        }
                    }

                    echo json_encode([
                        'status' => true,
                        'data' => array_values($filteredUsers)
                    ]);
                }

                break;

            case 'UpdateUserInformation':

                $loggedInRoleIds = array_map('intval', explode(',', $_SESSION['user_role_id'] ?? ''));
                $isSuperAdminLoggedIn = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || in_array(3, $loggedInRoleIds);
                $loggedInUserId = intval($_SESSION['user_id'] ?? 0);

                if (!$isSuperAdminLoggedIn) {
                    $targetRoleIds = array_map('intval', explode(',', strval($this->role_id)));
                    $targetRoleNames = array_map('trim', explode(',', strval($this->role_name)));
                    $hasAdminOrSuperAdmin = in_array(1, $targetRoleIds) || in_array(3, $targetRoleIds) || in_array('Administrator', $targetRoleNames) || in_array('Super Admin', $targetRoleNames);

                    if ($hasAdminOrSuperAdmin) {
                        if (intval($this->userId) !== $loggedInUserId) {
                            echo json_encode([
                                'status' => false,
                                'message' => 'Permission denied: Administrators can only manage standard User accounts and cannot update other Administrators.'
                            ]);
                            break;
                        }
                    }

                    if (!empty($this->userId) && intval($this->userId) !== $loggedInUserId) {
                        $targetUserStmt = $this->varPDOModelObj->selectexecuteQuery("SELECT user_role_id, user_role_name FROM tbl_users WHERE user_id = " . intval($this->userId));
                        if ($targetUserStmt && $targetUserStmt instanceof PDOStatement) {
                            $tRow = $targetUserStmt->fetch(PDO::FETCH_ASSOC);
                            $tRoleIds = array_map('intval', explode(',', $tRow['user_role_id'] ?? ''));
                            $tRoleNames = array_map('trim', explode(',', $tRow['user_role_name'] ?? ''));
                            $isTargetAdminOrSuper = in_array(1, $tRoleIds) || in_array(3, $tRoleIds) || in_array('Administrator', $tRoleNames) || in_array('Super Admin', $tRoleNames);
                            if ($isTargetAdminOrSuper) {
                                echo json_encode([
                                    'status' => false,
                                    'message' => 'Permission denied: Administrators cannot edit other Administrators.'
                                ]);
                                break;
                            }
                        }
                    }
                }

                $result = $this->varPDOModelObj->UpdateTable($var[3], $this->params[1]);
                echo $result;

                break;

            case 'ChangeUserStatus':
                $loggedInRoleIds = array_map('intval', explode(',', $_SESSION['user_role_id'] ?? ''));
                $isSuperAdminLoggedIn = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || in_array(3, $loggedInRoleIds);
                $loggedInUserId = intval($_SESSION['user_id'] ?? 0);

                if (!empty($this->userId)) {
                    $targetUserStmt = $this->varPDOModelObj->selectexecuteQuery("SELECT user_role_id, user_role_name FROM tbl_users WHERE user_id = " . intval($this->userId));
                    if ($targetUserStmt && $targetUserStmt instanceof PDOStatement) {
                        $tRow = $targetUserStmt->fetch(PDO::FETCH_ASSOC);
                        $tRoleIds = array_map('intval', explode(',', $tRow['user_role_id'] ?? ''));
                        $tRoleNames = array_map('trim', explode(',', $tRow['user_role_name'] ?? ''));
                        $isTargetAdminOrSuper = in_array(1, $tRoleIds) || in_array(3, $tRoleIds) || in_array('Administrator', $tRoleNames) || in_array('Super Admin', $tRoleNames);

                        if (!$isSuperAdminLoggedIn && intval($this->userId) !== $loggedInUserId) {
                            if ($isTargetAdminOrSuper) {
                                echo json_encode([
                                    'success' => false,
                                    'message' => 'Permission denied: Administrators cannot activate or deactivate other Administrators or Super Admins.'
                                ]);
                                break;
                            }
                        }
                    }
                }

                $params = [
                    ':status' => $this->userStatus,
                    ':user_id' => $this->userId
                ];

                $result = $this->varPDOModelObj->UpdateTable($var[2], $params);

                echo json_encode([
                    'success' => $result
                ]);
                break;

            case 'ResetPassword':

                $loggedInRoleIds = array_map('intval', explode(',', $_SESSION['user_role_id'] ?? ''));
                $isSuperAdminLoggedIn = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || in_array(3, $loggedInRoleIds);

                if (!empty($this->userId)) {
                    $targetUserStmt = $this->varPDOModelObj->selectexecuteQuery("SELECT user_role_id, user_role_name FROM tbl_users WHERE user_id = " . intval($this->userId));
                    if ($targetUserStmt && $targetUserStmt instanceof PDOStatement) {
                        $tRow = $targetUserStmt->fetch(PDO::FETCH_ASSOC);
                        $tRoleIds = array_map('intval', explode(',', $tRow['user_role_id'] ?? ''));
                        $tRoleNames = array_map('trim', explode(',', $tRow['user_role_name'] ?? ''));
                        $isTargetAdminOrSuper = in_array(1, $tRoleIds) || in_array(3, $tRoleIds) || in_array('Administrator', $tRoleNames) || in_array('Super Admin', $tRoleNames);

                        if (!$isSuperAdminLoggedIn) {
                            if ($isTargetAdminOrSuper) {
                                echo json_encode([
                                    'success' => false,
                                    'message' => 'Permission denied: Administrators cannot reset passwords for other Administrators or Super Admins.'
                                ]);
                                break;
                            }
                        }
                    }
                }

                $result = $this->varPDOModelObj->UpdateTable($var[4], $this->params[2]);

                echo json_encode([
                    "success" => $result
                ]);

                break;

            case 'LoadMasterPermissions':
                $this->ensurePermissionTablesExist();
                $sql = "SELECT permission_id, permission_name, permission_key, module_group, status FROM tbl_permissions WHERE status='Active' ORDER BY module_group ASC, permission_id ASC";
                $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql);
                echo json_encode([
                    "status" => true,
                    "data" => json_decode($this->ReturnData, true)['data'] ?? []
                ]);
                break;

            case 'LoadUserPermissions':
                $this->ensurePermissionTablesExist();
                $targetUserId = intval($this->userId ?? $this->decodedData['user_id'] ?? 0);

                $pdo = $this->varPDOModelObj->varDBPDO;
                $masterPerms = [];
                if ($pdo) {
                    $mStmt = $pdo->query("SELECT permission_id, permission_name, permission_key, module_group FROM tbl_permissions WHERE status='Active' ORDER BY module_group ASC, permission_id ASC");
                    if ($mStmt) $masterPerms = $mStmt->fetchAll(PDO::FETCH_ASSOC);
                }

                // Get target user's role_id
                $targetRoleId = strval($this->role_id ?? $this->decodedData['role_id'] ?? '');
                if ($targetUserId > 0 && empty($targetRoleId) && $pdo) {
                    $usrStmt = $pdo->prepare("SELECT user_role_id FROM tbl_users WHERE user_id = ?");
                    $usrStmt->execute([$targetUserId]);
                    $targetRoleId = strval($usrStmt->fetchColumn() ?: '');
                }

                $roleIds = array_filter(array_map('intval', explode(',', $targetRoleId)));

                // Fetch Role default permissions combined (any Granted -> Granted)
                $rolePermMap = [];
                if (!empty($roleIds) && $pdo) {
                    $placeholders = implode(',', array_fill(0, count($roleIds), '?'));
                    $rStmt = $pdo->prepare("SELECT permission_id, status FROM tbl_role_permissions WHERE role_id IN ($placeholders)");
                    $rStmt->execute($roleIds);
                    while ($rRow = $rStmt->fetch(PDO::FETCH_ASSOC)) {
                        $pId = intval($rRow['permission_id']);
                        $currentStatus = $rolePermMap[$pId] ?? 'Revoked';
                        if ($rRow['status'] === 'Granted') {
                            $currentStatus = 'Granted';
                        }
                        $rolePermMap[$pId] = $currentStatus;
                    }
                }

                $resultList = [];
                foreach ($masterPerms as $m) {
                    $pId = intval($m['permission_id']);
                    // Inherited combined status
                    $effectiveStatus = $rolePermMap[$pId] ?? 'Revoked';

                    $resultList[] = [
                        'permission_id' => $pId,
                        'permission_name' => $m['permission_name'],
                        'permission_key' => $m['permission_key'],
                        'module_group' => $m['module_group'],
                        'status' => $effectiveStatus
                    ];
                }

                echo json_encode([
                    'status' => true,
                    'data' => $resultList
                ]);
                break;

            case 'CreateRole':
                if (ob_get_length()) @ob_clean();
                $roleName = trim($this->decodedData['role_name'] ?? '');
                if (empty($roleName)) {
                    echo json_encode(['status' => false, 'message' => 'Role name is required']);
                    exit;
                }
                $pdo = $this->varPDOModelObj->varDBPDO;
                if ($pdo) {
                    $chk = $pdo->prepare("SELECT COUNT(*) FROM tbl_roles WHERE LOWER(role_name) = LOWER(?)");
                    $chk->execute([$roleName]);
                    if ($chk->fetchColumn() > 0) {
                        echo json_encode(['status' => false, 'message' => 'Role already exists']);
                        exit;
                    }
                    $ins = $pdo->prepare("INSERT INTO tbl_roles (role_name, status) VALUES (?, 'Active')");
                    $ins->execute([$roleName]);
                    $newRoleId = $pdo->lastInsertId();
                    echo json_encode(['status' => true, 'message' => 'Role created successfully', 'role_id' => $newRoleId, 'role_name' => $roleName]);
                    exit;
                } else {
                    echo json_encode(['status' => false, 'message' => 'Database error']);
                    exit;
                }
                break;

            case 'LoadRolePermissions':
                if (ob_get_length()) @ob_clean();
                $this->ensurePermissionTablesExist();
                $targetRoleId = strval($this->decodedData['role_id'] ?? $this->role_id ?? '');
                $pdo = $this->varPDOModelObj->varDBPDO;

                $masterPerms = [];
                if ($pdo) {
                    $mStmt = $pdo->query("SELECT permission_id, permission_name, permission_key, module_group FROM tbl_permissions WHERE status='Active' ORDER BY module_group ASC, permission_id ASC");
                    if ($mStmt) $masterPerms = $mStmt->fetchAll(PDO::FETCH_ASSOC);
                }

                $roleIds = array_filter(array_map('intval', explode(',', $targetRoleId)));

                $rolePermMap = [];
                if (!empty($roleIds) && $pdo) {
                    $placeholders = implode(',', array_fill(0, count($roleIds), '?'));
                    $rStmt = $pdo->prepare("SELECT permission_id, status FROM tbl_role_permissions WHERE role_id IN ($placeholders)");
                    $rStmt->execute($roleIds);
                    while ($rRow = $rStmt->fetch(PDO::FETCH_ASSOC)) {
                        $pId = intval($rRow['permission_id']);
                        $currentStatus = $rolePermMap[$pId] ?? 'Revoked';
                        if ($rRow['status'] === 'Granted') {
                            $currentStatus = 'Granted';
                        }
                        $rolePermMap[$pId] = $currentStatus;
                    }
                }

                $resultList = [];
                foreach ($masterPerms as $m) {
                    $pId = intval($m['permission_id']);
                    $st = $rolePermMap[$pId] ?? 'Revoked';
                    $resultList[] = [
                        'permission_id' => $pId,
                        'permission_name' => $m['permission_name'],
                        'permission_key' => $m['permission_key'],
                        'module_group' => $m['module_group'],
                        'status' => $st
                    ];
                }

                echo json_encode([
                    'status' => true,
                    'role_id' => $targetRoleId,
                    'data' => $resultList
                ]);
                exit;

            case 'SaveRolePermissions':
                if (ob_get_length()) @ob_clean();
                $this->ensurePermissionTablesExist();
                $targetRoleId = intval($this->decodedData['role_id'] ?? 0);
                $permsArray = $this->decodedData['permissions'] ?? [];

                if ($targetRoleId <= 0) {
                    echo json_encode(['status' => false, 'message' => 'Please select a valid role']);
                    exit;
                }

                $pdo = $this->varPDOModelObj->varDBPDO;
                if ($pdo && is_array($permsArray)) {
                    $stmt = $pdo->prepare("INSERT INTO tbl_role_permissions (role_id, permission_id, status, updated_date) 
                                           VALUES (?, ?, ?, NOW()) 
                                           ON DUPLICATE KEY UPDATE status = VALUES(status), updated_date = NOW()");
                    foreach ($permsArray as $perm) {
                        $permId = intval($perm['permission_id'] ?? 0);
                        $st = ($perm['status'] ?? 'Granted') === 'Revoked' ? 'Revoked' : 'Granted';
                        if ($permId > 0) {
                            $stmt->execute([$targetRoleId, $permId, $st]);
                        }
                    }
                    echo json_encode(['status' => true, 'message' => 'Role permissions saved successfully']);
                    exit;
                } else {
                    echo json_encode(['status' => false, 'message' => 'Failed to save role permissions']);
                    exit;
                }
                break;

            default:
                $noAction = json_encode([
                    'status' => false,
                    'message' => "No Action Found"
                ]);

                echo $noAction;

                Logger::ActivityLog(
                    'UsersController',
                    "default",
                    [json_decode($noAction)]
                );

                break;
        }
    }

    private function ensurePermissionTablesExist()
    {
        try {
            $pdo = $this->varPDOModelObj->varDBPDO;
            if (!$pdo) return;

            $sql1 = "CREATE TABLE IF NOT EXISTS `tbl_permissions` (
                `permission_id` INT(11) NOT NULL AUTO_INCREMENT,
                `permission_name` VARCHAR(200) NOT NULL,
                `permission_key` VARCHAR(100) NOT NULL,
                `module_group` VARCHAR(100) DEFAULT 'General',
                `status` VARCHAR(20) DEFAULT 'Active',
                PRIMARY KEY (`permission_id`),
                UNIQUE KEY `uniq_perm_key` (`permission_key`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $pdo->exec($sql1);

            $sql2 = "CREATE TABLE IF NOT EXISTS `tbl_role_permissions` (
                `ids` INT(11) NOT NULL AUTO_INCREMENT,
                `role_id` INT(11) NOT NULL,
                `permission_id` INT(11) NOT NULL,
                `status` VARCHAR(20) NOT NULL DEFAULT 'Granted',
                `updated_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`ids`),
                UNIQUE KEY `uniq_role_perm` (`role_id`, `permission_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $pdo->exec($sql2);

            $sql3 = "CREATE TABLE IF NOT EXISTS `tbl_user_permissions` (
                `ids` INT(11) NOT NULL AUTO_INCREMENT,
                `user_id` INT(11) NOT NULL,
                `permission_id` INT(11) NOT NULL,
                `status` VARCHAR(20) NOT NULL DEFAULT 'Granted',
                `updated_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`ids`),
                UNIQUE KEY `uniq_user_perm` (`user_id`, `permission_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            $pdo->exec($sql3);

            try { $pdo->exec("ALTER TABLE `tbl_permissions` ADD COLUMN `permission_key` VARCHAR(100) DEFAULT NULL"); } catch (Exception $e) {}
            try { $pdo->exec("ALTER TABLE `tbl_permissions` ADD COLUMN `module_group` VARCHAR(100) DEFAULT 'General'"); } catch (Exception $e) {}
            try { $pdo->exec("ALTER TABLE `tbl_permissions` ADD COLUMN `status` VARCHAR(20) DEFAULT 'Active'"); } catch (Exception $e) {}
            try { $pdo->exec("ALTER TABLE `tbl_permissions` ADD UNIQUE KEY `uniq_perm_key` (`permission_key`)"); } catch (Exception $e) {}
            try { $pdo->exec("ALTER TABLE `tbl_role_permissions` ADD COLUMN `status` VARCHAR(20) NOT NULL DEFAULT 'Granted'"); } catch (Exception $e) {}
            try { $pdo->exec("ALTER TABLE `tbl_role_permissions` ADD COLUMN `updated_date` DATETIME DEFAULT CURRENT_TIMESTAMP"); } catch (Exception $e) {}
            try { $pdo->exec("ALTER TABLE `tbl_role_permissions` ADD UNIQUE KEY `uniq_role_perm` (`role_id`, `permission_id`)"); } catch (Exception $e) {}

            $defaultPermissions = [
                // Dashboard
                ['Dashboard Access', 'dashboard_access', 'Dashboard'],
                ['Dashboard Manage', 'dashboard_manage', 'Dashboard'],

                // Masters
                ['Users Access', 'users_access', 'Masters'],
                ['Users Manage', 'users_manage', 'Masters'],
                ['Vehicle Configuration Access', 'vehicle_config_access', 'Masters'],
                ['Vehicle Configuration Manage', 'vehicle_config_manage', 'Masters'],
                ['Vehicle Registration Access', 'vehicle_registration_access', 'Masters'],
                ['Vehicle Registration Manage', 'vehicle_registration_manage', 'Masters'],
                ['Driver Registration Access', 'driver_registration_access', 'Masters'],
                ['Driver Registration Manage', 'driver_registration_manage', 'Masters'],
                ['Staff Registration Access', 'staff_registration_access', 'Masters'],
                ['Staff Registration Manage', 'staff_registration_manage', 'Masters'],
                ['List of Vehicles Access', 'list_of_vehicles_access', 'Masters'],
                ['List of Vehicles Manage', 'list_of_vehicles_manage', 'Masters'],
                ['Customers Access', 'customers_access', 'Masters'],
                ['Customers Manage', 'customers_manage', 'Masters'],
                ['Outsourcing Company Access', 'outsourcing_company_access', 'Masters'],
                ['Outsourcing Company Manage', 'outsourcing_company_manage', 'Masters'],

                // Operations
                ['Vehicle Reservation Access', 'vehicle_reservation_access', 'Operations'],
                ['Vehicle Reservation Manage', 'vehicle_reservation_manage', 'Operations'],
                ['Generate Contract Access', 'generate_contract_access', 'Operations'],
                ['Generate Contract Manage', 'generate_contract_manage', 'Operations'],
                ['Contract List Access', 'contract_list_access', 'Operations'],
                ['Contract List Manage', 'contract_list_manage', 'Operations'],
                ['Send Contract Access', 'send_contract_access', 'Operations'],
                ['Send Contract Manage', 'send_contract_manage', 'Operations'],
                ['Staff Use Allocation Access', 'staff_use_allocation_access', 'Operations'],
                ['Staff Use Allocation Manage', 'staff_use_allocation_manage', 'Operations'],

                // Accounting
                ['Quotation Access', 'quotation_access', 'Accounting'],
                ['Quotation Manage', 'quotation_manage', 'Accounting'],
                ['Invoice Access', 'invoice_access', 'Accounting'],
                ['Invoice Manage', 'invoice_manage', 'Accounting'],
                ['Cash Memo/Receipt Access', 'cash_memo_access', 'Accounting'],
                ['Cash Memo/Receipt Manage', 'cash_memo_manage', 'Accounting'],
                ['Expense Voucher Access', 'expense_voucher_access', 'Accounting'],
                ['Expense Voucher Manage', 'expense_voucher_manage', 'Accounting'],
                ['Customer Ledger Access', 'customer_ledger_access', 'Accounting'],
                ['Customer Ledger Manage', 'customer_ledger_manage', 'Accounting'],
                ['Fund Flow Report Access', 'fund_flow_report_access', 'Accounting'],
                ['Fund Flow Report Manage', 'fund_flow_report_manage', 'Accounting'],
                ['Unbilled Contracts Access', 'unbilled_contracts_access', 'Accounting'],
                ['Unbilled Contracts Manage', 'unbilled_contracts_manage', 'Accounting'],

                // Reports
                ['Vehicle Insight Access', 'vehicle_insight_access', 'Reports'],
                ['Vehicle Insight Manage', 'vehicle_insight_manage', 'Reports'],
                ['Expected Returns Access', 'expected_returns_access', 'Reports'],
                ['Expected Returns Manage', 'expected_returns_manage', 'Reports'],
                ['Customer Balances Access', 'customer_balances_access', 'Reports'],
                ['Customer Balances Manage', 'customer_balances_manage', 'Reports'],
                ['Daily Rental Report Access', 'daily_rental_report_access', 'Reports'],
                ['Daily Rental Report Manage', 'daily_rental_report_manage', 'Reports'],
                ['Daily Cash Report Access', 'daily_cash_report_access', 'Reports'],
                ['Daily Cash Report Manage', 'daily_cash_report_manage', 'Reports'],
                ['Staff Use Report Access', 'staff_use_report_access', 'Reports'],
                ['Staff Use Report Manage', 'staff_use_report_manage', 'Reports'],
                ['Contract & Replacement History Access', 'contract_history_report_access', 'Reports'],
                ['Contract & Replacement History Manage', 'contract_history_report_manage', 'Reports'],

                // Settings
                ['System Settings Access', 'system_settings_access', 'Settings'],
                ['System Settings Manage', 'system_settings_manage', 'Settings']
            ];

            $insStmt = $pdo->prepare("INSERT INTO tbl_permissions (permission_name, permission_key, module_group, status) VALUES (?, ?, ?, 'Active') ON DUPLICATE KEY UPDATE permission_name = VALUES(permission_name), module_group = VALUES(module_group), status = 'Active'");
            foreach ($defaultPermissions as $p) {
                $insStmt->execute([$p[0], $p[1], $p[2]]);
            }
        } catch (Exception $e) {
            // Ignore
        }
    }

    private function saveUserPermissions($userId, $permissionsArray)
    {
        if (empty($userId) || !is_array($permissionsArray)) return;
        $this->ensurePermissionTablesExist();
        try {
            $pdo = $this->varPDOModelObj->varDBPDO;
            if (!$pdo) return;

            $stmt = $pdo->prepare("INSERT INTO tbl_user_permissions (user_id, permission_id, status, updated_date) 
                                   VALUES (?, ?, ?, NOW()) 
                                   ON DUPLICATE KEY UPDATE status = VALUES(status), updated_date = NOW()");
            foreach ($permissionsArray as $perm) {
                $permId = intval($perm['permission_id'] ?? 0);
                $st = ($perm['status'] ?? 'Granted') === 'Revoked' ? 'Revoked' : 'Granted';
                if ($permId > 0) {
                    $stmt->execute([$userId, $permId, $st]);
                }
            }
        } catch (Exception $e) {
            // Ignore
        }
    }
}

$obj = new UsersController();
$obj->DataRequest($obj->actionevents);
