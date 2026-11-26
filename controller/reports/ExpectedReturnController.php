<?php
// controller/reports/ExpectedReturnController.php

require_once ROOT_PATH . '/__db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'search') {
    $pdo = getPDO();
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';

    // Convert dates to proper timestamps for comparison
    $start_ts = strtotime($start_date);
    // End date is inclusive, so we add 23:59:59
    $end_ts = strtotime($end_date . ' 23:59:59');

    try {
        // Fetch vehicles currently marked as Rented or RentOut
        $stmt = $pdo->prepare("SELECT ids, vehicle_number, model_names, vehicle_color, vehicle_year, image_json, vehicle_status FROM tbl_vehicles WHERE vehicle_status IN ('Rented', 'RentOut', 'rentout') ORDER BY ids DESC");
        $stmt->execute();
        $vehicles = $stmt->fetchAll();

        // Get latest contracts
        $stmt = $pdo->prepare("
            SELECT vehicle_id, MAX(ids) as latest_contract_id 
            FROM tbl_vehicle_rentout_contracts 
            GROUP BY vehicle_id
        ");
        $stmt->execute();
        $latest_contracts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $results = [];

        if (!empty($latest_contracts)) {
            $ids_placeholder = implode(',', array_fill(0, count($latest_contracts), '?'));
            $stmt = $pdo->prepare("SELECT vehicle_id, agreement_no, contract_details_json, customer_name FROM tbl_vehicle_rentout_contracts WHERE ids IN ($ids_placeholder)");
            $stmt->execute(array_values($latest_contracts));
            
            while ($row = $stmt->fetch()) {
                $details = json_decode($row['contract_details_json'], true);
                $expected_return_date_str = $details['period_to'] ?? '';
                
                if ($expected_return_date_str) {
                    $return_ts = strtotime($expected_return_date_str);
                    
                    if ($return_ts >= $start_ts && $return_ts <= $end_ts) {
                        // Find the vehicle info
                        $vinfo = null;
                        foreach ($vehicles as $v) {
                            if ($v['ids'] == $row['vehicle_id']) {
                                $vinfo = $v;
                                break;
                            }
                        }
                        
                        if ($vinfo) {
                            $img_url = 'assets/img/illustrations/misc-bg-light.png';
                            $images = json_decode($vinfo['image_json'], true);
                            if (!empty($images) && is_array($images) && isset($images[0])) {
                                $img_url = 'uploads/vehicleImages/' . $images[0];
                            }
                            
                            $results[] = [
                                'id' => $vinfo['ids'],
                                'number' => $vinfo['vehicle_number'],
                                'model' => $vinfo['model_names'],
                                'color' => $vinfo['vehicle_color'],
                                'year' => $vinfo['vehicle_year'],
                                'image' => $img_url,
                                'status' => (strtolower($vinfo['vehicle_status']) === 'rented' || strtolower($vinfo['vehicle_status']) === 'rentout') ? 'RentOut' : $vinfo['vehicle_status'],
                                'customer_name' => $row['customer_name'],
                                'expected_return' => date('d M Y, H:i', $return_ts),
                                'expected_return_ts' => $return_ts
                            ];
                        }
                    }
                }
            }
        }
        
        // Sort results by expected return date ascending
        usort($results, function($a, $b) {
            return $a['expected_return_ts'] - $b['expected_return_ts'];
        });

        echo json_encode(['status' => 'success', 'data' => $results]);
        exit;

    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => "Database Error: " . $e->getMessage()]);
        exit;
    }
}

// Initial page load
include 'view/expected_return_report.php';
?>
