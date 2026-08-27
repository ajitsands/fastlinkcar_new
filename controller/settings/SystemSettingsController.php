<?php
header('Content-Type: application/json');

if (!class_exists('CommonPDOModel')) {
    require_once ROOT_PATH . '/model/common/pdoCommonFunctions.php';
}

class SystemSettingsController
{
    private $pdoModelObj;
    public $company_id;

    public function __construct()
    {
        $this->pdoModelObj = new CommonPDOModel();
        $this->company_id = $_SESSION['company_id'] ?? 1;

        $rawInput = file_get_contents("php://input");
        $data = json_decode($rawInput, true);

        if (!is_array($data)) {
            $data = array_merge($_GET, $_POST);
        }

        $action = $data['action'] ?? null;

        if ($action === 'get_settings') {
            $this->getSettings();
        } elseif ($action === 'save_settings') {
            $this->saveSettings($data);
        }
    }

    public function getSettings()
    {
        try {
            $sql = "SELECT * FROM tbl_system_settings WHERE company_id = '{$this->company_id}' LIMIT 1";
            $stmt = $this->pdoModelObj->selectexecuteQuery($sql);
            $rows = ($stmt && $stmt instanceof PDOStatement) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
            $data = !empty($rows) ? $rows[0] : [
                'company_id' => $this->company_id,
                'vat_percentage' => '10.00',
                'timezone' => 'Asia/Bahrain',
                'date_format' => 'Y-m-d',
                'currency_code' => 'BHD',
                'currency_symbol' => 'BD'
            ];

            echo json_encode([
                'status' => true,
                'success' => true,
                'data' => $data
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => false,
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    public function saveSettings($requestData = [])
    {
        try {
            $data = !empty($requestData) ? $requestData : $_POST;

            $vat_percentage = floatval($data['vat_percentage'] ?? 10.00);
            $timezone = trim($data['timezone'] ?? 'Asia/Bahrain');
            $date_format = trim($data['date_format'] ?? 'Y-m-d');
            $currency_code = trim($data['currency_code'] ?? 'BHD');
            $currency_symbol = trim($data['currency_symbol'] ?? 'BD');
            $user_id = $_SESSION['user_id'] ?? 1;

            // Check if settings record exists
            $checkSql = "SELECT COUNT(*) as count FROM tbl_system_settings WHERE company_id = '{$this->company_id}'";
            $checkStmt = $this->pdoModelObj->selectexecuteQuery($checkSql);
            $checkRows = ($checkStmt && $checkStmt instanceof PDOStatement) ? $checkStmt->fetchAll(PDO::FETCH_ASSOC) : [];
            $exists = (!empty($checkRows) && intval($checkRows[0]['count']) > 0);

            if ($exists) {
                $updateSql = "UPDATE tbl_system_settings SET 
                    vat_percentage = '{$vat_percentage}',
                    timezone = '{$timezone}',
                    date_format = '{$date_format}',
                    currency_code = '{$currency_code}',
                    currency_symbol = '{$currency_symbol}',
                    updated_by = '{$user_id}'
                    WHERE company_id = '{$this->company_id}'";
                $this->pdoModelObj->UpdateTable($updateSql);
            } else {
                $insertSql = "INSERT INTO tbl_system_settings 
                    (company_id, vat_percentage, timezone, date_format, currency_code, currency_symbol, updated_by)
                    VALUES ('{$this->company_id}', '{$vat_percentage}', '{$timezone}', '{$date_format}', '{$currency_code}', '{$currency_symbol}', '{$user_id}')";
                $this->pdoModelObj->AddToTable($insertSql);
            }

            echo json_encode([
                'status' => true,
                'success' => true,
                'message' => 'System settings updated successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => false,
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }
}

$controller = new SystemSettingsController();
