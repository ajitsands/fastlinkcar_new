<?php
header('Content-Type: application/json');

class UsersController
{
    var $varPDOModelObj;
    public $json, $actionevents;
    public $params = array();

    public $userId, $name, $role_id, $role_name, $username, $password;
    public $email, $phoneNumber, $companies, $image, $createdDate, $ReturnData, $userStatus;

    function __construct()
    {
        $this->varPDOModelObj = new CommonPDOModel();

        $this->json = file_get_contents("php://input");

        if (!$this->json) {
            echo json_encode([
                "status" => false,
                "message" => "No input data received"
            ]);
            exit;
        }

        $data = json_decode($this->json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode([
                "status" => false,
                "message" => "Invalid JSON"
            ]);
            exit;
        }

        // User fields
        $this->userId = $data['user_id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->role_id = $data['role_id'] ?? null;
        $this->role_name = $data['role_name'] ?? null;
        $this->username = $data['username'] ?? null;
        $this->password = $data['password'] ?? null;

        $this->email = $data['email'] ?? null;
        $this->phoneNumber = $data['phoneNumber'] ?? null;

        // Multiple companies → store as JSON
        $this->companies = json_encode($data['companies'] ?? []);

        $this->image = $data['image'] ?? 'default.jpg';

        $this->actionevents = $data['action'] ?? null;

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
                $sql = "SELECT role_id, role_name FROM tbl_roles where status='Active' ORDER BY role_id ASC";
                $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql);
                echo json_encode(["status" => true, "data" => json_decode($this->ReturnData, true)['data']]);
                break;


            case 'LoadCompanies':

                $sql = "SELECT ids, company_name FROM tbl_company where status='Active' ORDER BY ids ASC";
                $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql);

                echo json_encode([
                    "status" => true,
                    "data" => json_decode($this->ReturnData, true)['data']
                ]);

                break;

            case 'CheckUsername':

                $input = json_decode(file_get_contents("php://input"), true);
                $username = $input['username'] ?? '';

                $sql = "SELECT COUNT(*) AS total FROM tbl_users WHERE user_name = ?";
                $params = [$username];
                $result = $this->varPDOModelObj->ListFromTable($sql, $params);
                $decoded = json_decode($result, true);

                $count = $decoded['data'][0]['total'] ?? 0;

                if ($count > 0) {
                    echo json_encode([
                        "exists" => true
                    ]);
                } else {
                    echo json_encode([
                        "exists" => false
                    ]);
                }

                break;

            case 'LoadUserList':

                $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[1]);
                echo $this->ReturnData;

                break;

            case 'UpdateUserInformation':

                $result = $this->varPDOModelObj->UpdateTable($var[3], $this->params[1]);
                echo $result;

                break;

            case 'ChangeUserStatus':
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

                $result = $this->varPDOModelObj->UpdateTable($var[4], $this->params[2]);

                echo json_encode([
                    "success" => $result
                ]);

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
}

$obj = new UsersController();
$obj->DataRequest($obj->actionevents);
