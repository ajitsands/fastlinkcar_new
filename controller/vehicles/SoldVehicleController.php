<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');

require_once ROOT_PATH . '/model/db_connection/pdo_db_connection.php';
require_once ROOT_PATH . '/model/common/pdoCommonFunctions.php';

class SoldVehicleController
{
    private $pdo;
    private $commonModel;

    public function __construct()
    {
        $this->commonModel = new CommonPDOModel();
        $this->pdo = $this->commonModel->varDBPDO;
        $this->ensureTable();
    }

    private function ensureTable()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS `tbl_vehicle_sales` (
              `ids` int(11) NOT NULL AUTO_INCREMENT,
              `vehicle_id` int(11) NOT NULL,
              `company_id` int(11) DEFAULT '1',
              `vehicle_number` varchar(100) DEFAULT NULL,
              `car_type` varchar(255) DEFAULT NULL,
              `model_year` int(11) DEFAULT NULL,
              `car_color` varchar(100) DEFAULT NULL,
              `sale_date` date NOT NULL,
              `mileage_km` int(11) DEFAULT NULL,
              `buyer_name` varchar(255) NOT NULL,
              `cpr_id_number` varchar(100) DEFAULT NULL,
              `contact_phone` varchar(50) DEFAULT NULL,
              `contact_mobile` varchar(50) DEFAULT NULL,
              `email` varchar(150) DEFAULT NULL,
              `sale_amount` decimal(12,3) NOT NULL DEFAULT '0.000',
              `note` text,
              `created_by` int(11) DEFAULT NULL,
              `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`ids`),
              KEY `idx_vs_vehicle_id` (`vehicle_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }

    private function getAllowedCompanies()
    {
        $allowed = [];
        if (!empty($_SESSION['company_json'])) {
            $arr = json_decode($_SESSION['company_json'], true);
            if (is_array($arr)) {
                $allowed = array_map('intval', array_column($arr, 'ids'));
            }
        }
        if (empty($allowed)) {
            $allowed = [!empty($_SESSION['company_id']) ? (int)$_SESSION['company_id'] : 1];
        }
        return $allowed;
    }

    public function handleRequest()
    {
        $raw = file_get_contents('php://input');
        $json = json_decode($raw, true);
        $input = is_array($json) && !empty($json) ? $json : $_POST;
        $action = $input['action'] ?? ($_GET['action'] ?? '');

        switch ($action) {
            case 'list_available_vehicles':
                $this->listAvailableVehicles();
                break;
            case 'list_sold_vehicles':
                $this->listSoldVehicles();
                break;
            case 'save_sale':
                $this->saveSale($input);
                break;
            case 'delete_sale':
                $this->deleteSale($input);
                break;
            default:
                echo json_encode(['status' => false, 'message' => 'Invalid action']);
                break;
        }
    }

    private function listAvailableVehicles()
    {
        $allowed = $this->getAllowedCompanies();
        $inQ = implode(',', array_fill(0, count($allowed), '?'));
        $sql = "
            SELECT v.ids, v.vehicle_number, v.model_names, v.vehicle_year, v.vehicle_color,
                   v.mileage_km, v.vehicle_status, v.company_id,
                   COALESCE(b.brand_name, '') AS brand_name
            FROM tbl_vehicles v
            LEFT JOIN tbl_vehicle_brand b ON b.ids = v.brand_id
            WHERE v.company_id IN ($inQ)
              AND COALESCE(v.vehicle_status, 'Available') NOT IN ('Sale Out', 'Sold', 'Rentout', 'Staff Use')
            ORDER BY v.vehicle_number ASC
        ";
        $st = $this->pdo->prepare($sql);
        $st->execute($allowed);
        echo json_encode(['status' => true, 'data' => $st->fetchAll(PDO::FETCH_ASSOC)]);
    }

