<?php
header('Content-Type: application/json');

if (!class_exists('ClassDatabaseConnection')) {
    require_once ROOT_PATH . '/model/db_connection/pdo_db_connection.php';
}
if (!class_exists('CommonPDOModel')) {
    require_once ROOT_PATH . '/model/common/pdoCommonFunctions.php';
}

class ContractReturnOverdueController {
    private $varPDOModelObj;
    private $requestData = [];

    public function __construct() {
        $this->varPDOModelObj = new CommonPDOModel();
        $rawInput = file_get_contents("php://input");
        if (!empty($rawInput)) {
            $this->requestData = json_decode($rawInput, true) ?: [];
        } else {
            $this->requestData = $_REQUEST;
        }
        $this->handleRequest();
    }

    private function handleRequest() {
        $action = $this->requestData['action'] ?? '';
        switch ($action) {
            case 'getReportData':
                $this->getReportData();
                break;
            case 'getCompanies':
                $this->getCompanies();
                break;
            case 'getContractDetails':
                $this->getContractDetails();
                break;
            default:
                echo json_encode(['status' => false, 'message' => 'Invalid action: ' . htmlspecialchars($action)]);
                break;
        }
    }

    public function getUserCompanyAccess() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || (($_SESSION['user_role_id'] ?? 0) == 3);
        $userId = $_SESSION['user_id'] ?? 0;

