<?php
header('Content-Type: application/json');

class CustomerController
{
    var $varPDOModelObj;
    public $actionevents, $json, $client_json, $status, $ids;
    public $customer_name, $customer_type, $telephone, $email, $cprcr, $cprexpiryDate, $attention, $address, $company_id, $params = [];
    public $nationality, $license_no, $license_issue_place, $license_expiry_date, $phone_1, $phone_2, $fax_no, $website, $vat_reg_no, $is_blacklisted, $blacklist_description, $customer_account_id;

    function __construct()
    {
        $this->varPDOModelObj = new CommonPDOModel();

        $this->json = file_get_contents("php://input");

        if (!$this->json) {
            echo json_encode([
                "status" => "error",
                "message" => "No input data received"
            ]);
            exit;
        }

        $data = json_decode($this->json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid JSON"
            ]);
            exit;
        }

        $this->status = $data['status'] ?? 'Active';
        $this->ids = $data['ids'] ?? null;

        $this->customer_name = $data['customer_name'] ?? null;
        $this->customer_type = $data['customer_type'] ?? null;
        $this->telephone = $data['telephone'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->cprcr = $data['cprcr'] ?? null;
        $this->cprexpiryDate = !empty($data['cprexpiryDate']) ? $data['cprexpiryDate'] : null;
        $this->attention = $data['attention'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->nationality = $data['nationality'] ?? null;
        $this->license_no = $data['license_no'] ?? null;
        $this->license_issue_place = $data['license_issue_place'] ?? null;
        $this->license_expiry_date = !empty($data['license_expiry_date']) ? $data['license_expiry_date'] : null;
        $this->phone_1 = $data['phone_1'] ?? null;
        $this->phone_2 = $data['phone_2'] ?? null;
        $this->fax_no = $data['fax_no'] ?? null;
        $this->website = $data['website'] ?? null;
        $this->vat_reg_no = $data['vat_reg_no'] ?? null;
        $this->is_blacklisted = !empty($data['is_blacklisted']) ? 1 : 0;
        $this->blacklist_description = $data['blacklist_description'] ?? null;
        $this->customer_account_id = !empty($data['customer_account_id']) ? (int)$data['customer_account_id'] : null;
        if ($this->is_blacklisted === 1) {
            $this->status = 'Blacklisted';
        }

        $this->client_json = isset($data['clientsDoc']) ? json_encode($data['clientsDoc']) : json_encode([]);
        $this->actionevents = $data['action'] ?? null;
        $this->company_id = $_SESSION['company_id'] ?? 1;
    }

    function SQLArray()
    {
        $array = array();
        $array[0] = "INSERT INTO customer_details 
                    (customer_name, customer_type, customer_account_id, customer_mobile, customer_email, customer_addr, customer_attn, customer_cr_cpr, cpr_expiry_date, nationality, license_no, license_issue_place, license_expiry_date, phone_1, phone_2, fax_no, website, vat_reg_no, status, is_blacklisted, blacklist_description, client_docs, company_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->params[0] = [
            $this->customer_name,
            $this->customer_type,
            $this->customer_account_id,
            $this->telephone,
            $this->email,
            $this->address,
            $this->attention,
            $this->cprcr,
            $this->cprexpiryDate,
            $this->nationality,
            $this->license_no,
            $this->license_issue_place,
            $this->license_expiry_date,
            $this->phone_1,
            $this->phone_2,
            $this->fax_no,
            $this->website,
            $this->vat_reg_no,
            $this->status,
            $this->is_blacklisted,
            $this->blacklist_description,
            $this->client_json,
            $this->company_id
        ];
        return $array;
    }

    function DataRequest($action)
    {
        $var = $this->SQLArray();
        switch ($action) {
            case 'AddNewCustomer':
                if (count($this->params[0]) !== 23) {
                    throw new Exception("Parameter count mismatch: " . count($this->params[0]));
                }
                $this->ReturnData = $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn($var[0], 'customer_id', 'customer_details', $this->params[0]);
                $ReturnArr = json_decode($this->ReturnData, true);
                if (isset($ReturnArr['status']) && $ReturnArr['status'] === true) {
                    $customer_id = json_decode(
                        $ReturnArr['data']['return_customer_id_value'],
                        true
                    )['data'][0]['customer_id'] ?? null;
    
                    Logger::ActivityLog('Action', "AddNewCustomer", ['CustomerController: AddNewCustomer', "Customer ID : " . $customer_id]);
                    echo json_encode([
                        'status' => true,
                        'message' => "Customer Added Successfully",
                        'customerId' => $customer_id
                    ]);
                } else {
                    echo json_encode([
                        'status' => false,
                        'message' => $ReturnArr['message'] ?? "Failed to add customer"
                    ]);
                }
                break;
            case 'update_status':
                $this->updateStatus();
                break;
            default:
                $val = json_encode([
                    'status' => false,
                    'message' => "No Action Found..! in CustomerController"
                ]);
                Logger::ActivityLog('Action', "AddNewCustomer", ['CustomerController: default', $val]);
                echo $val;
                break;
        }
    }

    private function updateStatus()
    {
        if (empty($this->ids) || empty($this->status)) {
            echo json_encode([
                'status' => false,
                'message' => 'ID and status are required.'
            ]);
            return;
        }
        $newStatus = ($this->status === 'Active' || $this->status === '1') ? 'Active' : 'Inactive';
        $sql = "UPDATE customer_details SET status = ?, updated_on = NOW() WHERE ids = ?";
        try {
            $stmt = $this->varPDOModelObj->varDBPDO->prepare($sql);
            $success = $stmt->execute([$newStatus, $this->ids]);
            if ($success) {
                echo json_encode(['status' => true, 'message' => "Customer status updated to {$newStatus}!"]);
            } else {
                echo json_encode(['status' => false, 'message' => 'Failed to update status.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
}

$obj = new CustomerController();
$obj->DataRequest($obj->actionevents);
?>