    private function listSoldVehicles()
    {
        $allowed = $this->getAllowedCompanies();
        $inQ = implode(',', array_fill(0, count($allowed), '?'));
        $sql = "
            SELECT s.*, c.company_name
            FROM tbl_vehicle_sales s
            LEFT JOIN tbl_company c ON c.ids = s.company_id
            WHERE s.company_id IN ($inQ)
            ORDER BY s.sale_date DESC, s.ids DESC
        ";
        $st = $this->pdo->prepare($sql);
        $st->execute($allowed);
        echo json_encode(['status' => true, 'data' => $st->fetchAll(PDO::FETCH_ASSOC)]);
    }

    private function saveSale($input)
    {
        $saleId        = (int)($input['ids'] ?? 0);
        $vehicleId     = (int)($input['vehicle_id'] ?? 0);
        $saleDate      = trim((string)($input['sale_date'] ?? ''));
        $mileageKm     = isset($input['mileage_km']) && $input['mileage_km'] !== '' ? (int)$input['mileage_km'] : null;
        $buyerName     = trim((string)($input['buyer_name'] ?? ''));
        $cprIdNumber   = trim((string)($input['cpr_id_number'] ?? ''));
        $contactPhone  = trim((string)($input['contact_phone'] ?? ''));
        $contactMobile = trim((string)($input['contact_mobile'] ?? ''));
        $email         = trim((string)($input['email'] ?? ''));
        $saleAmount    = isset($input['sale_amount']) && $input['sale_amount'] !== '' ? round((float)$input['sale_amount'], 3) : -1;
        $note          = trim((string)($input['note'] ?? ''));
        $userId        = (int)($_SESSION['user_id'] ?? 1);

        if ($vehicleId <= 0 || $saleDate === '' || $buyerName === '' || $saleAmount < 0) {
            echo json_encode(['status' => false, 'message' => 'Car No., Sale Date, Buyer Name, and Sale Amount are required.']);
            return;
        }

        $stVeh = $this->pdo->prepare("
            SELECT v.ids, v.company_id, v.vehicle_number, v.model_names, v.vehicle_year, v.vehicle_color, v.vehicle_status,
                   COALESCE(b.brand_name, '') AS brand_name
            FROM tbl_vehicles v
            LEFT JOIN tbl_vehicle_brand b ON b.ids = v.brand_id
            WHERE v.ids = ?
            LIMIT 1
        ");
        $stVeh->execute([$vehicleId]);
        $veh = $stVeh->fetch(PDO::FETCH_ASSOC);
        if (!$veh) {
            echo json_encode(['status' => false, 'message' => 'Selected vehicle not found.']);
            return;
        }

        $carType = trim(($veh['brand_name'] ? $veh['brand_name'] . ' - ' : '') . ($veh['model_names'] ?? ''));
        $oldStatus = $veh['vehicle_status'] ?? 'Available';

        if ($saleId === 0 && in_array($oldStatus, ['Rentout', 'Staff Use'], true)) {
            echo json_encode(['status' => false, 'message' => 'Cannot mark a currently rented / staff-use vehicle as Sold. Return it first.']);
            return;
        }

        try {
            $this->pdo->beginTransaction();

            if ($saleId > 0) {
                $stUpdSale = $this->pdo->prepare("
                    UPDATE tbl_vehicle_sales
                    SET sale_date = ?, mileage_km = ?, buyer_name = ?, cpr_id_number = ?,
                        contact_phone = ?, contact_mobile = ?, email = ?, sale_amount = ?, note = ?
                    WHERE ids = ?
                ");
                $stUpdSale->execute([
                    $saleDate, $mileageKm, $buyerName, $cprIdNumber ?: null,
                    $contactPhone ?: null, $contactMobile ?: null, $email ?: null, $saleAmount, $note ?: null, $saleId
                ]);
            } else {
                $stInsSale = $this->pdo->prepare("
                    INSERT INTO tbl_vehicle_sales
                    (vehicle_id, company_id, vehicle_number, car_type, model_year, car_color, sale_date, mileage_km, buyer_name, cpr_id_number, contact_phone, contact_mobile, email, sale_amount, note, created_by)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stInsSale->execute([
                    $vehicleId,
                    (int)$veh['company_id'],
                    $veh['vehicle_number'],
                    $carType,
                    !empty($veh['vehicle_year']) ? (int)$veh['vehicle_year'] : null,
                    $veh['vehicle_color'] ?? null,
                    $saleDate,
                    $mileageKm,
                    $buyerName,
                    $cprIdNumber ?: null,
                    $contactPhone ?: null,
                    $contactMobile ?: null,
                    $email ?: null,
                    $saleAmount,
                    $note ?: null,
                    $userId
                ]);
                $saleId = (int)$this->pdo->lastInsertId();
            }

            // Automatically convert vehicle status to Sale Out
            $formattedSaleDate = date('d M Y', strtotime($saleDate));
            $statusNote = "Sold to {$buyerName} on {$formattedSaleDate} for " . number_format($saleAmount, 3) . " BHD" . ($note !== '' ? " ({$note})" : '');
            $stUpdVeh = $this->pdo->prepare("
                UPDATE tbl_vehicles
                SET vehicle_status = 'Sale Out',
                    is_active = 0,
                    mileage_km = COALESCE(?, mileage_km),
                    vehicle_status_notes = ?
                WHERE ids = ?
            ");
            $stUpdVeh->execute([$mileageKm, $statusNote, $vehicleId]);

            if ($oldStatus !== 'Sale Out') {
                $this->commonModel->logVehicleMovement([
                    'vehicle_id' => $vehicleId,
                    'action_type' => 'Vehicle Sold',
                    'old_status' => $oldStatus,
                    'new_status' => 'Sale Out',
                    'reference_type' => 'Vehicle Sale',
                    'reference_id' => $saleId,
                    'reference_no' => $veh['vehicle_number'],
                    'odometer' => $mileageKm,
                    'remarks' => $statusNote
                ]);
            }

            $this->pdo->commit();
            echo json_encode([
                'status' => true,
                'message' => 'Vehicle marked as Sale Out and status updated automatically.'
            ]);
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            echo json_encode(['status' => false, 'message' => 'Error saving sale: ' . $e->getMessage()]);
        }
    }

    private function deleteSale($input)
    {
        $saleId = (int)($input['ids'] ?? 0);
        if ($saleId <= 0) {
            echo json_encode(['status' => false, 'message' => 'Invalid sale ID.']);
            return;
        }
        $st = $this->pdo->prepare("SELECT * FROM tbl_vehicle_sales WHERE ids = ? LIMIT 1");
        $st->execute([$saleId]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            echo json_encode(['status' => false, 'message' => 'Sale record not found.']);
            return;
        }

        try {
            $this->pdo->beginTransaction();
            $this->pdo->prepare("DELETE FROM tbl_vehicle_sales WHERE ids = ?")->execute([$saleId]);
            $this->pdo->prepare("UPDATE tbl_vehicles SET vehicle_status = 'Available', is_active = 1, vehicle_status_notes = NULL WHERE ids = ?")->execute([(int)$row['vehicle_id']]);

            $this->commonModel->logVehicleMovement([
                'vehicle_id' => (int)$row['vehicle_id'],
                'action_type' => 'Sale Reverted',
                'old_status' => 'Sale Out',
                'new_status' => 'Available',
                'reference_type' => 'Vehicle Sale',
                'reference_id' => $saleId,
                'reference_no' => $row['vehicle_number'],
                'remarks' => 'Vehicle sale reverted; status restored to Available.'
            ]);
            $this->pdo->commit();
            echo json_encode(['status' => true, 'message' => 'Sale reverted and vehicle status restored to Available.']);
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            echo json_encode(['status' => false, 'message' => 'Error reverting sale: ' . $e->getMessage()]);
        }
    }
}

$ctrl = new SoldVehicleController();
$ctrl->handleRequest();
