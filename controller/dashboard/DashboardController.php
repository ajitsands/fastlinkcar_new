<?php
if (!headers_sent()) {
    header('Content-Type: application/json');
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!class_exists('ClassDatabaseConnection')) {
    require_once ROOT_PATH . '/model/db_connection/pdo_db_connection.php';
}
if (!class_exists('CommonPDOModel')) {
    require_once ROOT_PATH . '/model/common/pdoCommonFunctions.php';
}

if (!class_exists('DashboardController')) {
class DashboardController {
    private $pdo;
    private $requestData = [];

    public function __construct() {
        $this->pdo = new CommonPDOModel();
        $rawInput = file_get_contents("php://input");
        if ($rawInput) {
            $this->requestData = json_decode($rawInput, true) ?: [];
        } else {
            $this->requestData = $_REQUEST;
        }
        $this->handleRequest();
    }

    private function handleRequest() {
        $action = $this->requestData['action'] ?? '';
        switch ($action) {
            case 'getCompanies':
                $this->getCompanies();
                break;
            case 'getDashboardData':
                $this->getDashboardData();
                break;
            default:
                echo json_encode(['status' => false, 'message' => 'Invalid action']);
                break;
        }
    }

    public function getUserCompanyAccess() {
        $roleIds = array_map('intval', explode(',', strval($_SESSION['user_role_id'] ?? '')));
        $roleNames = array_map('trim', explode(',', strval($_SESSION['user_role_name'] ?? '')));
        $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || in_array(3, $roleIds) || in_array('Super Admin', $roleNames);
        $userId = $_SESSION['user_id'] ?? 0;

        $allCompanies = [];
        try {
            $stmt = $this->pdo->selectexecuteQuery("SELECT ids, company_name FROM tbl_company WHERE status = 'Active' ORDER BY ids ASC");
            if ($stmt && $stmt instanceof PDOStatement) {
                $allCompanies = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (\Throwable $e) {}

        if ($isSuperAdmin) {
            return [
                'is_super_admin'  => true,
                'has_multiple'    => true,
                'default_company' => 'all',
                'allowed_ids'     => array_map(function($c) { return intval($c['ids']); }, $allCompanies),
                'companies'       => $allCompanies
            ];
        }

        $userCompanies = [];
        if (!empty($_SESSION['company_json'])) {
            $decoded = is_string($_SESSION['company_json']) ? json_decode($_SESSION['company_json'], true) : $_SESSION['company_json'];
            if (is_array($decoded) && !empty($decoded)) {
                $userCompanies = $decoded;
            }
        }

        if (empty($userCompanies) && !empty($userId)) {
            try {
                $uStmt = $this->pdo->selectexecuteQuery("SELECT company_json, company_id FROM tbl_users WHERE id = :uid OR user_id = :uid LIMIT 1", [':uid' => $userId]);
                if ($uStmt && $uStmt instanceof PDOStatement) {
                    $uRow = $uStmt->fetch(PDO::FETCH_ASSOC);
                    if (!empty($uRow['company_json'])) {
                        $dec = json_decode($uRow['company_json'], true);
                        if (is_array($dec) && !empty($dec)) {
                            $userCompanies = $dec;
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
            'is_super_admin'  => false,
            'has_multiple'    => $hasMultiple,
            'default_company' => $defaultCompany,
            'allowed_ids'     => $allowedIds,
            'companies'       => $userCompanies
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

    private function getDashboardData() {
        try {
            $companyAccess = $this->getUserCompanyAccess();
            $companyFilter = trim($this->requestData['company_id'] ?? '');
            if (empty($companyFilter)) {
                $companyFilter = $companyAccess['default_company'];
            }

            // Timeframe filtering
            $timeframe = trim($this->requestData['timeframe'] ?? 'this_month');
            $customFrom = trim($this->requestData['from_date'] ?? '');
            $customTo = trim($this->requestData['to_date'] ?? '');

            $fromDate = null;
            $toDate = null;
            $today = date('Y-m-d');

            if ($timeframe === 'today') {
                $fromDate = $today;
                $toDate = $today;
            } else if ($timeframe === 'yesterday') {
                $fromDate = date('Y-m-d', strtotime('-1 day'));
                $toDate = $fromDate;
            } else if ($timeframe === 'this_week') {
                $fromDate = date('Y-m-d', strtotime('monday this week'));
                $toDate = $today;
            } else if ($timeframe === 'this_month') {
                $fromDate = date('Y-m-01');
                $toDate = date('Y-m-t');
            } else if ($timeframe === 'last_month') {
                $fromDate = date('Y-m-01', strtotime('first day of last month'));
                $toDate = date('Y-m-t', strtotime('last day of last month'));
            } else if ($timeframe === 'this_year') {
                $fromDate = date('Y-01-01');
                $toDate = date('Y-12-31');
            } else if ($timeframe === 'custom' && !empty($customFrom) && !empty($customTo)) {
                $fromDate = $customFrom;
                $toDate = $customTo;
            }

            // Build Company Where Clause helper
            $buildCompanyWhere = function($colName, &$params) use ($companyFilter, $companyAccess) {
                if ($companyFilter !== 'all' && !empty($companyFilter)) {
                    $cId = intval($companyFilter);
                    if ($companyAccess['is_super_admin'] || in_array($cId, $companyAccess['allowed_ids'])) {
                        $pKey = ':comp_' . str_replace('.', '_', $colName);
                        $params[$pKey] = $cId;
                        return "AND {$colName} = {$pKey}";
                    } else {
                        if (!empty($companyAccess['allowed_ids'])) {
                            $inList = implode(',', array_map('intval', $companyAccess['allowed_ids']));
                            return "AND {$colName} IN ({$inList})";
                        }
                    }
                } else {
                    if (!$companyAccess['is_super_admin']) {
                        if (!empty($companyAccess['allowed_ids'])) {
                            $inList = implode(',', array_map('intval', $companyAccess['allowed_ids']));
                            return "AND {$colName} IN ({$inList})";
                        }
                    }
                }
                return "";
            };

            // 1. FLEET METRICS & STATUS BREAKDOWN
            $fleetParams = [];
            $fleetCompWhere = $buildCompanyWhere('v.company_id', $fleetParams);
            $fleetSql = "
                SELECT 
                    COUNT(*) AS total_fleet,
                    COALESCE(SUM(CASE WHEN v.vehicle_status = 'Available' THEN 1 ELSE 0 END), 0) AS count_available,
                    COALESCE(SUM(CASE WHEN v.vehicle_status = 'Rentout' THEN 1 ELSE 0 END), 0) AS count_rentout,
                    COALESCE(SUM(CASE WHEN v.vehicle_status = 'Parking' THEN 1 ELSE 0 END), 0) AS count_parking,
                    COALESCE(SUM(CASE WHEN v.vehicle_status IN ('Maintenance', 'Workshop') THEN 1 ELSE 0 END), 0) AS count_maintenance,
                    COALESCE(SUM(CASE WHEN v.vehicle_status = 'Blocked' THEN 1 ELSE 0 END), 0) AS count_blocked,
                    COALESCE(SUM(CASE WHEN v.vehicle_status NOT IN ('Sold Out', 'Deactivated') THEN 1 ELSE 0 END), 0) AS active_fleet
                FROM tbl_vehicles v
                WHERE 1=1 {$fleetCompWhere}
            ";
            $fleetStmt = $this->pdo->selectexecuteQuery($fleetSql, $fleetParams);
            $fleetData = $fleetStmt ? $fleetStmt->fetch(PDO::FETCH_ASSOC) : [];

            $totalFleet = intval($fleetData['total_fleet'] ?? 0);
            $activeFleet = intval($fleetData['active_fleet'] ?? 0);
            $countAvailable = intval($fleetData['count_available'] ?? 0);
            $countRentout = intval($fleetData['count_rentout'] ?? 0);
            $countParking = intval($fleetData['count_parking'] ?? 0);
            $countMaintenance = intval($fleetData['count_maintenance'] ?? 0);
            $countBlocked = intval($fleetData['count_blocked'] ?? 0);

            // 2. ACTIVE CONTRACTS, EXTENSIONS & OVERDUE CALCULATION
            $contractsParams = [];
            $contractsCompWhere = $buildCompanyWhere('c.company_id', $contractsParams);
            $activeContractsSql = "
                SELECT c.*, 
                       comp.company_name,
                       cust.customer_name AS cust_full_name,
                       cust.customer_mobile,
                       cust.customer_cr_cpr
                FROM tbl_vehicle_rentout_contracts c
                LEFT JOIN tbl_company comp ON comp.ids = c.company_id
                LEFT JOIN customer_details cust ON cust.customer_id = c.customer_code
                WHERE c.agreement_status IN ('Rentout', 'Extended') {$contractsCompWhere}
                ORDER BY c.ids DESC
            ";
            $activeStmt = $this->pdo->selectexecuteQuery($activeContractsSql, $contractsParams);
            $activeContracts = $activeStmt ? $activeStmt->fetchAll(PDO::FETCH_ASSOC) : [];

            // Fetch extensions for all active contracts
            $activeContractIds = array_column($activeContracts, 'ids');
            $extensionsByContract = [];
            if (!empty($activeContractIds)) {
                $extIn = implode(',', array_map('intval', $activeContractIds));
                $extSql = "SELECT * FROM tbl_vehicle_contract_extensions WHERE agreement_ids IN ({$extIn}) ORDER BY extend_end_date ASC, ids ASC";
                $extStmt = $this->pdo->selectexecuteQuery($extSql);
                if ($extStmt) {
                    while ($er = $extStmt->fetch(PDO::FETCH_ASSOC)) {
                        $extensionsByContract[intval($er['agreement_ids'])][] = $er;
                    }
                }
            }

            $nowTs = time();
            $todayDate = date('Y-m-d');
            $countOverdue = 0;
            $countReturnsToday = 0;
            $countExtendedContracts = 0;
            $expectedReturnsList = [];
            $overdueAlerts = [];
            $returnsTodayAlerts = [];

            foreach ($activeContracts as $c) {
                $cId = intval($c['ids']);
                $cd = json_decode($c['contract_details_json'] ?? '', true) ?: [];
                $extList = $extensionsByContract[$cId] ?? [];

                $startDateTime = $cd['period_from'] ?? $c['service_start_date_time'] ?? '';
                $endDateTime   = $cd['period_to'] ?? $c['service_end_date_time'] ?? '';
                $initialDuration = intval($cd['duration'] ?? 0);

                $validDateTs = function($dt) {
                    if (empty($dt) || strpos(strval($dt), '0000-00-00') !== false) return false;
                    $ts = strtotime(strval($dt));
                    return ($ts !== false && $ts > 946684800) ? $ts : false;
                };

                $startTs = $validDateTs($startDateTime);
                $endTs = $validDateTs($endDateTime);

                if (!$endTs && $startTs) {
                    $endTs = strtotime('+' . max(1, $initialDuration) . ' days', $startTs);
                    $endDateTime = date('Y-m-d H:i:s', $endTs);
                }

                // Calculate latest expected return date considering extensions
                $expectedReturnDateStr = $endDateTime;
                $expectedReturnTs = $endTs;
                $isExtended = false;
                $totalExtDays = 0;
                $totalExtAmt = 0.0;

                if (!empty($extList)) {
                    $isExtended = true;
                    $countExtendedContracts++;
                    foreach ($extList as $ext) {
                        $ed = json_decode($ext['extend_details'] ?? '', true) ?: [];
                        $totalExtDays += intval($ed['duration'] ?? 0);
                        $totalExtAmt += floatval($ed['total_amt'] ?? 0);
                        $extEnd = $ext['extend_end_date'] ?? ($ed['period_to'] ?? '');
                        $extEndTs = $validDateTs($extEnd);
                        if ($extEndTs && (!$expectedReturnTs || $extEndTs > $expectedReturnTs)) {
                            $expectedReturnDateStr = $extEnd;
                            $expectedReturnTs = $extEndTs;
                        }
                    }
                }

                $expectedReturnDateOnly = $expectedReturnTs ? date('Y-m-d', $expectedReturnTs) : '';
                $expectedReturnDisplay = $expectedReturnTs ? date('d-m-Y H:i', $expectedReturnTs) : 'N/A';
                $startDisplay = $startTs ? date('d-m-Y', $startTs) : 'N/A';

                // Overdue status check
                $isOverdue = false;
                $isDueToday = false;
                $overdueDays = 0;
                $daysLeft = 0;

                if ($expectedReturnTs) {
                    if ($expectedReturnTs < $nowTs) {
                        $isOverdue = true;
                        $countOverdue++;
                        $overdueDays = max(1, round(($nowTs - $expectedReturnTs) / 86400));
                    } else {
                        if ($expectedReturnDateOnly === $todayDate) {
                            $isDueToday = true;
                            $countReturnsToday++;
                        }
                        $daysLeft = max(0, round(($expectedReturnTs - $nowTs) / 86400));
                    }
                }

                $custName = $c['cust_full_name'] ?? ($c['customer_name'] ?? 'N/A');
                $custMobile = $c['customer_mobile'] ?? 'N/A';
                $vehSummary = trim(($c['vehicle_no'] ?? '') . ' ' . ($c['model_name'] ?? ''));

                $rowItem = [
                    'contract_id'            => $cId,
                    'agreement_no'           => $c['agreement_no'],
                    'company_name'           => $c['company_name'] ?? 'AA Car Rental',
                    'customer_name'          => $custName,
                    'customer_mobile'        => $custMobile,
                    'customer_cpr'           => $c['customer_cr_cpr'] ?? 'N/A',
                    'vehicle_no'             => $c['vehicle_no'] ?? 'N/A',
                    'vehicle_summary'        => $vehSummary,
                    'start_date'             => $startDisplay,
                    'expected_return'        => $expectedReturnDisplay,
                    'expected_return_date'   => $expectedReturnDateOnly,
                    'is_overdue'             => $isOverdue,
                    'is_due_today'           => $isDueToday,
                    'overdue_days'           => $overdueDays,
                    'days_left'              => $daysLeft,
                    'is_extended'            => $isExtended,
                    'extension_count'        => count($extList),
                    'total_agreed_amount'    => number_format(floatval($cd['total_amt'] ?? 0) + $totalExtAmt, 3, '.', '')
                ];

                $expectedReturnsList[] = $rowItem;

                if ($isOverdue && count($overdueAlerts) < 8) {
                    $overdueAlerts[] = [
                        'agreement_no'   => $c['agreement_no'],
                        'contract_id'    => $cId,
                        'customer'       => $custName,
                        'customer_name'  => $custName,
                        'mobile'         => $custMobile,
                        'vehicle_no'     => $c['vehicle_no'] ?? '',
                        'vehicle_number' => $c['vehicle_no'] ?? '',
                        'days_overdue'   => $overdueDays,
                        'return_date'    => $expectedReturnDisplay
                    ];
                }

                if ($isDueToday && count($returnsTodayAlerts) < 8) {
                    $returnsTodayAlerts[] = [
                        'agreement_no'   => $c['agreement_no'],
                        'contract_id'    => $cId,
                        'customer'       => $custName,
                        'customer_name'  => $custName,
                        'mobile'         => $custMobile,
                        'vehicle_no'     => $c['vehicle_no'] ?? '',
                        'vehicle_number' => $c['vehicle_no'] ?? '',
                        'return_time'    => date('H:i', $expectedReturnTs)
                    ];
                }
            }

            // Sort expected returns table: Overdue first (descending overdue days), then Due Today, then upcoming
            usort($expectedReturnsList, function($a, $b) {
                if ($a['is_overdue'] && !$b['is_overdue']) return -1;
                if (!$a['is_overdue'] && $b['is_overdue']) return 1;
                if ($a['is_overdue'] && $b['is_overdue']) {
                    return $b['overdue_days'] - $a['overdue_days'];
                }
                return strcmp($a['expected_return_date'], $b['expected_return_date']);
            });

            // Utilization Rate (%)
            $utilizationRate = ($activeFleet > 0) ? round((($countRentout + $countExtendedContracts) / $activeFleet) * 100, 1) : 0.0;
            if ($utilizationRate > 100) $utilizationRate = 100.0;

            // 3. PERIOD FINANCIALS & COLLECTIONS
            $dateWhereLedger = "";
            $dateWhereContracts = "";
            $finParams = [];
            $ledgerCompWhere = $buildCompanyWhere('l.company_id', $finParams);

            if ($fromDate && $toDate) {
                $dateWhereLedger = "AND l.trans_date BETWEEN :f_date1 AND :t_date1";
                $finParams[':f_date1'] = $fromDate;
                $finParams[':t_date1'] = $toDate;
            }

            // Ledger Collections
            $ledgerSql = "
                SELECT 
                    COALESCE(SUM(l.credit), 0) AS period_collected,
                    COALESCE(SUM(l.debit), 0) AS period_billed,
                    COALESCE(SUM(CASE WHEN l.payment_method = 'Cash' THEN l.credit ELSE 0 END), 0) AS method_cash,
                    COALESCE(SUM(CASE WHEN l.payment_method = 'Card' THEN l.credit ELSE 0 END), 0) AS method_card,
                    COALESCE(SUM(CASE WHEN l.payment_method IN ('BenefitPay', 'Benefit Pay', 'Benefit') THEN l.credit ELSE 0 END), 0) AS method_benefit,
                    COALESCE(SUM(CASE WHEN l.payment_method IN ('Bank Transfer', 'Online Transfer', 'Cheque') THEN l.credit ELSE 0 END), 0) AS method_bank
                FROM tbl_customer_ledger l
                WHERE 1=1 {$ledgerCompWhere} {$dateWhereLedger}
            ";
            $ledgerStmt = $this->pdo->selectexecuteQuery($ledgerSql, $finParams);
            $finData = $ledgerStmt ? $ledgerStmt->fetch(PDO::FETCH_ASSOC) : [];

            // All-time outstanding customer balance for company
            $outParams = [];
            $outCompWhere = $buildCompanyWhere('l.company_id', $outParams);
            $outSql = "SELECT COALESCE(SUM(l.debit - l.credit), 0) AS net_outstanding FROM tbl_customer_ledger l WHERE 1=1 {$outCompWhere}";
            $outStmt = $this->pdo->selectexecuteQuery($outSql, $outParams);
            $outRow = $outStmt ? $outStmt->fetch(PDO::FETCH_ASSOC) : [];
            $netOutstanding = floatval($outRow['net_outstanding'] ?? 0);

            // Period Contracts Count
            $periodContractsParams = [];
            $pCompWhere = $buildCompanyWhere('c.company_id', $periodContractsParams);
            $pDateWhere = "";
            if ($fromDate && $toDate) {
                $pDateWhere = "AND c.agreement_date BETWEEN :pf_date AND :pt_date";
                $periodContractsParams[':pf_date'] = $fromDate;
                $periodContractsParams[':pt_date'] = $toDate;
            }
            $pContractsSql = "
                SELECT 
                    COUNT(*) AS count_new_contracts,
                    COALESCE(SUM(CASE WHEN c.agreement_status = 'Returned' THEN 1 ELSE 0 END), 0) AS count_returned_period
                FROM tbl_vehicle_rentout_contracts c
                WHERE 1=1 {$pCompWhere} {$pDateWhere}
            ";
            $pStmt = $this->pdo->selectexecuteQuery($pContractsSql, $periodContractsParams);
            $pData = $pStmt ? $pStmt->fetch(PDO::FETCH_ASSOC) : [];

            // 4. FLEET EXPIRY & MAINTENANCE ALERTS (Vehicles requiring compliance)
            $alertParams = [];
            $alertCompWhere = $buildCompanyWhere('v.company_id', $alertParams);
            $expirySql = "
                SELECT 
                    v.ids,
                    v.vehicle_number,
                    v.model_names,
                    v.vehicle_status,
                    v.next_passing_date,
                    v.next_insurance_date,
                    v.next_maintenance_date,
                    DATEDIFF(v.next_passing_date, CURDATE()) AS passing_days_left,
                    DATEDIFF(v.next_insurance_date, CURDATE()) AS insurance_days_left,
                    DATEDIFF(v.next_maintenance_date, CURDATE()) AS maintenance_days_left
                FROM tbl_vehicles v
                WHERE v.vehicle_status NOT IN ('Sold Out', 'Deactivated') {$alertCompWhere}
                  AND (
                      (v.next_insurance_date IS NOT NULL AND v.next_insurance_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY))
                   OR (v.next_passing_date IS NOT NULL AND v.next_passing_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY))
                   OR (v.next_maintenance_date IS NOT NULL AND v.next_maintenance_date <= DATE_ADD(CURDATE(), INTERVAL 14 DAY))
                  )
                ORDER BY LEAST(
                    COALESCE(v.next_insurance_date, '2099-12-31'),
                    COALESCE(v.next_passing_date, '2099-12-31'),
                    COALESCE(v.next_maintenance_date, '2099-12-31')
                ) ASC
                LIMIT 15
            ";
            $expiryStmt = $this->pdo->selectexecuteQuery($expirySql, $alertParams);
            $expiryVehicles = $expiryStmt ? $expiryStmt->fetchAll(PDO::FETCH_ASSOC) : [];

            $insuranceAlerts = [];
            $passingAlerts = [];
            $maintenanceAlerts = [];

            foreach ($expiryVehicles as $ev) {
                $vehNo = !empty($ev['vehicle_number']) ? $ev['vehicle_number'] : 'N/A';
                $modelName = !empty($ev['model_names']) ? $ev['model_names'] : 'N/A';

                if ($ev['insurance_days_left'] !== null && $ev['insurance_days_left'] <= 30 && !empty($ev['next_insurance_date']) && $ev['next_insurance_date'] !== '0000-00-00') {
                    $insDate = (strtotime($ev['next_insurance_date']) !== false) ? date('d-m-Y', strtotime($ev['next_insurance_date'])) : $ev['next_insurance_date'];
                    $insuranceAlerts[] = [
                        'vehicle_id'     => $ev['ids'],
                        'vehicle_no'     => $vehNo,
                        'vehicle_number' => $vehNo,
                        'model'          => $modelName,
                        'model_names'    => $modelName,
                        'days_left'      => intval($ev['insurance_days_left']),
                        'date'           => $insDate,
                        'expiry_date'    => $insDate
                    ];
                }
                if ($ev['passing_days_left'] !== null && $ev['passing_days_left'] <= 30 && !empty($ev['next_passing_date']) && $ev['next_passing_date'] !== '0000-00-00') {
                    $passDate = (strtotime($ev['next_passing_date']) !== false) ? date('d-m-Y', strtotime($ev['next_passing_date'])) : $ev['next_passing_date'];
                    $passingAlerts[] = [
                        'vehicle_id'     => $ev['ids'],
                        'vehicle_no'     => $vehNo,
                        'vehicle_number' => $vehNo,
                        'model'          => $modelName,
                        'model_names'    => $modelName,
                        'days_left'      => intval($ev['passing_days_left']),
                        'date'           => $passDate,
                        'expiry_date'    => $passDate
                    ];
                }
                if ($ev['maintenance_days_left'] !== null && $ev['maintenance_days_left'] <= 14 && !empty($ev['next_maintenance_date']) && $ev['next_maintenance_date'] !== '0000-00-00') {
                    $maintDate = (strtotime($ev['next_maintenance_date']) !== false) ? date('d-m-Y', strtotime($ev['next_maintenance_date'])) : $ev['next_maintenance_date'];
                    $maintenanceAlerts[] = [
                        'vehicle_id'     => $ev['ids'],
                        'vehicle_no'     => $vehNo,
                        'vehicle_number' => $vehNo,
                        'model'          => $modelName,
                        'model_names'    => $modelName,
                        'days_left'      => intval($ev['maintenance_days_left']),
                        'date'           => $maintDate,
                        'expiry_date'    => $maintDate
                    ];
                }
            }

            // 5. VEHICLE CATEGORY DISTRIBUTION
            $catParams = [];
            $catCompWhere = $buildCompanyWhere('v.company_id', $catParams);
            $catSql = "
                SELECT 
                    COALESCE(cat.category_name, 'Standard Fleet') AS category_name,
                    COALESCE(cat.category_name, 'Standard Fleet') AS category,
                    COUNT(v.ids) AS total_count,
                    COUNT(v.ids) AS total,
                    COALESCE(SUM(CASE WHEN v.vehicle_status = 'Rentout' THEN 1 ELSE 0 END), 0) AS rented_count,
                    COALESCE(SUM(CASE WHEN v.vehicle_status = 'Rentout' THEN 1 ELSE 0 END), 0) AS rented
                FROM tbl_vehicles v
                LEFT JOIN tbl_vehicle_category cat ON cat.ids = v.category_id
                WHERE v.vehicle_status NOT IN ('Sold Out', 'Deactivated') {$catCompWhere}
                GROUP BY cat.category_name
                ORDER BY total_count DESC
            ";
            $catStmt = $this->pdo->selectexecuteQuery($catSql, $catParams);
            $categoryDistribution = $catStmt ? $catStmt->fetchAll(PDO::FETCH_ASSOC) : [];

            // 6. RECENT CONTRACTS STREAM
            $recentParams = [];
            $recentCompWhere = $buildCompanyWhere('c.company_id', $recentParams);
            $recentSql = "
                SELECT 
                    c.ids,
                    c.agreement_no,
                    c.agreement_date,
                    c.agreement_status,
                    c.customer_name,
                    c.vehicle_no,
                    comp.company_name,
                    c.contract_details_json
                FROM tbl_vehicle_rentout_contracts c
                LEFT JOIN tbl_company comp ON comp.ids = c.company_id
                WHERE 1=1 {$recentCompWhere}
                ORDER BY c.ids DESC
                LIMIT 6
            ";
            $recentStmt = $this->pdo->selectexecuteQuery($recentSql, $recentParams);
            $recentContracts = [];
            if ($recentStmt) {
                while ($rc = $recentStmt->fetch(PDO::FETCH_ASSOC)) {
                    $rcd = json_decode($rc['contract_details_json'] ?? '', true) ?: [];
                    $recentContracts[] = [
                        'ids'              => $rc['ids'],
                        'agreement_no'     => $rc['agreement_no'],
                        'company_name'     => $rc['company_name'] ?? 'AA Car Rental',
                        'customer_name'    => $rc['customer_name'] ?? 'N/A',
                        'vehicle_no'       => $rc['vehicle_no'] ?? 'N/A',
                        'agreement_date'   => !empty($rc['agreement_date']) ? date('d-m-Y', strtotime($rc['agreement_date'])) : 'N/A',
                        'agreement_status' => $rc['agreement_status'] ?? 'Rentout',
                        'rent_amount'      => number_format(floatval($rcd['total_amt'] ?? 0), 3, '.', '')
                    ];
                }
            }

            echo json_encode([
                'status' => true,
                'data'   => [
                    'kpis' => [
                        'total_fleet'            => $totalFleet,
                        'active_fleet'           => $activeFleet,
                        'available_fleet'        => $countAvailable,
                        'rented_fleet'           => $countRentout,
                        'parking_fleet'          => $countParking,
                        'maintenance_fleet'      => $countMaintenance,
                        'blocked_fleet'          => $countBlocked,
                        'utilization_rate'       => $utilizationRate,
                        'active_contracts'       => count($activeContracts),
                        'extended_contracts'     => $countExtendedContracts,
                        'overdue_count'          => $countOverdue,
                        'returns_today_count'    => $countReturnsToday,
                        'period_revenue'         => number_format(floatval($finData['period_billed'] ?? 0), 3, '.', ''),
                        'period_collections'     => number_format(floatval($finData['period_collected'] ?? 0), 3, '.', ''),
                        'net_outstanding'        => number_format($netOutstanding, 3, '.', ''),
                        'new_contracts_count'    => intval($pData['count_new_contracts'] ?? 0),
                        'returned_contracts_count'=> intval($pData['count_returned_period'] ?? 0)
                    ],
                    'fleet_breakdown' => [
                        ['label' => 'Available', 'count' => $countAvailable, 'color' => '#10b981', 'status' => 'Available'],
                        ['label' => 'On Rent', 'count' => $countRentout, 'color' => '#3b82f6', 'status' => 'Rentout'],
                        ['label' => 'In Parking', 'count' => $countParking, 'color' => '#06b6d4', 'status' => 'Parking'],
                        ['label' => 'Maintenance', 'count' => $countMaintenance, 'color' => '#f59e0b', 'status' => 'Maintenance'],
                        ['label' => 'Blocked', 'count' => $countBlocked, 'color' => '#ef4444', 'status' => 'Blocked']
                    ],
                    'payment_methods' => [
                        'cash'    => number_format(floatval($finData['method_cash'] ?? 0), 3, '.', ''),
                        'card'    => number_format(floatval($finData['method_card'] ?? 0), 3, '.', ''),
                        'benefit' => number_format(floatval($finData['method_benefit'] ?? 0), 3, '.', ''),
                        'bank'    => number_format(floatval($finData['method_bank'] ?? 0), 3, '.', '')
                    ],
                    'categories'        => $categoryDistribution,
                    'alerts'            => [
                        'overdue'     => $overdueAlerts,
                        'due_today'   => $returnsTodayAlerts,
                        'insurance'   => $insuranceAlerts,
                        'passing'     => $passingAlerts,
                        'maintenance' => $maintenanceAlerts,
                        'total_alerts'=> count($overdueAlerts) + count($returnsTodayAlerts) + count($insuranceAlerts) + count($passingAlerts) + count($maintenanceAlerts)
                    ],
                    'expected_returns'  => array_slice($expectedReturnsList, 0, 50),
                    'recent_contracts'  => $recentContracts,
                    'timeframe_label'   => ucfirst(str_replace('_', ' ', $timeframe)),
                    'date_range'        => [
                        'from' => $fromDate ? date('d-m-Y', strtotime($fromDate)) : 'All Time',
                        'to'   => $toDate ? date('d-m-Y', strtotime($toDate)) : ''
                    ]
                ]
            ]);
        } catch (\Throwable $e) {
            echo json_encode([
                'status'  => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
}

new DashboardController();

