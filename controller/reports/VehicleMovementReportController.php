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
    
    if (!empty($from_date)) {
        $where[] = "DATE(l.log_datetime) >= ?";
        $params[] = date('Y-m-d', strtotime($from_date));
    }
    
    if (!empty($to_date)) {
        $where[] = "DATE(l.log_datetime) <= ?";
        $params[] = date('Y-m-d', strtotime($to_date));
    }
    
    $whereSql = !empty($where) ? implode(" AND ", $where) : "1=1";
    
    $sql = "
        SELECT 
            l.ids,
            l.log_datetime,
            l.action_type,
            l.old_status,
            l.new_status,
            l.reference_no,
            l.remarks,
            l.odometer,
            l.created_name,
            v.vehicle_number,
            b.brand_name,
            v.model_names,
            v.vehicle_year,
            v.vehicle_color,
            v.chassis_number,
            v.engine_type,
            v.transmission,
            v.vehicle_status,
            v.is_outsourced,
            oc.company_name as outsourcing_company_name,
            cat.category_name,
            l.vehicle_ids,
            c.customer_name as log_customer_name,
            comp.company_name as vehicle_company_name,
            st.staff_name,
            g.garage_name
        FROM tbl_vehicle_log_movement l
        JOIN tbl_vehicles v ON v.ids = l.vehicle_ids
        LEFT JOIN tbl_vehicle_brand b ON v.brand_id = b.ids
        LEFT JOIN tbl_vehicle_category cat ON v.category_id = cat.ids
        LEFT JOIN tbl_outsourcing_companies oc ON v.outsourcing_company_id = oc.ids
        LEFT JOIN customer_details c ON l.customer_id = c.ids
        LEFT JOIN tbl_company comp ON v.company_id = comp.ids
        LEFT JOIN tbl_staff st ON l.staff_id = st.ids
        LEFT JOIN tbl_garages g ON l.garage_id = g.ids
        WHERE $whereSql
        ORDER BY l.vehicle_ids ASC, l.log_datetime ASC
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Process "KM Used"
    // Since we order by vehicle_ids ASC, log_datetime ASC, we can just track the previous odometer reading for each vehicle
    $processed_logs = [];
    $prev_odometer = [];
    
    foreach ($logs as $log) {
        $vid = $log['vehicle_ids'];
        $current_odo = intval($log['odometer']);
        
        $km_used = 0;
        if (isset($prev_odometer[$vid]) && $current_odo > 0 && $prev_odometer[$vid] > 0) {
            $km_used = $current_odo - $prev_odometer[$vid];
            if ($km_used < 0) $km_used = 0; // Just in case of invalid data
        }
        
        if ($current_odo > 0) {
            $prev_odometer[$vid] = $current_odo;
        }
        
        $log['km_used'] = $km_used > 0 ? $km_used : '-';
        $processed_logs[] = $log;
    }
    
    // Calculate duration for each status
    $cnt = count($processed_logs);
    for ($i = 0; $i < $cnt; $i++) {
        $vid = $processed_logs[$i]['vehicle_ids'];
        $next_time = null;
        if ($i + 1 < $cnt && $processed_logs[$i+1]['vehicle_ids'] == $vid) {
            $next_time = $processed_logs[$i+1]['log_datetime'];
        } else {
            $next_time = date('Y-m-d H:i:s'); // until now
        }
        
        $diff = strtotime($next_time) - strtotime($processed_logs[$i]['log_datetime']);
        if ($diff < 0) $diff = 0;
        $days = floor($diff / 86400);
        $hours = floor(($diff % 86400) / 3600);
        $mins = floor(($diff % 3600) / 60);
        
        $duration_str = "";
        if ($days > 0) $duration_str .= "{$days}d ";
        if ($hours > 0 || $days > 0) $duration_str .= "{$hours}h ";
        $duration_str .= "{$mins}m";
        
        $processed_logs[$i]['duration'] = trim($duration_str);
    }

    // Order movement logs by descending date/time (newest first)
    usort($processed_logs, function ($a, $b) {
        $ta = strtotime($a['log_datetime'] ?? '1970-01-01 00:00:00');
        $tb = strtotime($b['log_datetime'] ?? '1970-01-01 00:00:00');
        if ($tb !== $ta) {
            return $tb <=> $ta;
        }
        return ((int)($b['ids'] ?? 0)) <=> ((int)($a['ids'] ?? 0));
    });
    
    $html = "";
    if (empty($processed_logs)) {
        $html .= "<tr><td colspan='7' class='text-center text-muted py-3'>No movement logs found matching the criteria.</td></tr>";
    } else {
        foreach ($processed_logs as $log) {
            $dateFormatted = date('d M Y, H:i', strtotime($log['log_datetime']));
            $vehNo = htmlspecialchars($log['vehicle_number'] ?? '-');
            $vehBrand = trim((string) ($log['brand_name'] ?? ''));
            $vehModel = trim((string) ($log['model_names'] ?? ''));
            $brandAndModel = htmlspecialchars(trim($vehBrand . ($vehBrand !== '' && $vehModel !== '' ? ' - ' : '') . $vehModel));
            $vehCat = htmlspecialchars($log['category_name'] ?? '-');
            $vehYr = htmlspecialchars($log['vehicle_year'] ?? '-');
            $vehClrRaw = trim((string) ($log['vehicle_color'] ?? ''));
            $vehClr = $vehClrRaw !== '' ? htmlspecialchars($vehClrRaw) : '-';
            $dotColor = $vehClrRaw !== '' ? htmlspecialchars($vehClrRaw) : '#697a8d';
            $vehEngine = htmlspecialchars(!empty($log['engine_type']) ? $log['engine_type'] : '-');
            $vehTrans = htmlspecialchars(!empty($log['transmission']) ? $log['transmission'] : '-');
            $chassis = !empty($log['chassis_number']) ? htmlspecialchars($log['chassis_number']) : 'N/A';
            $compName = htmlspecialchars($log['vehicle_company_name'] ?? '');
            $curStatusRaw = $log['vehicle_status'] ?? '';
            $curStatus = htmlspecialchars($curStatusRaw);
            $curStatusStyle = $curStatusRaw !== '' ? VehicleStatusHelper::getBadgeStyle($curStatusRaw) : '';
            $isOutsourced = ($log['is_outsourced'] ?? '') === 'Yes';
            $outsourceName = htmlspecialchars($log['outsourcing_company_name'] ?? '');

            $vehicleBadgesHtml = "<span class='badge bg-label-secondary me-1'>{$vehCat}</span>";
            $vehicleBadgesHtml .= "<span class='badge bg-label-info me-1'><i class='ri-calendar-line me-1'></i>{$vehYr}</span>";
            $vehicleBadgesHtml .= "<span class='badge bg-label-warning me-1'><span style='display:inline-block;width:7px;height:7px;border-radius:50%;background-color:{$dotColor};margin-right:4px;vertical-align:middle;'></span>{$vehClr}</span>";
            $vehicleBadgesHtml .= "<span class='badge bg-label-success me-1'><i class='ri-gas-station-line me-1'></i>{$vehEngine}</span>";
            $vehicleBadgesHtml .= "<span class='badge bg-label-primary'><i class='ri-settings-3-line me-1'></i>{$vehTrans}</span>";

            $vehicleMetaHtml = "<div class='small text-muted mt-1 d-flex flex-wrap align-items-center gap-2'>"
                . "<span><i class='ri-barcode-line me-1'></i>Chassis: <strong>{$chassis}</strong></span>";
            if ($compName !== '') {
                $vehicleMetaHtml .= "<span class='text-success'><i class='ri-building-line me-1'></i>{$compName}</span>";
            }
            if ($isOutsourced && $outsourceName !== '') {
                $vehicleMetaHtml .= "<span class='badge bg-label-warning'><i class='ri-share-forward-line me-1'></i>Outsource: {$outsourceName}</span>";
            }
            $vehicleMetaHtml .= "</div>";

            $html .= "<tr>";
            $html .= "<td class='text-nowrap'>{$dateFormatted}</td>";
            $html .= "<td>
                        <div class='mb-1'><span class='fw-bold text-primary me-1'>{$vehNo}</span><span class='fw-semibold text-dark'>{$brandAndModel}</span>" . ($curStatus !== '' ? " <span class='badge ms-1' style='{$curStatusStyle}'>{$curStatus}</span>" : "") . "</div>
                        <div class='d-flex flex-wrap gap-1'>{$vehicleBadgesHtml}</div>
                        {$vehicleMetaHtml}
                      </td>";
            
            // Master Status Badge Colors
            $oldStatusRaw = trim((string)($log['old_status'] ?? ''));
            $newStatusRaw = trim((string)($log['new_status'] ?? ''));
            if ($newStatusRaw === '' && strcasecmp(trim((string)($log['action_type'] ?? '')), 'Rentout') === 0) {
                $newStatusRaw = 'Rentout';
            }
            $oldStatusEsc = $oldStatusRaw !== '' ? htmlspecialchars($oldStatusRaw) : 'N/A';
            $newStatusEsc = $newStatusRaw !== '' ? htmlspecialchars($newStatusRaw) : '-';

            if ($log['action_type'] === 'Creation' || $oldStatusRaw === '') {
                $oldStatusHtml = '<span class="badge rounded-pill bg-label-secondary">N/A</span>';
            } else {
                $oldStyle = VehicleStatusHelper::getBadgeStyle($oldStatusRaw);
                $oldStatusHtml = "<span class='badge rounded-pill' style='{$oldStyle}'>{$oldStatusEsc}</span>";
            }

            $newStyle = $newStatusRaw !== '' ? VehicleStatusHelper::getBadgeStyle($newStatusRaw) : '';
            $ns = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $newStatusRaw));
            
            $html .= "<td class='text-center'>{$oldStatusHtml}</td>";
            
            $details = "";
            if ($ns === 'rentout' && !empty($log['log_customer_name'])) {
                $details .= "<br><small class='text-muted'>Cust: " . htmlspecialchars($log['log_customer_name']) . "</small>";
            }
            if (!empty($log['staff_name'])) {
                $details .= "<br><small class='text-muted'>Staff: " . htmlspecialchars($log['staff_name']) . "</small>";
            }
            if (!empty($log['garage_name'])) {
                $details .= "<br><small class='text-muted'>Garage: " . htmlspecialchars($log['garage_name']) . "</small>";
            }
            if (!empty($log['reference_no'])) {
                $details .= "<br><small class='text-muted'>Ref No: " . htmlspecialchars($log['reference_no']) . "</small>";
            }
            
            $details .= "<br><small class='text-muted'>Duration: {$log['duration']}</small>";
            
            $newBadgeHtml = $newStyle !== ''
                ? "<span class='badge rounded-pill' style='{$newStyle}'>{$newStatusEsc}</span>"
                : "<span class='badge rounded-pill bg-label-primary'>{$newStatusEsc}</span>";
            $html .= "<td>{$newBadgeHtml}<br><small class='text-muted'>Action: " . htmlspecialchars($log['action_type']) . "</small>{$details}</td>";
            
            $odo = intval($log['odometer']) > 0 ? number_format($log['odometer']) : '-';
            $html .= "<td class='text-end text-nowrap'>{$odo}</td>";
            $html .= "<td class='text-end text-nowrap'>{$log['km_used']}</td>";
            
            $user = htmlspecialchars($log['created_name'] ?? 'System');
            $html .= "<td class='text-nowrap'><strong>{$user}</strong><br><small class='text-muted'><i class='ri-time-line me-1'></i>{$dateFormatted}</small></td>";
            
            $html .= "</tr>";
        }
    }
    
    echo $html;
    exit;
}
?>
