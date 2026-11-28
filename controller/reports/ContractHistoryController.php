<?php
header('Content-Type: application/json');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!class_exists('ClassDatabaseConnection')) {
    require_once ROOT_PATH . '/model/db_connection/pdo_db_connection.php';
}
if (!class_exists('CommonPDOModel')) {
    require_once ROOT_PATH . '/model/common/pdoCommonFunctions.php';
}

class ContractHistoryController {
    private $varPDOModelObj;
    private $json;
    private $data = [];

    public function __construct() {
        $this->varPDOModelObj = new CommonPDOModel();
        $this->json = file_get_contents("php://input");
        if ($this->json) {
            $this->data = json_decode($this->json, true) ?: [];
        } else {
            $this->data = $_REQUEST;
        }
        $this->handleRequest();
    }

    private function getUserAllowedCompanyIds()
    {
        $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || (($_SESSION['user_role_id'] ?? 0) == 3);
        $userCompanyIds = [];
        if (!empty($_SESSION['company_id'])) {
            $userCompanyIds[] = strval($_SESSION['company_id']);
        }
        if (!empty($_SESSION['company_json'])) {
            $cArr = is_string($_SESSION['company_json']) ? json_decode($_SESSION['company_json'], true) : $_SESSION['company_json'];
            if (is_array($cArr)) {
                foreach ($cArr as $c) {
                    if (!empty($c['ids'])) {
                        $userCompanyIds[] = strval($c['ids']);
                    }
                }
            }
        }
        $userCompanyIds = array_values(array_unique($userCompanyIds));
        return [
            'isSuperAdmin'  => $isSuperAdmin,
            'companyIds'    => $userCompanyIds,
            'companyIdsStr' => !empty($userCompanyIds) ? implode(',', array_map('intval', $userCompanyIds)) : '1'
        ];
    }

    private function handleRequest() {
        $action = $this->data['action'] ?? '';
        switch ($action) {
            case 'searchContracts':
                $this->searchContracts();
                break;
            case 'getContractFullDetails':
                $this->getContractFullDetails();
                break;
            default:
                echo json_encode(['status' => false, 'message' => 'Invalid action']);
                break;
        }
    }

