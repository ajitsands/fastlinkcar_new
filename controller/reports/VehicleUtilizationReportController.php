<?php
// controller/reports/VehicleMovementReportController.php
session_start();
require_once ROOT_PATH . '/__db.php';
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
        $to_datetime = date('Y-m-d 23:59:59', strtotime($to_date));
    } else {
        $to_datetime = date('Y-m-d 23:59:59');
    }
    
    if (!empty($from_date)) {
        $from_datetime = date('Y-m-d 00:00:00', strtotime($from_date));
    } else {
        $from_datetime = date('Y-m-01 00:00:00', strtotime($to_datetime));
    }
    
    $where[] = "l.log_datetime <= ?";
    $params[] = $to_datetime;
    
    $whereSql = implode(" AND ", $where);
    
    $sql = "
        SELECT 
            l.log_datetime,
            l.new_status,
            v.vehicle_number,
            v.model_names,
            v.vehicle_year,
            v.chassis_number,
            l.vehicle_ids,
            comp.company_name as vehicle_company_name
        FROM tbl_vehicle_log_movement l
        JOIN tbl_vehicles v ON v.ids = l.vehicle_ids
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
                'model_names' => $log['model_names'],
                'vehicle_year' => $log['vehicle_year'],
                'chassis_number' => $log['chassis_number'],
                'vehicle_company_name' => $log['vehicle_company_name']
            ];
        }
        $vehicle_timelines[$vid][] = [
            'time' => strtotime($log['log_datetime']),
            'status' => $log['new_status']
        ];
    }
    
    $period_start = strtotime($from_datetime);
    $period_end = strtotime($to_datetime);
    $period_total_secs = $period_end - $period_start;
    
    $html = "";
    if (empty($vehicle_timelines)) {
        $html .= "<tr><td colspan='6' class='text-center'>No vehicles found matching the criteria.</td></tr>";
    } else {
        foreach ($vehicle_timelines as $vid => $timeline) {
            $rented_secs = 0;
            $maintenance_secs = 0;
            $idle_secs = 0;
            
            $cnt = count($timeline);
            for ($i = 0; $i < $cnt; $i++) {
                $current_time = $timeline[$i]['time'];
                $status = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $timeline[$i]['status']));
                
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
            $detailsStr = htmlspecialchars($vDetails['vehicle_number'] . ' - ' . $vDetails['model_names'] . ' (' . $vDetails['vehicle_year'] . ')');
            $chassis = htmlspecialchars($vDetails['chassis_number'] ?? '');
            $compName = htmlspecialchars($vDetails['vehicle_company_name'] ?? '');
            
            $html .= "<tr>";
            $html .= "<td><strong>{$detailsStr}</strong><br>
                        <span class='badge bg-label-info mt-1 me-1'>Chassis: {$chassis}</span>
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
