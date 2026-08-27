<?php
header('Content-Type: application/json');

class OutsourcingCompanyController
{
    private $pdoModelObj;
    public $action, $ids, $company_name, $cr_number, $address, $contact_person_name, $contact_person_number, $email_id, $status;
    public $company_id, $user_id;

    public function __construct()
    {
        $this->pdoModelObj = new CommonPDOModel();

        // Get raw POST payload or $_POST
        $rawInput = file_get_contents("php://input");
        $data = json_decode($rawInput, true);

        if (!is_array($data)) {
            $data = $_POST;
        }

        $this->action                = $data['action'] ?? $_GET['action'] ?? null;
        $this->ids                   = $data['ids'] ?? null;
        $this->company_name          = trim($data['company_name'] ?? '');
        $this->cr_number             = trim($data['cr_number'] ?? '');
        $this->address               = trim($data['address'] ?? '');
        $this->contact_person_name   = trim($data['contact_person_name'] ?? '');
        $this->contact_person_number = trim($data['contact_person_number'] ?? '');
        $this->email_id              = trim($data['email_id'] ?? '');
        $this->status                = $data['status'] ?? 'Active';

        $this->company_id            = $_SESSION['company_id'] ?? 1;
        $this->user_id               = $_SESSION['user_id'] ?? 1;
    }

    public function handleRequest()
    {
        switch ($this->action) {
            case 'add':
                $this->addCompany();
                break;

            case 'update':
                $this->updateCompany();
                break;

            case 'list':
                $this->listCompanies();
                break;

            case 'get':
                $this->getCompany();
                break;

            case 'update_status':
            case 'toggle_status':
                $this->updateStatus();
                break;

            default:
                echo json_encode([
                    'status'  => false,
                    'message' => 'Invalid action request.'
                ]);
                break;
        }
    }

    private function addCompany()
    {
        if (empty($this->company_name) || empty($this->cr_number)) {
            echo json_encode([
                'status'  => false,
                'message' => 'Company Name and CR Number are required fields.'
            ]);
            return;
        }

        $sql = "INSERT INTO tbl_outsourcing_companies
                (company_id, company_name, cr_number, address, contact_person_name, contact_person_number, email_id, status, created_on, created_by)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

        $params = [
            $this->company_id,
            $this->company_name,
            $this->cr_number,
            $this->address,
            $this->contact_person_name,
            $this->contact_person_number,
            $this->email_id,
            $this->status,
            $this->user_id
        ];

        $res = $this->pdoModelObj->ListFromTableAndReturnSpecifiedColumn ?? null;
        // Use standard PDO execution through pdoModelObj
        try {
            $stmt = $this->pdoModelObj->varDBPDO->prepare($sql);
            $success = $stmt->execute($params);
            if ($success) {
                echo json_encode([
                    'status'  => true,
                    'message' => 'Outsourcing Company added successfully!'
                ]);
            } else {
                echo json_encode([
                    'status'  => false,
                    'message' => 'Failed to add Outsourcing Company.'
                ]);
            }
        } catch (PDOException $e) {
            echo json_encode([
                'status'  => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }

    private function updateCompany()
    {
        if (empty($this->ids) || empty($this->company_name) || empty($this->cr_number)) {
            echo json_encode([
                'status'  => false,
                'message' => 'ID, Company Name, and CR Number are required.'
            ]);
            return;
        }

        $sql = "UPDATE tbl_outsourcing_companies SET
                company_name = ?,
                cr_number = ?,
                address = ?,
                contact_person_name = ?,
                contact_person_number = ?,
                email_id = ?,
                updated_on = NOW(),
                updated_by = ?
                WHERE ids = ?";

        $params = [
            $this->company_name,
            $this->cr_number,
            $this->address,
            $this->contact_person_name,
            $this->contact_person_number,
            $this->email_id,
            $this->user_id,
            $this->ids
        ];

        try {
            $stmt = $this->pdoModelObj->varDBPDO->prepare($sql);
            $success = $stmt->execute($params);
            if ($success) {
                echo json_encode([
                    'status'  => true,
                    'message' => 'Outsourcing Company updated successfully!'
                ]);
            } else {
                echo json_encode([
                    'status'  => false,
                    'message' => 'Failed to update Outsourcing Company.'
                ]);
            }
        } catch (PDOException $e) {
            echo json_encode([
                'status'  => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }

    private function listCompanies()
    {
        $sql = "SELECT * FROM tbl_outsourcing_companies ORDER BY ids DESC";
        try {
            $stmt = $this->pdoModelObj->varDBPDO->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                'status' => true,
                'data'   => $rows
            ]);
        } catch (PDOException $e) {
            echo json_encode([
                'status'  => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }

    private function getCompany()
    {
        if (empty($this->ids)) {
            echo json_encode([
                'status'  => false,
                'message' => 'Company ID is required.'
            ]);
            return;
        }

        $sql = "SELECT * FROM tbl_outsourcing_companies WHERE ids = ?";
        try {
            $stmt = $this->pdoModelObj->varDBPDO->prepare($sql);
            $stmt->execute([$this->ids]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                echo json_encode([
                    'status' => true,
                    'data'   => $row
                ]);
            } else {
                echo json_encode([
                    'status'  => false,
                    'message' => 'Record not found.'
                ]);
            }
        } catch (PDOException $e) {
            echo json_encode([
                'status'  => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }

    private function updateStatus()
    {
        if (empty($this->ids) || empty($this->status)) {
            echo json_encode([
                'status'  => false,
                'message' => 'Company ID and Status are required.'
            ]);
            return;
        }

        $newStatus = ($this->status === 'Active' || $this->status === '1') ? 'Active' : 'Inactive';

        $sql = "UPDATE tbl_outsourcing_companies SET
                status = ?,
                updated_on = NOW(),
                updated_by = ?
                WHERE ids = ?";

        try {
            $stmt = $this->pdoModelObj->varDBPDO->prepare($sql);
            $success = $stmt->execute([$newStatus, $this->user_id, $this->ids]);
            if ($success) {
                echo json_encode([
                    'status'  => true,
                    'message' => "Company status updated to {$newStatus}!"
                ]);
            } else {
                echo json_encode([
                    'status'  => false,
                    'message' => 'Failed to update status.'
                ]);
            }
        } catch (PDOException $e) {
            echo json_encode([
                'status'  => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }
}

$controller = new OutsourcingCompanyController();
$controller->handleRequest();