    private function searchContracts() {
        try {
            $custCode = trim($this->data['customer_code'] ?? '');
            $vehicleId = trim($this->data['vehicle_id'] ?? '');
            $vehNo = trim($this->data['vehicle_no'] ?? '');
            $companyId = trim($this->data['company_id'] ?? '');

            $whereConds = ["1=1"];
            $params = [];

            // Company access filter
            $accessInfo = $this->getUserAllowedCompanyIds();
            $isSuperAdmin = $accessInfo['isSuperAdmin'];
            $companyIdsStr = $accessInfo['companyIdsStr'];

            if (!empty($companyId) && $companyId !== 'all' && $companyId !== 'All') {
                $cId = intval($companyId);
                if ($isSuperAdmin || in_array(strval($cId), $accessInfo['companyIds'])) {
                    $whereConds[] = "c.company_id = :comp_id";
                    $params[':comp_id'] = $cId;
                } else {
                    $whereConds[] = "c.company_id IN ($companyIdsStr)";
                }
            } else {
                if (!$isSuperAdmin) {
                    $whereConds[] = "c.company_id IN ($companyIdsStr)";
                }
            }

            if (!empty($custCode)) {
                $whereConds[] = "c.customer_code = :cust_code";
                $params[':cust_code'] = $custCode;
            }

            if (!empty($vehicleId)) {
                $whereConds[] = "(c.vehicle_id = :veh_id OR c.replaced_vehicle_json LIKE :veh_id_like OR c.vechile_details LIKE :veh_id_like2)";
                $params[':veh_id'] = $vehicleId;
                $params[':veh_id_like'] = '%"vehicle_id":' . intval($vehicleId) . '%';
                $params[':veh_id_like2'] = '%"vehicle_id":"' . $vehicleId . '"%';
            } else if (!empty($vehNo)) {
                $whereConds[] = "(c.vehicle_no LIKE :veh_no OR c.replaced_vehicle_json LIKE :veh_no_like OR c.vechile_details LIKE :veh_no_like2)";
                $params[':veh_no'] = '%' . $vehNo . '%';
                $params[':veh_no_like'] = '%"vehicle_number":"' . $vehNo . '"%';
                $params[':veh_no_like2'] = '%"veh_no":"' . $vehNo . '"%';
            }

            $whereSql = implode(' AND ', $whereConds);
            $sql = "SELECT c.*, 
                           comp.company_name,
                           DATE_FORMAT(c.service_start_date_time, '%d-%b-%Y %H:%i') AS from_date_format,
                           DATE_FORMAT(c.service_end_date_time, '%d-%b-%Y %H:%i') AS to_date_format,
                           cust.customer_name AS cust_full_name, 
                           cust.customer_mobile AS mobile_number, 
                           cust.customer_cr_cpr AS cpr_no,
                           cust.customer_email,
                           cust.nationality AS customer_nationality,
                           tv.vehicle_year,
                           tv.vehicle_color,
                           tv.vehicle_status,
                           tv.other_details_json AS veh_other_json,
                           cat.category_name,
                           mdl.modal_name AS model_name,
                           tb.brand_name
                    FROM tbl_vehicle_rentout_contracts c
                    LEFT JOIN tbl_company comp ON comp.ids = c.company_id
                    LEFT JOIN customer_details cust ON cust.customer_id = c.customer_code
                    LEFT JOIN tbl_vehicles tv ON tv.ids = c.vehicle_id
                    LEFT JOIN tbl_vehicle_category cat ON cat.ids = COALESCE(tv.category_id, c.vehicle_category_id)
                    LEFT JOIN tbl_vehicle_model mdl ON mdl.ids = COALESCE(tv.model_id, c.vehicle_model_id)
                    LEFT JOIN tbl_vehicle_brand tb ON tb.ids = tv.brand_id
                    WHERE {$whereSql}
                    ORDER BY c.ids DESC";

            $stmt = $this->varPDOModelObj->selectexecuteQuery($sql, $params);
            $rows = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];

            $result = [];
            foreach ($rows as $row) {
                $replacedList = !empty($row['replaced_vehicle_json']) ? (json_decode($row['replaced_vehicle_json'], true) ?: []) : [];
                $replacementCount = count($replacedList);
                $replacedSummary = [];
                foreach ($replacedList as $rep) {
                    $replacedSummary[] = [
                        'old_veh'     => $rep['old_vehicle']['vehicle_number'] ?? '-',
                        'new_veh'     => $rep['new_vehicle']['vehicle_number'] ?? '-',
                        'replaced_on' => $rep['replaced_on'] ?? '',
                    ];
                }

                $vehDetails = !empty($row['vechile_details']) ? (json_decode($row['vechile_details'], true) ?: []) : [];
                $vehOther = !empty($row['veh_other_json']) ? (json_decode($row['veh_other_json'], true) ?: []) : [];
                $vehSummary = ($row['vehicle_no'] ?? '') . ' - ' . ($row['category_name'] ?? ($vehDetails['category_name'] ?? '')) . ' ' . ($row['model_name'] ?? ($vehDetails['model_name'] ?? ''));

                $custDetails = !empty($row['customer_details']) ? (json_decode($row['customer_details'], true) ?: []) : [];
                $customerName = $row['cust_full_name'] ?? ($row['customer_name'] ?? ($custDetails['customer_name'] ?? 'N/A'));

                $result[] = [
                    'ids'                  => $row['ids'],
                    'company_name'         => $row['company_name'] ?? 'AA Car Rental',
                    'agreement_no'         => $row['agreement_no'] ?? '',
                    'agreement_date'       => $row['agreement_date'] ?? '',
                    'booking_no'           => $row['agreement_group_ref_no'] ?? '',
                    'from_date_format'     => $row['from_date_format'] ?? '',
                    'to_date_format'       => $row['to_date_format'] ?? '',
                    'customer_code'        => $row['customer_code'] ?? '',
                    'customer_name'        => $customerName,
                    'mobile_number'        => $row['mobile_number'] ?? ($custDetails['customer_mobile'] ?? ''),
                    'cpr_no'               => $row['cpr_no'] ?? ($custDetails['customer_cr_cpr'] ?? ''),
                    'customer_email'       => $row['customer_email'] ?? ($custDetails['customer_email'] ?? ''),
                    'customer_nationality' => $row['customer_nationality'] ?? '',
                    'vehicle_id'           => $row['vehicle_id'] ?? '',
                    'model_id'             => $row['vehicle_model_id'] ?? '',
                    'vehicle_no'           => $row['vehicle_no'] ?? '',
                    'brand_name'           => $row['brand_name'] ?? '',
                    'category_name'        => $row['category_name'] ?? ($vehDetails['category_name'] ?? ''),
                    'model_name'           => $row['model_name'] ?? ($vehDetails['model_name'] ?? ''),
                    'vehicle_year'         => $row['vehicle_year'] ?? ($vehDetails['vehicle_year'] ?? ''),
                    'vehicle_color'        => $row['vehicle_color'] ?? ($vehDetails['vehicle_color'] ?? ''),
                    'vehicle_status'       => $row['vehicle_status'] ?? '',
                    'fuel_type'            => $vehOther['vehicleFuelType'] ?? ($vehOther['fuel_type'] ?? ''),
                    'gear_type'            => $vehOther['gear_type'] ?? ($vehOther['transmission'] ?? ''),
                    'chassis_number'       => $vehOther['chassis_number'] ?? ($vehOther['chassis_no'] ?? ''),
                    'vehicle_summary'      => $vehSummary,
                    'agreement_status'     => $row['agreement_status'] ?? 'Rentout',
                    'replacement_count'    => $replacementCount,
                    'replaced_summary'     => $replacedSummary
                ];
            }

            echo json_encode(['status' => true, 'data' => $result]);
        } catch (\Throwable $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    private function getContractFullDetails() {
        $agreementId = intval($this->data['agreement_id'] ?? 0);
        if (empty($agreementId)) {
            echo json_encode(['status' => false, 'message' => 'Missing agreement ID']);
            return;
        }

        try {
            // 1. Fetch Contract Main Row
            $stmtContract = $this->varPDOModelObj->selectexecuteQuery(
                "SELECT c.*, cat.category_name, modl.modal_name AS model_name, comp.company_name
                 FROM tbl_vehicle_rentout_contracts c
                 LEFT JOIN tbl_vehicle_category cat ON cat.ids = c.vehicle_category_id
                 LEFT JOIN tbl_vehicle_model modl ON modl.ids = c.vehicle_model_id
                 LEFT JOIN tbl_company comp ON comp.ids = c.company_id
                 WHERE c.ids = :id",
                [':id' => $agreementId]
            );
            $contract = $stmtContract ? $stmtContract->fetch(PDO::FETCH_ASSOC) : null;
            if (!$contract) {
                echo json_encode(['status' => false, 'message' => 'Contract not found']);
                return;
            }

            // 2. Fetch Customer Info
            $custCode = $contract['customer_code'] ?? '';
            $customer = null;
            if (!empty($custCode)) {
                $stmtCust = $this->varPDOModelObj->selectexecuteQuery(
                    "SELECT customer_name, customer_mobile AS mobile_number, customer_cr_cpr AS cpr_no, customer_address, customer_email, customer_id AS customer_code
                     FROM customer_details
                     WHERE customer_id = :ccode LIMIT 1",
                    [':ccode' => $custCode]
                );
                $customer = $stmtCust ? $stmtCust->fetch(PDO::FETCH_ASSOC) : null;
            }

            // 3. Fetch Current Vehicle Info
            $vehId = intval($contract['vehicle_id'] ?? 0);
            $currentVehicle = null;
            if (!empty($vehId)) {
                $stmtVeh = $this->varPDOModelObj->selectexecuteQuery(
                    "SELECT v.*, cat.category_name, modl.modal_name AS model_name
                     FROM tbl_vehicles v
                     LEFT JOIN tbl_vehicle_category cat ON cat.ids = v.category_id
                     LEFT JOIN tbl_vehicle_model modl ON modl.ids = v.model_id
                     WHERE v.ids = :id",
                    [':id' => $vehId]
                );
                $currentVehicle = $stmtVeh ? $stmtVeh->fetch(PDO::FETCH_ASSOC) : null;
            }

            // 4. Parse Replacement History
            $replacedHistory = !empty($contract['replaced_vehicle_json']) ? (json_decode($contract['replaced_vehicle_json'], true) ?: []) : [];

            // 5. Fetch Extensions List with creator user info
            $extensions = [];
            try {
                $stmtExt = $this->varPDOModelObj->selectexecuteQuery(
                    "SELECT * FROM tbl_vehicle_contract_extensions WHERE agreement_ids = :aid ORDER BY ids ASC",
                    [':aid' => $agreementId]
                );
                $rawExts = $stmtExt ? $stmtExt->fetchAll(PDO::FETCH_ASSOC) : [];

                $userMap = [];
                try {
                    $stmtU = $this->varPDOModelObj->selectexecuteQuery("SELECT user_id, COALESCE(NULLIF(profile_name,''), user_name) AS display_name FROM tbl_users");
                    if ($stmtU) {
                        foreach ($stmtU->fetchAll(PDO::FETCH_ASSOC) as $u) {
                            $userMap[(int)$u['user_id']] = $u['display_name'];
                        }
                    }
                } catch (\Throwable $ignore) {}

                foreach ($rawExts as $ext) {
                    $ed = json_decode((string)($ext['extend_details'] ?? '{}'), true) ?: [];
                    $lg = json_decode((string)($ext['extend_log_json'] ?? '{}'), true) ?: [];
                    $uid = (int)($lg['user_id'] ?? 0);
                    $ext['service_name'] = $ed['service_name'] ?? '';
                    $ext['rate_type']    = $ed['rate_type'] ?? ($ext['rate_type'] ?? '');
                    $ext['duration']     = $ed['duration'] ?? ($ext['duration'] ?? '');
                    $ext['unit_price']   = $ed['unit_price'] ?? 0;
                    $ext['vat']          = $ed['vat'] ?? 0;
                    $ext['total_amount'] = $ed['total_amt'] ?? ($ext['total_amount'] ?? 0);
                    $ext['remarks']      = $ed['booking_notes'] ?? '';
                    $ext['made_by']      = $lg['user_name'] ?? ($uid > 0 && isset($userMap[$uid]) ? $userMap[$uid] : ($uid > 0 ? 'User #' . $uid : '-'));
                    $ext['made_at']      = $lg['datetime'] ?? ($ext['extension_date'] ?? '');
                    $extensions[] = $ext;
                }
            } catch (\Throwable $th) {
                $extensions = [];
            }

            // 6. Fetch Customer Ledger Entries for this Contract
            $agreementNo = $contract['agreement_no'] ?? '';
            $stmtLedger = $this->varPDOModelObj->selectexecuteQuery(
                "SELECT * FROM tbl_customer_ledger WHERE contract_ids = :cid OR agreement_no = :refno ORDER BY ids ASC",
                [':cid' => $agreementId, ':refno' => $agreementNo]
            );
            $ledgerEntries = $stmtLedger ? $stmtLedger->fetchAll(PDO::FETCH_ASSOC) : [];

            $totalDebit = 0;
            $totalCredit = 0;
            foreach ($ledgerEntries as $l) {
                $totalDebit += floatval($l['debit'] ?? 0);
                $totalCredit += floatval($l['credit'] ?? 0);
            }
            $balance = $totalDebit - $totalCredit;

            // 7. Fetch Invoices related to this Contract
            $invoices = [];
            try {
                $stmtInv = $this->varPDOModelObj->selectexecuteQuery(
                    "SELECT id, invoice_no, invoice_date, invoice_due_date, vat_total, grand_total, reference_number, draft, created_at
                     FROM invoices
                     WHERE reference_number = :agr OR items LIKE :agr_like
                     ORDER BY id DESC",
                    [':agr' => $agreementNo, ':agr_like' => '%' . $agreementNo . '%']
                );
                $invoices = $stmtInv ? $stmtInv->fetchAll(PDO::FETCH_ASSOC) : [];
            } catch (\Throwable $th) {
                $invoices = [];
            }

            // 8. Fetch Vehicle Movements & Logs
            $movements = [];
            try {
                $stmtMov = $this->varPDOModelObj->selectexecuteQuery(
                    "SELECT vm.*, v.vehicle_number
                     FROM tbl_vehicle_movement vm
                     LEFT JOIN tbl_vehicles v ON v.ids = vm.vehicle_id
                     WHERE (vm.reference_type = 'Agreement' AND vm.reference_id = :aid) OR vm.reference_no = :agr
                     ORDER BY vm.ids ASC",
                    [':aid' => $agreementId, ':agr' => $agreementNo]
                );
                $movements = $stmtMov ? $stmtMov->fetchAll(PDO::FETCH_ASSOC) : [];
            } catch (\Throwable $th) {
                $movements = [];
            }

            $violations = !empty($contract['violations_json']) ? (json_decode($contract['violations_json'], true) ?: []) : [];

            echo json_encode([
                'status'            => true,
                'contract'          => $contract,
                'customer'          => $customer,
                'current_vehicle'   => $currentVehicle,
                'replaced_history'  => $replacedHistory,
                'extensions'        => $extensions,
                'invoices'          => $invoices,
                'movements'         => $movements,
                'violations'        => $violations,
                'ledger'            => [
                    'entries'       => $ledgerEntries,
                    'total_debit'   => $totalDebit,
                    'total_credit'  => $totalCredit,
                    'balance'       => $balance
                ]
            ]);

        } catch (\Throwable $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}

new ContractHistoryController();
