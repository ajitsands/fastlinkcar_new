<?php
header('Content-Type: application/json');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class VehicleReplacementController
{
    private $varPDOModelObj;
    private $userId;
    private $userName;
    private $companyId;

    public function __construct()
    {
        $this->varPDOModelObj = new CommonPDOModel();
        $this->userId = $_SESSION['user_id'] ?? 1;
        $this->userName = $_SESSION['user_name'] ?? ($_SESSION['username'] ?? ($_SESSION['full_name'] ?? 'Staff'));
        $this->companyId = $_SESSION['company_id'] ?? 1;

        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);
        if (!is_array($data)) {
            $data = $_POST ?: $_GET;
        }

        $action = $data['action'] ?? '';
        switch ($action) {
            case 'initData':
                $this->initData($data);
                break;
            case 'getAvailableVehicles':
                $this->getAvailableVehicles($data);
                break;
            case 'saveReplacement':
                $this->saveReplacement($data);
                break;
            default:
                echo json_encode(['status' => false, 'message' => 'Invalid action']);
                break;
        }
    }

    private function formatVehicleRow(array $r): array
    {
        $other = !empty($r['other_details_json']) ? (json_decode($r['other_details_json'], true) ?: []) : [];
        $r['odo_meter'] = $other['current_km'] ?? ($other['odo_meter'] ?? ($other['km'] ?? 0));
        $r['fuel_level'] = $other['fuel_level'] ?? ($other['fuel'] ?? '');
        $r['fuel_type'] = $other['vehicleFuelType'] ?? ($other['fuel_type'] ?? ($other['fuel'] ?? 'Petrol'));
        $r['gear_type'] = $other['gear_type'] ?? ($other['transmission'] ?? 'Automatic');
        $r['chassis_number'] = $r['chassis_number'] ?? ($other['chassis_number'] ?? ($other['chassis_no'] ?? 'N/A'));

        $insDate = !empty($r['next_insurance_date']) ? $r['next_insurance_date'] : ($other['next_insurance_date'] ?? ($other['insurance_date'] ?? ''));
        $passDate = !empty($r['next_passing_date']) ? $r['next_passing_date'] : ($other['next_passing_date'] ?? ($other['passing_date'] ?? ''));
        $r['next_insurance_date'] = $insDate ?: '';
        $r['next_passing_date'] = $passDate ?: '';

        $lastImage = '';
        if (!empty($r['image_json'])) {
            $imgs = json_decode($r['image_json'], true);
            if (is_array($imgs) && count($imgs) > 0) {
                $lastImage = end($imgs);
            }
        }
        if (empty($lastImage) && !empty($other['vehicle_images'])) {
            $imgs = is_array($other['vehicle_images']) ? $other['vehicle_images'] : json_decode($other['vehicle_images'], true);
            if (is_array($imgs) && count($imgs) > 0) {
                $lastImage = end($imgs);
            }
        }
        $r['last_image'] = $lastImage;
        return $r;
    }

    private function fetchAvailableVehiclesList($categoryId = '', $modelId = ''): array
    {
        $where = ["v.vehicle_status = 'Available'"];
        $params = [];

        if (!empty($categoryId) && is_numeric($categoryId)) {
            $catId = intval($categoryId);
            $where[] = "(v.category_id = :cat_id OR m.category_id = :cat_id)";
            $params[':cat_id'] = $catId;
        }
        if (!empty($modelId) && is_numeric($modelId)) {
            $modId = intval($modelId);
            $where[] = "v.model_id = :mod_id";
            $params[':mod_id'] = $modId;
        }

        $sql = "
            SELECT
                v.ids,
                v.vehicle_number,
                COALESCE(v.category_id, m.category_id) AS vehicle_category_id,
                v.model_id AS vehicle_model_id,
                v.vehicle_color,
                v.vehicle_year,
                v.vehicle_status,
                v.next_insurance_date,
                v.next_passing_date,
                v.other_details_json,
                v.image_json,
                COALESCE(c.category_name, (SELECT category_name FROM tbl_vehicle_category WHERE ids = m.category_id)) AS category_name,
                m.modal_name AS model_name
            FROM tbl_vehicles v
            LEFT JOIN tbl_vehicle_category c ON c.ids = v.category_id
            LEFT JOIN tbl_vehicle_model m ON m.ids = v.model_id
            WHERE " . implode(' AND ', $where) . "
            ORDER BY v.vehicle_number ASC
        ";

        $stmt = !empty($params)
            ? $this->varPDOModelObj->selectexecuteQuery($sql, $params)
            : $this->varPDOModelObj->selectexecuteQuery($sql);

        $list = [];
        if ($stmt) {
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
                $list[] = $this->formatVehicleRow($r);
            }
        }
        return $list;
    }

    private function initData(array $data): void
    {
        try {
            // 1. Active Rentout Contracts with vehicle & customer details
            $sqlContracts = "
                SELECT
                    ct.ids,
                    ct.agreement_no,
                    ct.customer_code,
                    ct.vehicle_id,
                    ct.vehicle_no,
                    ct.vehicle_category_id,
                    ct.vehicle_model_id,
                    ct.agreement_date,
                    ct.service_start_date_time,
                    ct.service_end_date_time,
                    ct.km_out,
                    ct.agreement_status,
                    ct.contract_details_json,
                    ct.vechile_details,
                    ct.vehicle_accessories_details,
                    ct.vehicle_rentout_images,
                    ct.replaced_vehicle_json,
                    ct.company_id,
                    cd.customer_name,
                    cd.customer_cr_cpr,
                    cd.customer_mobile,
                    v.vehicle_number,
                    v.vehicle_color,
                    v.vehicle_year,
                    v.vehicle_status,
                    v.next_insurance_date,
                    v.next_passing_date,
                    v.other_details_json,
                    v.image_json,
                    COALESCE(cat.category_name, (SELECT category_name FROM tbl_vehicle_category WHERE ids = mdl.category_id)) AS category_name,
                    mdl.modal_name AS model_name,
                    comp.company_name
                FROM tbl_vehicle_rentout_contracts ct
                LEFT JOIN customer_details cd ON cd.customer_id = ct.customer_code
                LEFT JOIN tbl_vehicles v ON v.ids = ct.vehicle_id
                LEFT JOIN tbl_vehicle_category cat ON cat.ids = COALESCE(v.category_id, ct.vehicle_category_id)
                LEFT JOIN tbl_vehicle_model mdl ON mdl.ids = COALESCE(v.model_id, ct.vehicle_model_id)
                LEFT JOIN tbl_company comp ON comp.ids = ct.company_id
                WHERE LOWER(ct.agreement_status) = 'rentout'
                ORDER BY ct.ids DESC
            ";
            $stmtC = $this->varPDOModelObj->selectexecuteQuery($sqlContracts);
            $contracts = $stmtC ? $stmtC->fetchAll(PDO::FETCH_ASSOC) : [];

            // Batch fetch last invoice date per contract from tbl_customer_ledger
            $lastInvoices = [];
            try {
                $stmtInv = $this->varPDOModelObj->selectexecuteQuery("
                    SELECT contract_ids, MAX(trans_date) AS last_inv_date
                    FROM tbl_customer_ledger
                    WHERE contract_ids IS NOT NULL AND contract_ids != ''
                      AND (trans_type LIKE '%Invoice%' OR ref_no LIKE 'INV%')
                    GROUP BY contract_ids
                ");
                if ($stmtInv) {
                    foreach ($stmtInv->fetchAll(PDO::FETCH_ASSOC) as $ir) {
                        $lastInvoices[(string)$ir['contract_ids']] = $ir['last_inv_date'];
                    }
                }
            } catch (\Exception $e) {}

            $formattedContracts = [];
            foreach ($contracts as $c) {
                $cdj = !empty($c['contract_details_json']) ? (json_decode($c['contract_details_json'], true) ?: []) : [];
                $vehDetailsJson = !empty($c['vechile_details']) ? (json_decode($c['vechile_details'], true) ?: []) : [];
                $vehFormatted = $this->formatVehicleRow($c);

                $replList = !empty($c['replaced_vehicle_json']) ? (json_decode($c['replaced_vehicle_json'], true) ?: []) : [];
                $totalReplacements = is_array($replList) ? count($replList) : 0;
                $lastReplacementDate = '';
                if ($totalReplacements > 0) {
                    $lastNode = end($replList);
                    $lastReplacementDate = $lastNode['replaced_on'] ?? ($lastNode['new_vehicle']['dt_out'] ?? '');
                }

                $formattedContracts[] = [
                    'contract_id'           => $c['ids'],
                    'agreement_no'          => $c['agreement_no'] ?? '',
                    'ra_location'           => $cdj['ra_location'] ?? ($cdj['branch_name'] ?? ($c['company_name'] ?? 'Main Branch')),
                    'customer_code'         => $c['customer_code'] ?? '',
                    'customer_cpr'          => $c['customer_cr_cpr'] ?? '',
                    'customer_name'         => $c['customer_name'] ?? '',
                    'customer_mobile'       => $c['customer_mobile'] ?? '',
                    'fuel_level_out'        => $cdj['fuel_out'] ?? ($cdj['fuel_level'] ?? ($vehFormatted['fuel_level'] ?? '')),
                    'agreement_date'        => $c['service_start_date_time'] ?? ($c['agreement_date'] ?? ''),
                    'expected_return_date'  => $c['service_end_date_time'] ?? '',
                    'rental_amount'         => number_format((float)($cdj['total_amount'] ?? ($cdj['total_amt'] ?? ($cdj['grand_total'] ?? ($cdj['rental_amount'] ?? 0)))), 3, '.', ''),
                    'last_replacement_date' => $lastReplacementDate,
                    'total_replacement'     => $totalReplacements,
                    'last_invoice_date'     => $lastInvoices[(string)$c['ids']] ?? '',
                    'vehicle_id'            => $c['vehicle_id'],
                    'vehicle_no'            => $c['vehicle_number'] ?: ($c['vehicle_no'] ?? ($vehDetailsJson['veh_no'] ?? '')),
                    'category_id'           => $c['vehicle_category_id'] ?? '',
                    'model_id'              => $c['vehicle_model_id'] ?? '',
                    'category_name'         => $c['category_name'] ?? ($vehDetailsJson['category_name'] ?? ''),
                    'model_name'            => $c['model_name'] ?? ($vehDetailsJson['model_name'] ?? ''),
                    'vehicle_year'          => $c['vehicle_year'] ?? ($vehDetailsJson['vehicle_year'] ?? ''),
                    'vehicle_color'         => $c['vehicle_color'] ?? ($vehDetailsJson['vehicle_color'] ?? ''),
                    'km_out'                => $c['km_out'] ?? ($vehFormatted['odo_meter'] ?? 0),
                    'chassis_number'        => $vehFormatted['chassis_number'],
                    'fuel_type'             => $vehFormatted['fuel_type'],
                    'gear_type'             => $vehFormatted['gear_type'],
                    'next_insurance_date'   => $vehFormatted['next_insurance_date'],
                    'next_passing_date'     => $vehFormatted['next_passing_date'],
                    'last_image'            => $vehFormatted['last_image'],
                    'vehicle_status'        => $c['vehicle_status'] ?? 'Rentout',
                    'old_accessories'       => !empty($c['vehicle_accessories_details']) ? (json_decode($c['vehicle_accessories_details'], true) ?: []) : [],
                    'old_rentout_images'    => !empty($c['vehicle_rentout_images']) ? (json_decode($c['vehicle_rentout_images'], true) ?: []) : [],
                ];
            }

            // 2. Categories & Models
            $stmtCat = $this->varPDOModelObj->selectexecuteQuery("SELECT ids, category_name FROM tbl_vehicle_category ORDER BY category_name ASC");
            $categories = $stmtCat ? $stmtCat->fetchAll(PDO::FETCH_ASSOC) : [];

            $stmtMod = $this->varPDOModelObj->selectexecuteQuery("SELECT ids, modal_name AS model_name, category_id FROM tbl_vehicle_model ORDER BY modal_name ASC");
            $models = $stmtMod ? $stmtMod->fetchAll(PDO::FETCH_ASSOC) : [];

            // 3. Available Vehicles
            $availableVehicles = $this->fetchAvailableVehiclesList();

            echo json_encode([
                'status'             => true,
                'contracts'          => $formattedContracts,
                'categories'         => $categories,
                'models'             => $models,
                'available_vehicles' => $availableVehicles,
                'replaced_by'        => $this->userName,
            ]);
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    private function getAvailableVehicles(array $data): void
    {
        try {
            $list = $this->fetchAvailableVehiclesList($data['category_id'] ?? '', $data['model_id'] ?? '');
            echo json_encode(['status' => true, 'data' => $list]);
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    private function saveReplacement(array $data): void
    {
        try {
            $agreementId = intval($data['agreement_id'] ?? 0);
            $newVehId = intval($data['new_vehicle_id'] ?? 0);
            $parkingLocationIn = trim($data['parking_location_in'] ?? 'Main Parking') ?: 'Main Parking';
            $checkInType = trim($data['check_in_type'] ?? 'Replacement');
            $outLocation = trim($data['out_location'] ?? 'Main Parking') ?: 'Main Parking';
            $replacementDate = trim($data['replacement_date'] ?? date('Y-m-d'));
            $replacementTime = trim($data['replacement_time'] ?? date('H:i'));
            $reason = trim($data['reason'] ?? '');
            $staffName = trim($data['staff_name'] ?? $this->userName);
            $staffSignature = trim($data['staff_signature'] ?? '');
            $oldAccessories = is_array($data['old_accessories'] ?? null) ? $data['old_accessories'] : [];
            $newAccessories = is_array($data['new_accessories'] ?? null) ? $data['new_accessories'] : [];
            $oldReturnImages = is_array($data['old_return_images'] ?? null) ? $data['old_return_images'] : [];
            $newRentoutImages = is_array($data['new_rentout_images'] ?? null) ? $data['new_rentout_images'] : [];

            if (empty($agreementId)) {
                echo json_encode(['status' => false, 'message' => 'Please select a current vehicle / agreement.']);
                return;
            }
            if (empty($newVehId)) {
                echo json_encode(['status' => false, 'message' => 'Please select a replacement vehicle.']);
                return;
            }
            if ($replacementDate === '') {
                echo json_encode(['status' => false, 'message' => 'Please select Replacement Date.']);
                return;
            }
            if ($staffName === '' || $staffSignature === '') {
                echo json_encode(['status' => false, 'message' => 'Please provide the concerned staff name and signature.']);
                return;
            }

            $stmtContract = $this->varPDOModelObj->selectexecuteQuery(
                "SELECT ct.*, c.category_name, m.modal_name AS model_name
                 FROM tbl_vehicle_rentout_contracts ct
                 LEFT JOIN tbl_vehicle_category c ON c.ids = ct.vehicle_category_id
                 LEFT JOIN tbl_vehicle_model m ON m.ids = ct.vehicle_model_id
                 WHERE ct.ids = :id",
                [':id' => $agreementId]
            );
            $contractRow = $stmtContract ? $stmtContract->fetch(PDO::FETCH_ASSOC) : null;
            if (!$contractRow) {
                echo json_encode(['status' => false, 'message' => 'Contract not found.']);
                return;
            }
            if (strtolower($contractRow['agreement_status']) !== 'rentout') {
                echo json_encode(['status' => false, 'message' => 'Vehicle replacement is only allowed for active Rentout contracts.']);
                return;
            }

            $stmtNewVeh = $this->varPDOModelObj->selectexecuteQuery(
                "SELECT v.*, c.category_name, m.modal_name AS model_name
                 FROM tbl_vehicles v
                 LEFT JOIN tbl_vehicle_category c ON c.ids = v.category_id
                 LEFT JOIN tbl_vehicle_model m ON m.ids = v.model_id
                 WHERE v.ids = :id",
                [':id' => $newVehId]
            );
            $newVehRow = $stmtNewVeh ? $stmtNewVeh->fetch(PDO::FETCH_ASSOC) : null;
            if (!$newVehRow) {
                echo json_encode(['status' => false, 'message' => 'Replacement vehicle not found.']);
                return;
            }
            if (strtolower($newVehRow['vehicle_status']) !== 'available') {
                echo json_encode(['status' => false, 'message' => 'Selected replacement vehicle is no longer Available.']);
                return;
            }

            $oldVehId = intval($contractRow['vehicle_id']);
            $oldVehNo = $contractRow['vehicle_no'] ?? '';
            $oldCatId = $contractRow['vehicle_category_id'] ?? '';
            $oldModelId = $contractRow['vehicle_model_id'] ?? '';
            $agreementNo = $contractRow['agreement_no'] ?? '';
            $custCode = $contractRow['customer_code'] ?? '';

            $replDateTime = $replacementDate . ' ' . ($replacementTime !== '' ? $replacementTime . ':00' : date('H:i:s'));

            // 1. Update Old Vehicle -> Parking
            $oldKmOut = floatval($contractRow['km_out'] ?? 0);
            $oldKmIn = isset($data['km_in']) && $data['km_in'] !== '' ? floatval($data['km_in']) : $oldKmOut;
            $oldKmUsed = max(0, $oldKmIn - $oldKmOut);
            $oldFuelIn = trim($data['fuel_level_in'] ?? '');
            $oldDtOut = $contractRow['service_start_date_time'] ?? ($contractRow['agreement_date'] ?? date('Y-m-d H:i:s'));

            $stmtOldOther = $this->varPDOModelObj->selectexecuteQuery("SELECT other_details_json FROM tbl_vehicles WHERE ids = :id", [':id' => $oldVehId]);
            $oldOtherRow = $stmtOldOther ? $stmtOldOther->fetch(PDO::FETCH_ASSOC) : null;
            $oldOtherJson = !empty($oldOtherRow['other_details_json']) ? (json_decode($oldOtherRow['other_details_json'], true) ?: []) : [];
            $oldOtherJson['current_km'] = $oldKmIn;
            if ($oldFuelIn !== '') {
                $oldOtherJson['fuel_level'] = $oldFuelIn;
            }
            $oldOtherJson['parking_location'] = $parkingLocationIn;

            $this->varPDOModelObj->executeQuery(
                "UPDATE tbl_vehicles SET vehicle_status = 'Parking', other_details_json = :oth WHERE ids = :id",
                [':oth' => json_encode($oldOtherJson), ':id' => $oldVehId]
            );

            $this->varPDOModelObj->logVehicleMovement([
                'vehicle_id'     => $oldVehId,
                'action_type'    => 'Replace Return',
                'old_status'     => 'Rentout',
                'new_status'     => 'Parking',
                'reference_type' => 'Agreement',
                'reference_id'   => $agreementId,
                'reference_no'   => $agreementNo,
                'location_from'  => 'Customer',
                'location_to'    => $parkingLocationIn,
                'staff_id'       => $this->userId,
                'customer_id'    => $custCode,
                'garage_id'      => null,
                'odometer'       => $oldKmIn,
                'fuel_level'     => $oldFuelIn,
                'remarks'        => '[' . $checkInType . '] ' . ($reason !== '' ? $reason : 'Vehicle replacement')
            ]);

            // 2. Update New Vehicle -> Rentout
            $newVehNo = $newVehRow['vehicle_number'] ?? '';
            $newCatId = $newVehRow['category_id'] ?? '';
            $newModelId = $newVehRow['model_id'] ?? '';
            $newOtherJson = !empty($newVehRow['other_details_json']) ? (json_decode($newVehRow['other_details_json'], true) ?: []) : [];
            $newKmOut = isset($data['km_out']) && $data['km_out'] !== '' ? floatval($data['km_out']) : floatval($newOtherJson['current_km'] ?? 0);
            $newFuelOut = trim($data['fuel_level_out'] ?? ($newOtherJson['fuel_level'] ?? ''));

            $this->varPDOModelObj->executeQuery(
                "UPDATE tbl_vehicles SET vehicle_status = 'Rentout' WHERE ids = :id",
                [':id' => $newVehId]
            );

            $this->varPDOModelObj->logVehicleMovement([
                'vehicle_id'     => $newVehId,
                'action_type'    => 'Replace Rentout',
                'old_status'     => 'Available',
                'new_status'     => 'Rentout',
                'reference_type' => 'Agreement',
                'reference_id'   => $agreementId,
                'reference_no'   => $agreementNo,
                'location_from'  => $outLocation ?: 'Main Parking',
                'location_to'    => 'Customer',
                'staff_id'       => $this->userId,
                'customer_id'    => $custCode,
                'garage_id'      => null,
                'odometer'       => $newKmOut,
                'fuel_level'     => $newFuelOut,
                'remarks'        => 'Assigned on contract replacement' . ($reason !== '' ? ': ' . $reason : '')
            ]);

            // 3. Append replacement record to replaced_vehicle_json
            try {
                $checkCol = $this->varPDOModelObj->selectexecuteQuery("SHOW COLUMNS FROM tbl_vehicle_rentout_contracts LIKE 'replaced_vehicle_json'");
                if ($checkCol && $checkCol->rowCount() == 0) {
                    $this->varPDOModelObj->executeQuery("ALTER TABLE tbl_vehicle_rentout_contracts ADD COLUMN replaced_vehicle_json LONGTEXT NULL");
                }
            } catch (\Exception $colEx) {}

            $existingReplacedList = !empty($contractRow['replaced_vehicle_json'])
                ? (json_decode($contractRow['replaced_vehicle_json'], true) ?: [])
                : [];

            $existingContractDetails = !empty($contractRow['contract_details_json'])
                ? (json_decode($contractRow['contract_details_json'], true) ?: [])
                : [];
            $oldFuelOut = $existingContractDetails['fuel_out'] ?? ($existingContractDetails['fuel_level'] ?? '');

            $replacementRecordNode = [
                'replacement_id'      => 'REPL-' . time() . '-' . rand(100, 999),
                'replaced_on'         => $replDateTime,
                'replaced_by_user'    => $this->userId,
                'staff_name'          => $staffName,
                'staff_signature'     => $staffSignature,
                'parking_location_in' => $parkingLocationIn,
                'check_in_type'       => $checkInType,
                'out_location'        => $outLocation,
                'old_vehicle'         => [
                    'vehicle_id'        => $oldVehId,
                    'vehicle_number'    => $oldVehNo,
                    'category_id'       => $oldCatId,
                    'model_id'          => $oldModelId,
                    'category_name'     => $contractRow['category_name'] ?? '',
                    'model_name'        => $contractRow['model_name'] ?? '',
                    'km_out'            => $oldKmOut,
                    'km_in'             => $oldKmIn,
                    'km_used'           => $oldKmUsed,
                    'dt_out'            => $oldDtOut,
                    'dt_in'             => $replDateTime,
                    'fuel_level_out'    => $oldFuelOut,
                    'fuel_level_in'     => $oldFuelIn,
                    'accessories'       => $oldAccessories,
                    'old_return_images' => $oldReturnImages,
                ],
                'new_vehicle'         => [
                    'vehicle_id'         => $newVehId,
                    'vehicle_number'     => $newVehNo,
                    'category_id'        => $newCatId,
                    'model_id'           => $newModelId,
                    'category_name'      => $newVehRow['category_name'] ?? '',
                    'model_name'         => $newVehRow['model_name'] ?? '',
                    'km_out'             => $newKmOut,
                    'fuel_level_out'     => $newFuelOut,
                    'dt_out'             => $replDateTime,
                    'accessories'        => $newAccessories,
                    'new_rentout_images' => $newRentoutImages,
                ],
                'remarks'             => $reason,
            ];

            $existingReplacedList[] = $replacementRecordNode;
            $replacedJsonStr = json_encode($existingReplacedList);

            $newVehDetailsStr = json_encode([
                'vehicle_id'    => (string)$newVehId,
                'category_id'   => (string)$newCatId,
                'model_id'      => (string)$newModelId,
                'veh_no'        => (string)$newVehNo,
                'category_name' => (string)($newVehRow['category_name'] ?? ''),
                'model_name'    => (string)($newVehRow['model_name'] ?? ''),
                'vehicle_color' => (string)($newVehRow['vehicle_color'] ?? ''),
                'vehicle_year'  => (string)($newVehRow['vehicle_year'] ?? ''),
            ]);

            $existingContractDetails['fuel_out'] = $newFuelOut;
            $existingContractDetails['fuel_level'] = $newFuelOut;

            $this->varPDOModelObj->executeQuery("
                UPDATE tbl_vehicle_rentout_contracts
                SET
                    vehicle_category_id         = :new_cat_id,
                    vehicle_model_id            = :new_model_id,
                    vehicle_id                  = :new_veh_id,
                    vehicle_no                  = :new_veh_no,
                    vechile_details             = :new_veh_details,
                    km_out                      = :new_km_out,
                    contract_details_json       = :contract_details_json,
                    vehicle_accessories_details = :new_accessories,
                    vehicle_rentout_images      = :new_rentout_images,
                    replaced_vehicle_json       = :replaced_json
                WHERE ids = :agreement_id
            ", [
                ':new_cat_id'            => $newCatId,
                ':new_model_id'          => $newModelId,
                ':new_veh_id'            => $newVehId,
                ':new_veh_no'            => $newVehNo,
                ':new_veh_details'       => $newVehDetailsStr,
                ':new_km_out'            => $newKmOut,
                ':contract_details_json' => json_encode($existingContractDetails),
                ':new_accessories'       => json_encode($newAccessories),
                ':new_rentout_images'    => json_encode($newRentoutImages),
                ':replaced_json'         => $replacedJsonStr,
                ':agreement_id'          => $agreementId,
            ]);

            echo json_encode([
                'status'  => true,
                'message' => 'Vehicle replaced successfully! Old vehicle moved to Parking and contract updated.'
            ]);
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => 'Error replacing vehicle: ' . $e->getMessage()]);
        }
    }
}

new VehicleReplacementController();
