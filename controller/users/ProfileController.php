<?php

header('Content-Type: application/json');

class UsersController
{
    var $varPDOModelObj;
    public $json, $actionevents;
    public $params = array();

    public $userId, $name, $role_id, $role_name, $username, $password;
    public $email, $phoneNumber, $companies, $image, $createdDate, $ReturnData, $userStatus, $current_password, $new_password;

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
        
        $this->current_password = $data['current_password'] ?? '';
        $this->new_password     = $data['new_password'] ?? '';
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


        return $array;
    }

    function DataRequest($action)
    {
        $var = $this->SQLArray();

        switch ($action) {

            case 'InsertUserInformation':

                    $sql_update = "UPDATE tbl_users SET
                                        profile_name = ?,
                                        user_email = ?,
                                        user_mobile = ?,
                                        profile_image = ?
                                    WHERE user_id = ?";
                
                    $sqlparams = [
                        $this->name,
                        $this->email,
                        $this->phoneNumber,
                        $this->image,
                        $this->userId
                    ];
               
                    $this->ReturnData = $this->varPDOModelObj->UpdateTable(
                        $sql_update,
                        $sqlparams
                    );
                
                    if ($this->ReturnData) {
                
                        echo json_encode([
                            "status" => true,
                            "message" => "Profile updated successfully."
                        ]);
                
                    } else {
                
                        echo json_encode([
                            "status" => false,
                            "message" => "Profile update failed."
                        ]);
                
                    }
                
                break;

          case 'ChangePassword':
               
            
                // Get existing password
                $sql = "SELECT user_passkey
                        FROM tbl_users
                        WHERE user_id = ?";
            
            
                $stmt = $this->varPDOModelObj->selectexecuteQuery(
                    $sql,
                    [$this->userId]
                );
            
            
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            
                if (!$user) {
            
                    echo json_encode([
                        "status" => false,
                        "message" => "User not found"
                    ]);
            
                    break;
                }
            
            
                // Check current password
                if ($user['user_passkey'] !== $this->current_password) {
            
                    echo json_encode([
                        "status" => false,
                        "message" => "Current password is incorrect"
                    ]);
            
                    break;
                }
            
            
                // Update password
                $sql_update = "UPDATE tbl_users
                               SET user_passkey = ?
                               WHERE user_id = ?";
            
            
                $result = $this->varPDOModelObj->UpdateTable(
                    $sql_update,
                    [
                        $this->new_password,
                        $this->userId
                    ]
                );
            
            
                echo json_encode([
                    "status" => true,
                    "message" => "Password changed successfully"
                ]);
            
            
            break;
                
              case 'LoadProfile':

                    $member_id = $_SESSION['user_id'];
                
                    $sql = "SELECT
                               u.user_id,
                                u.profile_name,
                                u.user_name,
                                u.user_passkey,
                                u.user_role_id,
                                u.user_role_name,
                                u.user_mobile,
                                u.user_email,
                                u.profile_image,
                                u.profile_image as profile_image_val,
                                u.user_status
                            FROM tbl_users u
                            WHERE u.user_id = :user_id";
                
                            $stmt = $this->varPDOModelObj->selectexecuteQuery($sql, [
                                ':user_id' => $member_id
                            ]);
                            
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            
                            if ($user) {
                            
                                if (!empty($user['profile_image'])) {
                                    $user['profile_image'] = $_ENV['BASE_URL'] .
                                        'assets/img/users/' . $user['profile_image'];
                                } else {
                                    $user['profile_image'] = $_ENV['BASE_URL'] .
                                        'assets/img/users/default.jpg';
                                }
                            
                                echo json_encode([
                                    'status' => true,
                                    'data'   => $user
                                ]);
                            
                            } else {
                            
                                echo json_encode([
                                    'status' => false,
                                    'message' => 'Profile not found.'
                                ]);
                            
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
}

$obj = new UsersController();
$obj->DataRequest($obj->actionevents);
