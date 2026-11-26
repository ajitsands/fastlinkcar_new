<?php
// controller/reports/VehicleMovementReportController.php
session_start();
require_once ROOT_PATH . '/__db.php';
require_once ROOT_PATH . '/model/common/VehicleStatusHelper.php';
$pdo = getPDO();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'get_companies') {
    // Get companies user has access to
    $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || (($_SESSION['user_role_id'] ?? 0) == 3);
    
    $userCompanyIds = [strval($_SESSION['company_id'] ?? '1')];
    if (!empty($_SESSION['company_json'])) {
        $cArr = json_decode($_SESSION['company_json'], true);
        if (is_array($cArr)) {
            foreach ($cArr as $c) {
                if (!empty($c['ids'])) {
                    $userCompanyIds[] = strval($c['ids']);
                }
            }
        }
    }
    $userCompanyIds = array_unique($userCompanyIds);
    $idListStr = implode("','", array_map('addslashes', $userCompanyIds));
    
    if ($isSuperAdmin) {
        $stmt = $pdo->prepare("SELECT ids, company_name FROM tbl_company WHERE status = 'Active' ORDER BY ids ASC");
    } else {
        $stmt = $pdo->prepare("SELECT ids, company_name FROM tbl_company WHERE status = 'Active' AND ids IN ('{$idListStr}') ORDER BY ids ASC");
    }
    
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

if ($action === 'get_vehicles') {
    $company_id = $_POST['company_id'] ?? '';
    
    $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || (($_SESSION['user_role_id'] ?? 0) == 3);
    
    $where = [];
    $params = [];
    
    if (!$isSuperAdmin) {
        $userCompanyIds = [strval($_SESSION['company_id'] ?? '1')];
        if (!empty($_SESSION['company_json'])) {
            $cArr = json_decode($_SESSION['company_json'], true);
            if (is_array($cArr)) {
                foreach ($cArr as $c) {
                    if (!empty($c['ids'])) {
                        $userCompanyIds[] = strval($c['ids']);
                    }
                }
            }
        }
        $userCompanyIds = array_unique($userCompanyIds);
        $idListStr = implode(',', array_map('intval', $userCompanyIds));
        
        $where[] = "v.company_id IN ($idListStr)";
    }
    
    if (!empty($company_id)) {
        $where[] = "v.company_id = ?";
        $params[] = $company_id;
    }
    
    $whereSql = "1=1";
    if (!empty($where)) {
        $whereSql = implode(" AND ", $where);
    }
    
    $sql = "
        SELECT 
            v.ids, 
            v.vehicle_number, 
            v.model_names, 
            v.chassis_number, 
            b.brand_name 
        FROM tbl_vehicles v
        LEFT JOIN tbl_vehicle_brand b ON v.brand_id = b.ids
        WHERE $whereSql 
        ORDER BY v.vehicle_number ASC
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Format the text for the dropdown
    foreach ($vehicles as &$v) {
        $b = $v['brand_name'] ?? 'Unknown Brand';
        $m = $v['model_names'] ?? 'Unknown Model';
        $c = $v['chassis_number'] ?? 'N/A';
        // Example: AB-1234 (Toyota Corolla | Chassis: XYZ123)
        $v['display_text'] = "{$v['vehicle_number']} ({$b} {$m} | Chassis: {$c})";
    }
    
    echo json_encode($vehicles);
    exit;
}

if ($action === 'get_report') {
    $company_id = $_POST['company_id'] ?? '';
    $vehicle_id = $_POST['vehicle_id'] ?? '';
    $from_date = $_POST['from_date'] ?? '';
    $to_date = $_POST['to_date'] ?? '';
    
    $isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || (($_SESSION['user_role_id'] ?? 0) == 3);
    
    $where = [];
    $params = [];
    
    if (!$isSuperAdmin) {
        $userCompanyIds = [strval($_SESSION['company_id'] ?? '1')];
        if (!empty($_SESSION['company_json'])) {
            $cArr = json_decode($_SESSION['company_json'], true);
            if (is_array($cArr)) {
                foreach ($cArr as $c) {
                    if (!empty($c['ids'])) {
                        $userCompanyIds[] = strval($c['ids']);
                    }
                }
            }
        }
        $userCompanyIds = array_unique($userCompanyIds);
        $idListStr = implode(',', array_map('intval', $userCompanyIds));
        
        $where[] = "v.company_id IN ($idListStr)";
    }
    
    if (!empty($company_id)) {
        $where[] = "v.company_id = ?";
        $params[] = $company_id;
    }
    
    if (!empty($vehicle_id)) {
        $where[] = "l.vehicle_ids = ?";
        $params[] = $vehicle_id;
    }
    
    if (!empty($to_date)) {
        $to_datetime = ($to_date === date('Y-m-d')) ? date('Y-m-d H:i:s') : date('Y-m-d 23:59:59', strtotime($to_date));
    } else {
        $to_datetime = date('Y-m-d H:i:s');
    }

    $hasCustomFrom = !empty($from_date);
    $from_datetime = $hasCustomFrom ? date('Y-m-d 00:00:00', strtotime($from_date)) : '';
    
    $where[] = "l.log_datetime <= ?";
    $params[] = $to_datetime;
    
    $whereSql = implode(" AND ", $where);
    
    $sql = "
        SELECT 
            l.log_datetime,
            l.action_type,
            l.new_status,
            v.vehicle_number,
            b.brand_name,
            v.model_names,
            v.vehicle_year,
            v.vehicle_color,
            v.chassis_number,
            v.engine_type,
            v.transmission,
            v.vehicle_status,
            v.created_on,
            v.is_outsourced,
            oc.company_name as outsourcing_company_name,
            cat.category_name,
            l.vehicle_ids,
            comp.company_name as vehicle_company_name
        FROM tbl_vehicle_log_movement l
        JOIN tbl_vehicles v ON v.ids = l.vehicle_ids
        LEFT JOIN tbl_vehicle_brand b ON v.brand_id = b.ids
        LEFT JOIN tbl_vehicle_category cat ON v.category_id = cat.ids
        LEFT JOIN tbl_outsourcing_companies oc ON v.outsourcing_company_id = oc.ids
        LEFT JOIN tbl_company comp ON v.company_id = comp.ids
        WHERE $whereSql
        ORDER BY l.vehicle_ids ASC, l.log_datetime ASC
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Group logs by vehicle
    $vehicle_timelines = [];
    $vehicle_details = [];
    
    foreach ($logs as $log) {
        $vid = $log['vehicle_ids'];
        if (!isset($vehicle_timelines[$vid])) {
            $vehicle_timelines[$vid] = [];
            $vehicle_details[$vid] = [
                'vehicle_number' => $log['vehicle_number'],
                'brand_name' => $log['brand_name'],
                'model_names' => $log['model_names'],
                'vehicle_year' => $log['vehicle_year'],
                'vehicle_color' => $log['vehicle_color'],
                'chassis_number' => $log['chassis_number'],
                'engine_type' => $log['engine_type'],
                'transmission' => $log['transmission'],
                'vehicle_status' => $log['vehicle_status'],
                'created_on' => $log['created_on'],
                'is_outsourced' => $log['is_outsourced'],
                'outsourcing_company_name' => $log['outsourcing_company_name'],
                'category_name' => $log['category_name'],
                'vehicle_company_name' => $log['vehicle_company_name']
            ];
        }
        $vehicle_timelines[$vid][] = [
            'time' => strtotime($log['log_datetime']),
            'action_type' => $log['action_type'],
            'status' => $log['new_status']
        ];
    }
    
    $global_period_start = $hasCustomFrom ? strtotime($from_datetime) : null;
    $period_end = strtotime($to_datetime);
    
    $html = "";
    if (empty($vehicle_timelines)) {
        $html .= "<tr><td colspan='6' class='text-center'>No vehicles found matching the criteria.</td></tr>";
    } else {
        foreach ($vehicle_timelines as $vid => $timeline) {
            $vDetails = $vehicle_details[$vid];
            $regDisplay = (!empty($vDetails['created_on']) && strpos($vDetails['created_on'], '0000-00-00') === false)
                ? date('d M Y', strtotime($vDetails['created_on']))
                : date('d M Y', $timeline[0]['time']);
            $regTs = (!empty($vDetails['created_on']) && strpos($vDetails['created_on'], '0000-00-00') === false)
                ? strtotime($vDetails['created_on'])
                : false;
            $firstLogTs = $timeline[0]['time'];
            if ($global_period_start !== null) {
                $period_start = $global_period_start;
            } else {
                $period_start = ($regTs && $regTs > 946684800) ? min($regTs, $firstLogTs) : $firstLogTs;
            }
            if ($period_start >= $period_end) {
                continue;
            }

            $rented_secs = 0;
            $maintenance_secs = 0;
            $idle_secs = 0;

            if ($global_period_start === null && $firstLogTs > $period_start) {
                $idle_secs += min($firstLogTs, $period_end) - $period_start;
            }
            
            $cnt = count($timeline);
            for ($i = 0; $i < $cnt; $i++) {
                $current_time = $timeline[$i]['time'];
                $rawStatus = trim((string)($timeline[$i]['status'] ?? ''));
                if ($rawStatus === '' && strcasecmp(trim((string)($timeline[$i]['action_type'] ?? '')), 'Rentout') === 0) {
                    $rawStatus = 'Rentout';
                }
                $status = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $rawStatus));
                
                $next_time = ($i + 1 < $cnt) ? $timeline[$i+1]['time'] : $period_end;
                if ($next_time > $period_end) $next_time = $period_end;
                
                // Find intersection of [current_time, next_time] and [period_start, period_end]
                $overlap_start = max($current_time, $period_start);
                $overlap_end = min($next_time, $period_end);
                
                if ($overlap_start < $overlap_end) {
                    $duration = $overlap_end - $overlap_start;
                    
                    if ($status === 'rentout' || $status === 'rented' || $status === 'onrent') {
                        $rented_secs += $duration;
                    } else if ($status === 'maintenance') {
                        $maintenance_secs += $duration;
                    } else {
                        // Anything else (available, parking, etc) is considered idle
                        $idle_secs += $duration;
                    }
                }
            }
            
            $total_tracked_secs = $rented_secs + $maintenance_secs + $idle_secs;
            
            // If the vehicle was created AFTER the period start, it won't have 100% tracked time.
            // But we will base Utilization on the actual tracked time within the period to be fair.
            if ($total_tracked_secs == 0) continue; // Vehicle had no tracked time in this period
            
            $utilization_pct = ($rented_secs / $total_tracked_secs) * 100;
            
            $days_rented = round($rented_secs / 86400, 1);
            $days_maint = round($maintenance_secs / 86400, 1);
            $days_idle = round($idle_secs / 86400, 1);
            $days_total = round($total_tracked_secs / 86400, 1);
            
            $vDetails = $vehicle_details[$vid];
            $regDisplay = (!empty($vDetails['created_on']) && strpos($vDetails['created_on'], '0000-00-00') === false)
                ? date('d M Y', strtotime($vDetails['created_on']))
                : date('d M Y', $timeline[0]['time']);
            $vehNo = htmlspecialchars($vDetails['vehicle_number'] ?? '-');
            $vehBrand = trim((string) ($vDetails['brand_name'] ?? ''));
            $vehModel = trim((string) ($vDetails['model_names'] ?? ''));
            $brandAndModel = htmlspecialchars(trim($vehBrand . ($vehBrand !== '' && $vehModel !== '' ? ' - ' : '') . $vehModel));
            $vehCat = htmlspecialchars($vDetails['category_name'] ?? '-');
            $vehYr = htmlspecialchars($vDetails['vehicle_year'] ?? '-');
            $vehClrRaw = trim((string) ($vDetails['vehicle_color'] ?? ''));
            $vehClr = $vehClrRaw !== '' ? htmlspecialchars($vehClrRaw) : '-';
            $dotColor = $vehClrRaw !== '' ? htmlspecialchars($vehClrRaw) : '#697a8d';
            $vehEngine = htmlspecialchars(!empty($vDetails['engine_type']) ? $vDetails['engine_type'] : '-');
            $vehTrans = htmlspecialchars(!empty($vDetails['transmission']) ? $vDetails['transmission'] : '-');
            $chassis = !empty($vDetails['chassis_number']) ? htmlspecialchars($vDetails['chassis_number']) : 'N/A';
            $compName = htmlspecialchars($vDetails['vehicle_company_name'] ?? '');
            $curStatusRaw = $vDetails['vehicle_status'] ?? '';
            $curStatus = htmlspecialchars($curStatusRaw);
            $curStatusStyle = $curStatusRaw !== '' ? VehicleStatusHelper::getBadgeStyle($curStatusRaw) : '';
            $isOutsourced = ($vDetails['is_outsourced'] ?? '') === 'Yes';
            $outsourceName = htmlspecialchars($vDetails['outsourcing_company_name'] ?? '');

            $vehicleBadgesHtml = "<span class='badge bg-label-secondary me-1'>{$vehCat}</span>";
            $vehicleBadgesHtml .= "<span class='badge bg-label-info me-1'><i class='ri-calendar-line me-1'></i>{$vehYr}</span>";
            $vehicleBadgesHtml .= "<span class='badge bg-label-warning me-1'><span style='display:inline-block;width:7px;height:7px;border-radius:50%;background-color:{$dotColor};margin-right:4px;vertical-align:middle;'></span>{$vehClr}</span>";
            $vehicleBadgesHtml .= "<span class='badge bg-label-success me-1'><i class='ri-gas-station-line me-1'></i>{$vehEngine}</span>";
            $vehicleBadgesHtml .= "<span class='badge bg-label-primary'><i class='ri-settings-3-line me-1'></i>{$vehTrans}</span>";

            $vehicleMetaHtml = "<div class='small text-muted mt-1 d-flex flex-wrap align-items-center gap-2'>"
                . "<span><i class='ri-barcode-line me-1'></i>Chassis: <strong>{$chassis}</strong></span>"
                . "<span><i class='ri-calendar-check-line me-1'></i>Reg: <strong>{$regDisplay}</strong></span>";
            if ($compName !== '') {
                $vehicleMetaHtml .= "<span class='text-success'><i class='ri-building-line me-1'></i>{$compName}</span>";
            }
            if ($isOutsourced && $outsourceName !== '') {
                $vehicleMetaHtml .= "<span class='badge bg-label-warning'><i class='ri-share-forward-line me-1'></i>Outsource: {$outsourceName}</span>";
            }
            $vehicleMetaHtml .= "</div>";

            $html .= "<tr>";
            $html .= "<td>
                        <div class='mb-1'><span class='fw-bold text-primary me-1'>{$vehNo}</span><span class='fw-semibold text-dark'>{$brandAndModel}</span>" . ($curStatus !== '' ? " <span class='badge ms-1' style='{$curStatusStyle}'>{$curStatus}</span>" : "") . "</div>
                        <div class='d-flex flex-wrap gap-1'>{$vehicleBadgesHtml}</div>
                        {$vehicleMetaHtml}
                      </td>";
            $html .= "<td>{$days_total}</td>";
            $html .= "<td>{$days_rented}</td>";
            $html .= "<td>{$days_maint}</td>";
            $html .= "<td>{$days_idle}</td>";
            
            $pct_formatted = number_format($utilization_pct, 1);
            
            // Color based on utilization
            $barColor = 'bg-danger';
            if ($utilization_pct >= 75) $barColor = 'bg-success';
            else if ($utilization_pct >= 40) $barColor = 'bg-primary';
            else if ($utilization_pct >= 20) $barColor = 'bg-warning';
            
            $html .= "
                <td>
                    <div class='d-flex justify-content-between mb-1'>
                        <span class='text-muted'>{$pct_formatted}%</span>
                    </div>
                    <div class='progress' style='height: 8px;'>
                        <div class='progress-bar {$barColor}' role='progressbar' style='width: {$pct_formatted}%' aria-valuenow='{$pct_formatted}' aria-valuemin='0' aria-valuemax='100'></div>
                    </div>
                </td>
            ";
            
            $html .= "</tr>";
        }
        
        if (empty($html)) {
            $html .= "<tr><td colspan='6' class='text-center'>No active vehicles found in this period.</td></tr>";
        }
    }
    
    echo $html;
    exit;
}
?>