        $allCompanies = [];
        try {
            $stmt = $this->varPDOModelObj->selectexecuteQuery("SELECT ids, company_name FROM tbl_company WHERE status = 'Active' ORDER BY ids ASC");
            if ($stmt && $stmt instanceof PDOStatement) {
                $allCompanies = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (\Throwable $e) {}

        if ($isSuperAdmin) {
            $allowedIds = array_map('intval', array_column($allCompanies, 'ids'));
            return [
                'is_super_admin' => true,
                'has_multiple'   => count($allCompanies) > 1,
                'default_company'=> (count($allCompanies) > 1) ? 'all' : (strval($allCompanies[0]['ids'] ?? '1')),
                'allowed_ids'    => $allowedIds,
                'companies'      => $allCompanies
            ];
        }

        $userCompanies = [];
        if (!empty($_SESSION['company_json'])) {
            $decoded = json_decode($_SESSION['company_json'], true);
            if (is_array($decoded) && !empty($decoded)) {
                $userCompanies = $decoded;
            }
        }

        if (empty($userCompanies) && !empty($userId)) {
            try {
                $uStmt = $this->varPDOModelObj->selectexecuteQuery("SELECT company_json, company_id FROM tbl_users WHERE id = :uid OR user_id = :uid LIMIT 1", [':uid' => $userId]);
                if ($uStmt && $uStmt instanceof PDOStatement) {
                    $uRow = $uStmt->fetch(PDO::FETCH_ASSOC);
                    if (!empty($uRow['company_json'])) {
                        $decoded = json_decode($uRow['company_json'], true);
                        if (is_array($decoded) && !empty($decoded)) {
                            $userCompanies = $decoded;
                        }
                    }
                    if (empty($userCompanies) && !empty($uRow['company_id'])) {
                        foreach ($allCompanies as $ac) {
                            if (strval($ac['ids']) === strval($uRow['company_id'])) {
                                $userCompanies[] = $ac;
                                break;
                            }
                        }
                    }
                }
            } catch (\Throwable $e) {}
        }

        if (empty($userCompanies) && !empty($_SESSION['company_id'])) {
            foreach ($allCompanies as $ac) {
                if (strval($ac['ids']) === strval($_SESSION['company_id'])) {
                    $userCompanies[] = $ac;
                    break;
                }
            }
        }

        if (empty($userCompanies)) {
            $userCompanies = !empty($allCompanies) ? $allCompanies : [['ids' => '1', 'company_name' => 'AA Car Rental']];
        }

        $allowedIds = [];
        foreach ($userCompanies as $uc) {
            if (!empty($uc['ids'])) {
                $allowedIds[] = intval($uc['ids']);
            }
        }
        $allowedIds = array_unique($allowedIds);

        $hasMultiple = count($userCompanies) > 1;
        $defaultCompany = $hasMultiple ? 'all' : strval($userCompanies[0]['ids'] ?? '1');

        return [
            'is_super_admin' => false,
            'has_multiple'   => $hasMultiple,
            'default_company'=> $defaultCompany,
            'allowed_ids'    => $allowedIds,
            'companies'      => $userCompanies
        ];
    }

    private function getCompanies() {
        $access = $this->getUserCompanyAccess();
        echo json_encode([
            'status'          => true,
            'is_super_admin'  => $access['is_super_admin'],
            'has_multiple'    => $access['has_multiple'],
            'default_company' => $access['default_company'],
            'companies'       => $access['companies']
        ]);
    }

    private function getReportData() {
        try {
            $companyAccess  = $this->getUserCompanyAccess();
            $companyFilter  = trim($this->requestData['company_id'] ?? '');

            // Fallback to default company if empty
            if (empty($companyFilter)) {
                $companyFilter = $companyAccess['default_company'];
            }

            $fromDate       = trim($this->requestData['from_date'] ?? '');
            $toDate         = trim($this->requestData['to_date'] ?? '');
            $dateFilterBy   = trim($this->requestData['date_filter_by'] ?? 'expected_return');
            $statusFilter   = trim($this->requestData['contract_status'] ?? 'all');
            $extendedFilter = trim($this->requestData['extended_filter'] ?? 'all');
            $overdueFilter  = trim($this->requestData['overdue_filter'] ?? 'all');
            $searchKeyword  = trim($this->requestData['search_keyword'] ?? '');

            // Build SQL query for contracts
            $whereConds = ["1=1"];
            $params = [];

            // Company Filtering
            if ($companyFilter !== 'all' && !empty($companyFilter)) {
                $targetCompId = intval($companyFilter);
                if ($companyAccess['is_super_admin'] || in_array($targetCompId, $companyAccess['allowed_ids'])) {
                    $whereConds[] = "c.company_id = :comp_id";
                    $params[':comp_id'] = $targetCompId;
                } else {
                    // Unauthorized company specified: restrict to user's allowed IDs
                    if (!empty($companyAccess['allowed_ids'])) {
                        $inComp = implode(',', array_map('intval', $companyAccess['allowed_ids']));
                        $whereConds[] = "c.company_id IN ({$inComp})";
                    }
                }
            } else {
                // 'all' selected: if not super admin, restrict to user's allowed company IDs
                if (!$companyAccess['is_super_admin'] && !empty($companyAccess['allowed_ids'])) {
                    $inComp = implode(',', array_map('intval', $companyAccess['allowed_ids']));
                    $whereConds[] = "c.company_id IN ({$inComp})";
                }
            }

            // Status Filtering: STRICTLY restricted to Rentout and Extended active vehicles!
            if ($statusFilter !== 'all' && !empty($statusFilter)) {
                if (strtolower($statusFilter) === 'rentout') {
                    $whereConds[] = "LOWER(c.agreement_status) IN ('rentout', 'rented')";
                } else if (strtolower($statusFilter) === 'extended') {
                    $whereConds[] = "LOWER(c.agreement_status) = 'extended'";
                } else {
                    $whereConds[] = "LOWER(c.agreement_status) IN ('rentout', 'rented', 'extended')";
                }
            } else {
                // Default: ONLY active Rentout and Extended vehicles
                $whereConds[] = "LOWER(c.agreement_status) IN ('rentout', 'rented', 'extended')";
            }

            // Date filtering for contract_date or return_date
            if (!empty($fromDate) && !empty($toDate)) {
                if ($dateFilterBy === 'contract_date') {
                    $whereConds[] = "c.agreement_date BETWEEN :from_dt AND :to_dt";
                    $params[':from_dt'] = $fromDate;
                    $params[':to_dt']   = $toDate;
                } else if ($dateFilterBy === 'return_date') {
                    $whereConds[] = "DATE(c.return_date) BETWEEN :from_dt AND :to_dt";
                    $params[':from_dt'] = $fromDate;
                    $params[':to_dt']   = $toDate;
                }
            }

            // Keyword search
            if (!empty($searchKeyword)) {
                $whereConds[] = "(
                    c.agreement_no LIKE :kw OR 
                    c.customer_name LIKE :kw OR 
                    c.customer_code LIKE :kw OR 
                    cust.customer_mobile LIKE :kw OR 
                    cust.customer_cr_cpr LIKE :kw OR 
                    c.vehicle_no LIKE :kw OR 
                    v.model_names LIKE :kw OR
                    comp.company_name LIKE :kw
                )";
                $params[':kw'] = '%' . $searchKeyword . '%';
            }

            $whereSql = implode(' AND ', $whereConds);
            $sql = "SELECT c.ids, c.company_id, c.booking_ids, c.vehicle_model_id, c.vehicle_category_id,
                           c.agreement_no, c.agreement_date, c.agreement_status, c.customer_code, 
                           c.customer_name, c.vehicle_id, c.vehicle_no, c.service_type, 
                           c.service_start_date_time, c.service_end_date_time, c.contract_details_json,
                           c.return_date, c.km_in, c.km_out, c.km_used,
                           cust.customer_name AS cust_db_name, cust.customer_mobile, cust.customer_cr_cpr,
                           v.model_names, cat.category_name, modl.modal_name AS model_name,
                           comp.company_name
                    FROM tbl_vehicle_rentout_contracts c
                    LEFT JOIN customer_details cust ON (cust.customer_id = c.customer_code OR cust.ids = c.customer_code)
                    LEFT JOIN tbl_vehicles v ON v.ids = c.vehicle_id
                    LEFT JOIN tbl_vehicle_category cat ON cat.ids = c.vehicle_category_id
                    LEFT JOIN tbl_vehicle_model modl ON modl.ids = c.vehicle_model_id
                    LEFT JOIN tbl_company comp ON comp.ids = c.company_id
                    WHERE {$whereSql}
                    ORDER BY c.ids DESC";

            $stmt = $this->varPDOModelObj->selectexecuteQuery($sql, $params);
            $contracts = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];

            if (empty($contracts)) {
                echo json_encode([
                    'status' => true,
                    'data'   => [],
                    'kpis'   => [
                        'total_contracts'            => 0,
                        'total_active'               => 0,
                        'total_returned'             => 0,
                        'total_overdue'              => 0,
                        'total_extended'             => 0,
                        'total_contract_amount'      => '0.000',
                        'total_extension_amount'     => '0.000',
                        'total_agreed_amount'        => '0.000',
                        'total_overdue_extra_amount' => '0.000'
                    ]
                ]);
                return;
            }

            // Batch fetch extensions
            $contractIds = array_column($contracts, 'ids');
            $extensionsByContract = [];
            if (!empty($contractIds)) {
                $inClause = implode(',', array_map('intval', $contractIds));
                $extSql = "SELECT * FROM tbl_vehicle_contract_extensions 
                           WHERE agreement_ids IN ({$inClause}) 
                           ORDER BY extend_end_date ASC, ids ASC";
                $extStmt = $this->varPDOModelObj->selectexecuteQuery($extSql);
                if ($extStmt) {
                    while ($extRow = $extStmt->fetch(PDO::FETCH_ASSOC)) {
                        $cId = intval($extRow['agreement_ids']);
                        $extensionsByContract[$cId][] = $extRow;
                    }
                }
            }

            $currentTimestamp = time();
            $reportRows = [];

            // Aggregators for KPIs
            $kpiTotalContracts       = 0;
            $kpiTotalActive          = 0;
            $kpiTotalReturned        = 0;
            $kpiTotalOverdue         = 0;
            $kpiTotalExtended        = 0;
            $kpiTotalContractAmt     = 0.0;
            $kpiTotalExtensionAmt    = 0.0;
            $kpiTotalOverdueExtraAmt = 0.0;

            $validDateTs = function($dt) {
                if (empty($dt) || strpos(strval($dt), '0000-00-00') !== false || strpos(strval($dt), '1970-01-01') !== false) return false;
                $ts = strtotime(strval($dt));
                return ($ts !== false && $ts > 946684800) ? $ts : false;
            };

            foreach ($contracts as $contract) {
                $cId = intval($contract['ids']);
                $agrStatus = ucfirst(trim($contract['agreement_status'] ?? 'Rentout'));
                $agrStatusLower = strtolower($agrStatus);

                // Enforce: only active Rentout and Extended vehicles
                if (!in_array($agrStatusLower, ['rentout', 'rented', 'extended'])) {
                    continue;
                }

                $cd = json_decode($contract['contract_details_json'] ?? '', true) ?: [];

                // 1. Initial Contract Period & Duration
                $initialStart = $cd['period_from'] ?? $contract['service_start_date_time'] ?? '';
                $initialEnd   = $cd['period_to'] ?? $contract['service_end_date_time'] ?? '';
                $initialDuration = intval($cd['duration'] ?? 0);
                $initialStartTs = $validDateTs($initialStart);
                $initialEndTs   = $validDateTs($initialEnd);

                if ($initialDuration <= 0 && $initialStartTs && $initialEndTs && $initialEndTs > $initialStartTs) {
                    $initialDuration = max(1, round(($initialEndTs - $initialStartTs) / 86400));
                }

                if (!$initialEndTs && $initialStartTs) {
                    $initialEndTs = strtotime('+' . max(1, $initialDuration) . ' days', $initialStartTs);
                    $initialEnd = date('Y-m-d H:i:s', $initialEndTs);
                }

                $initialStartFmt = $initialStartTs ? date('d-m-Y H:i', $initialStartTs) : 'N/A';
                $initialEndFmt   = $initialEndTs ? date('d-m-Y H:i', $initialEndTs) : 'N/A';

                // Initial Contract Amount & Daily Rate
                $contractAmount = floatval($cd['total_amt'] ?? 0);
                $unitPrice      = floatval($cd['unit_price'] ?? 0);
                $rateType       = strtolower($cd['rate_type'] ?? 'daily');

                $dailyRate = 0.0;
                if ($unitPrice > 0) {
                    if (strpos($rateType, 'hour') !== false) {
                        $dailyRate = $unitPrice * 24;
                    } else if (strpos($rateType, 'month') !== false) {
                        $dailyRate = $unitPrice / 30;
                    } else if (strpos($rateType, 'week') !== false) {
                        $dailyRate = $unitPrice / 7;
                    } else {
                        $dailyRate = $unitPrice;
                    }
                } else if ($contractAmount > 0 && $initialDuration > 0) {
                    $dailyRate = $contractAmount / $initialDuration;
                }

                // 2. Extensions Analysis
                $extList = $extensionsByContract[$cId] ?? [];
                $isExtended = !empty($extList) || ($agrStatusLower === 'extended');
                $extensionCount = count($extList);
                $totalExtensionAmt = 0.0;
                $totalExtensionDays = 0;
                $latestExtEndTs = null;
                $latestExtEndDateStr = '';
                $earliestExtStartTs = null;
                $earliestExtStartDateStr = '';

                if (!empty($extList)) {
                    foreach ($extList as $ext) {
                        $extDetails = json_decode($ext['extend_details'] ?? '', true) ?: [];
                        $totalExtensionAmt += floatval($extDetails['total_amt'] ?? 0);
                        $totalExtensionDays += intval($extDetails['duration'] ?? 0);

                        $extEnd = $ext['extend_end_date'] ?? ($extDetails['period_to'] ?? '');
                        $extStart = $ext['extend_start_date'] ?? ($extDetails['period_from'] ?? '');

                        $extEndTs = $validDateTs($extEnd);
                        $extStartTs = $validDateTs($extStart);

                        if ($extEndTs && ($latestExtEndTs === null || $extEndTs > $latestExtEndTs)) {
                            $latestExtEndTs = $extEndTs;
                            $latestExtEndDateStr = $extEnd;

                            $extUnit = floatval($extDetails['unit_price'] ?? 0);
                            $extRType = strtolower($extDetails['rate_type'] ?? 'daily');
                            if ($extUnit > 0) {
                                if (strpos($extRType, 'hour') !== false) {
                                    $dailyRate = $extUnit * 24;
                                } else if (strpos($extRType, 'month') !== false) {
                                    $dailyRate = $extUnit / 30;
                                } else if (strpos($extRType, 'week') !== false) {
                                    $dailyRate = $extUnit / 7;
                                } else {
                                    $dailyRate = $extUnit;
                                }
                            }
                        }

                        if ($extStartTs && ($earliestExtStartTs === null || $extStartTs < $earliestExtStartTs)) {
                            $earliestExtStartTs = $extStartTs;
                            $earliestExtStartDateStr = $extStart;
                        }
                    }
                }

                if ($isExtended && $earliestExtStartTs && $latestExtEndTs) {
                    $extensionPeriodDisplay = date('d-m-Y', $earliestExtStartTs) . ' to ' . date('d-m-Y H:i', $latestExtEndTs) . " ({$totalExtensionDays} Days)";
                } else {
                    $extensionPeriodDisplay = '-';
                }

                // 3. Expected Return Date
                if ($isExtended && $latestExtEndTs) {
                    $expectedReturnTs = $latestExtEndTs;
                    $expectedReturnDateStr = $latestExtEndDateStr;
                } else {
                    $expectedReturnTs = $initialEndTs;
                    $expectedReturnDateStr = $initialEnd;
                }
                $expectedReturnFmt = $expectedReturnTs ? date('d-m-Y H:i', $expectedReturnTs) : 'N/A';

                // 4. Return Status & Actual Return Date (All are active On Rent)
                $isReturned = false;
                $actualReturnDate = null;
                $actualReturnFmt  = 'On Rent';

                // 5. Overdue Status & Extra Amount (Calculated ONLY for active Rentout and Extended)
                $isOverdue = false;
                $overdueDays = 0;
                $overdueStatusLabel = 'On Schedule';
                $overdueBadgeClass  = 'bg-primary';
                $extraOverdueAmount = 0.0;

                if ($expectedReturnTs && $expectedReturnTs > 946684800) {
                    if ($currentTimestamp > ($expectedReturnTs + 3600)) { // 1 hr grace period
                        $diffSec = $currentTimestamp - $expectedReturnTs;
                        $overdueDays = max(1, intval(ceil($diffSec / 86400)));
                        $isOverdue = true;
                        $overdueStatusLabel = "Overdue ({$overdueDays}d)";
                        $overdueBadgeClass  = 'bg-danger';
                        $extraOverdueAmount = round($overdueDays * $dailyRate, 3);
                    } else {
                        $isOverdue = false;
                        $overdueDays = 0;
                        $overdueStatusLabel = 'On Schedule';
                        $overdueBadgeClass  = 'bg-primary';
                        $extraOverdueAmount = 0.0;
                    }
                }

                // 6. In-memory Filter Application
                if (!empty($fromDate) && !empty($toDate) && $dateFilterBy === 'expected_return') {
                    $fromTs = strtotime($fromDate . ' 00:00:00');
                    $toTs   = strtotime($toDate . ' 23:59:59');
                    if ($expectedReturnTs < $fromTs || $expectedReturnTs > $toTs) {
                        continue;
                    }
                }

                if ($extendedFilter === 'yes' && !$isExtended) {
                    continue;
                }
                if ($extendedFilter === 'no' && $isExtended) {
                    continue;
                }

                if ($overdueFilter === 'overdue_only' && !$isOverdue) {
                    continue;
                }
                if ($overdueFilter === 'on_time_only' && $isOverdue) {
                    continue;
                }
                if ($overdueFilter === 'active_overdue' && (!$isOverdue || $isReturned)) {
                    continue;
                }

                // 7. Totals & KPIs
                $totalAgreedAmount = round($contractAmount + $totalExtensionAmt, 3);
                $grandTotalWithOverdue = round($totalAgreedAmount + $extraOverdueAmount, 3);

                $kpiTotalContracts++;
                if ($isExtended) {
                    $kpiTotalExtended++;
                } else {
                    $kpiTotalActive++;
                }
                if ($isOverdue) {
                    $kpiTotalOverdue++;
                }
                $kpiTotalContractAmt     += $contractAmount;
                $kpiTotalExtensionAmt    += $totalExtensionAmt;
                $kpiTotalOverdueExtraAmt += $extraOverdueAmount;

                // Build Row Output
                $customerDisplayName = !empty($contract['cust_db_name']) ? $contract['cust_db_name'] : ($contract['customer_name'] ?: 'N/A');
                $customerMobile      = !empty($contract['customer_mobile']) ? $contract['customer_mobile'] : 'N/A';
                $customerCpr         = !empty($contract['customer_cr_cpr']) ? $contract['customer_cr_cpr'] : 'N/A';
                $vehicleNumber       = !empty($contract['vehicle_no']) ? $contract['vehicle_no'] : 'N/A';
                $vehicleModel        = !empty($contract['model_names']) ? $contract['model_names'] : (!empty($contract['model_name']) ? $contract['model_name'] : 'N/A');
                $vehicleCategory     = !empty($contract['category_name']) ? $contract['category_name'] : 'N/A';
                $companyName         = !empty($contract['company_name']) ? $contract['company_name'] : 'N/A';

                $reportRows[] = [
                    'contract_id'            => $cId,
                    'company_id'             => intval($contract['company_id']),
                    'company_name'           => $companyName,
                    'agreement_no'           => $contract['agreement_no'] ?: 'N/A',
                    'agreement_date'         => $contract['agreement_date'] ? date('d-m-Y', strtotime($contract['agreement_date'])) : 'N/A',
                    'agreement_status'       => $agrStatus,
                    'is_returned'            => $isReturned,
                    'customer_code'          => $contract['customer_code'] ?: 'N/A',
                    'customer_name'          => $customerDisplayName,
                    'customer_mobile'        => $customerMobile,
                    'customer_cpr'           => $customerCpr,
                    'customer_id'            => $contract['customer_code'] ?: '',
                    'vehicle_id'             => intval($contract['vehicle_id']),
                    'model_id'               => intval($contract['vehicle_model_id'] ?? 0),
                    'booking_ids'            => $contract['booking_ids'] ?? '',
                    'vehicle_no'             => $vehicleNumber,
                    'vehicle_model'          => $vehicleModel,
                    'vehicle_category'       => $vehicleCategory,
                    'contract_period_from'   => $initialStartFmt,
                    'contract_period_to'     => $initialEndFmt,
                    'contract_duration_days' => $initialDuration,
                    'is_extended'            => $isExtended ? 'Yes' : 'No',
                    'extension_count'        => $extensionCount,
                    'extension_period'       => $extensionPeriodDisplay,
                    'extension_total_days'   => $totalExtensionDays,
                    'expected_return_date'   => $expectedReturnFmt,
                    'expected_return_raw'    => $expectedReturnDateStr,
                    'actual_return_date'     => $actualReturnFmt,
                    'actual_return_raw'      => $actualReturnDate,
                    'is_overdue'             => $isOverdue,
                    'overdue_days'           => $overdueDays,
                    'overdue_status_label'   => $overdueStatusLabel,
                    'overdue_badge_class'    => $overdueBadgeClass,
                    'daily_rate'             => number_format($dailyRate, 3, '.', ''),
                    'contract_amount'        => number_format($contractAmount, 3, '.', ''),
                    'extension_amount'       => number_format($totalExtensionAmt, 3, '.', ''),
                    'total_agreed_amount'    => number_format($totalAgreedAmount, 3, '.', ''),
                    'extra_overdue_amount'   => number_format($extraOverdueAmount, 3, '.', ''),
                    'grand_total_amount'     => number_format($grandTotalWithOverdue, 3, '.', '')
                ];
            }

            echo json_encode([
                'status' => true,
                'data'   => $reportRows,
                'kpis'   => [
                    'total_contracts'            => $kpiTotalContracts,
                    'total_active'               => $kpiTotalActive,
                    'total_returned'             => $kpiTotalReturned,
                    'total_overdue'              => $kpiTotalOverdue,
                    'total_extended'             => $kpiTotalExtended,
                    'total_contract_amount'      => number_format($kpiTotalContractAmt, 3, '.', ''),
                    'total_extension_amount'     => number_format($kpiTotalExtensionAmt, 3, '.', ''),
                    'total_agreed_amount'        => number_format($kpiTotalContractAmt + $kpiTotalExtensionAmt, 3, '.', ''),
                    'total_overdue_extra_amount' => number_format($kpiTotalOverdueExtraAmt, 3, '.', '')
                ]
            ]);

        } catch (\Throwable $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    private function getContractDetails() {
        try {
            $contractId = intval($this->requestData['contract_id'] ?? 0);
            if ($contractId <= 0) {
                echo json_encode(['status' => false, 'message' => 'Invalid contract ID']);
                return;
            }

            $sql = "SELECT c.*, cust.customer_name AS cust_db_name, cust.customer_mobile, cust.customer_cr_cpr, cust.customer_address, cust.customer_email,
                           v.model_names, cat.category_name, modl.modal_name AS model_name,
                           comp.company_name
                    FROM tbl_vehicle_rentout_contracts c
                    LEFT JOIN customer_details cust ON (cust.customer_id = c.customer_code OR cust.ids = c.customer_code)
                    LEFT JOIN tbl_vehicles v ON v.ids = c.vehicle_id
                    LEFT JOIN tbl_vehicle_category cat ON cat.ids = c.vehicle_category_id
                    LEFT JOIN tbl_vehicle_model modl ON modl.ids = c.vehicle_model_id
                    LEFT JOIN tbl_company comp ON comp.ids = c.company_id
                    WHERE c.ids = :cid LIMIT 1";

            $stmt = $this->varPDOModelObj->selectexecuteQuery($sql, [':cid' => $contractId]);
            $contract = $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;

            if (!$contract) {
                echo json_encode(['status' => false, 'message' => 'Contract not found']);
                return;
            }

            // Fetch extensions
            $extSql = "SELECT * FROM tbl_vehicle_contract_extensions WHERE agreement_ids = :aid ORDER BY ids ASC";
            $extStmt = $this->varPDOModelObj->selectexecuteQuery($extSql, [':aid' => $contractId]);
            $extensions = $extStmt ? $extStmt->fetchAll(PDO::FETCH_ASSOC) : [];

            // Fetch ledger entries
            $agreementNo = $contract['agreement_no'] ?? '';
            $lSql = "SELECT * FROM tbl_customer_ledger WHERE contract_ids = :cid OR agreement_no = :refno ORDER BY ids ASC";
            $lStmt = $this->varPDOModelObj->selectexecuteQuery($lSql, [':cid' => $contractId, ':refno' => $agreementNo]);
            $ledger = $lStmt ? $lStmt->fetchAll(PDO::FETCH_ASSOC) : [];

            echo json_encode([
                'status'     => true,
                'contract'   => $contract,
                'extensions' => $extensions,
                'ledger'     => $ledger
            ]);

        } catch (\Throwable $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}

new ContractReturnOverdueController();
