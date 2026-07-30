<?php
// controller/reports/VehicleInsightController.php

require_once ROOT_PATH . '/__db.php';
$pdo = getPDO();

try {
    // 1. Fetch all vehicles
    $stmt = $pdo->prepare("SELECT ids, vehicle_number, model_names, vehicle_color, vehicle_year, image_json, vehicle_status, vehicle_purchase_date FROM tbl_vehicles ORDER BY ids DESC");
    $stmt->execute();
    $vehicles = $stmt->fetchAll();

    // 2. Fetch the latest active rental contracts for vehicles currently on rent
    $stmt = $pdo->prepare("
        SELECT vehicle_id, MAX(ids) as latest_contract_id 
        FROM tbl_vehicle_rentout_contracts 
        GROUP BY vehicle_id
    ");
    $stmt->execute();
    $latest_contracts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $contract_details = [];
    if (!empty($latest_contracts)) {
        $ids_placeholder = implode(',', array_fill(0, count($latest_contracts), '?'));
        $stmt = $pdo->prepare("SELECT vehicle_id, agreement_no, contract_details_json, customer_name FROM tbl_vehicle_rentout_contracts WHERE ids IN ($ids_placeholder)");
        $stmt->execute(array_values($latest_contracts));
        while ($row = $stmt->fetch()) {
            $details = json_decode($row['contract_details_json'], true);
            $row['expected_return_date'] = $details['period_to'] ?? null;
            $contract_details[$row['vehicle_id']] = $row;
        }
    }

    // 3. Fetch future reservations/bookings from tbl_vehicle_bookings
    $stmt = $pdo->prepare("SELECT booking_no, customer_name, vehicle_id, book_from_date as service_start_date_time, book_to_date as service_end_date_time FROM tbl_vehicle_bookings WHERE book_status IN ('Booked', 'Confirmed') ORDER BY ids DESC");
    $stmt->execute();
    $bookings = $stmt->fetchAll();
    
    $reserved_vehicles = [];
    foreach ($bookings as $b) {
        $vid = $b['vehicle_id'];
        if ($vid) {
            if (!isset($reserved_vehicles[$vid])) {
                $reserved_vehicles[$vid] = [];
            }
            $reserved_vehicles[$vid][] = [
                'booking_no' => $b['booking_no'],
                'customer_name' => $b['customer_name'],
                'start_date' => $b['service_start_date_time'],
                'end_date' => $b['service_end_date_time']
            ];
        }
    }

    // 4. Process and categorize data
    $summary = [
        'total' => 0,
        'available' => 0,
        'rented' => 0,
        'reserved' => 0,
        'maintenance' => 0
    ];

    $all_vehicles_data = [];

    foreach ($vehicles as $v) {
        $vid = $v['ids'];
        $status = $v['vehicle_status']; // Available, Rented, Maintenance, etc.
        
        $img_url = 'assets/img/illustrations/misc-bg-light.png'; // Default
        $images = json_decode($v['image_json'], true);
        if (!empty($images) && is_array($images) && isset($images[0])) {
            $img_url = 'uploads/vehicleImages/' . $images[0];
        }

        $v_data = [
            'id' => $vid,
            'number' => $v['vehicle_number'],
            'model' => $v['model_names'],
            'color' => $v['vehicle_color'],
            'year' => $v['vehicle_year'],
            'image' => $img_url,
            'status' => $status,
            'contract' => null,
            'reservations' => $reserved_vehicles[$vid] ?? []
        ];

        $summary['total']++;

        $status_normalized = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $status));

        if ($status_normalized === 'rented' || $status_normalized === 'rentout' || $status_normalized === 'onrent') {
            $summary['rented']++;
            $v_data['contract'] = $contract_details[$vid] ?? null;
            // Force status to explicitly show as 'RentOut'
            $v_data['status'] = 'RentOut';
        } elseif ($status_normalized === 'available' || $status_normalized === 'avail') {
            if (!empty($v_data['reservations'])) {
                // If it's available but has future reservations, we can consider it Reserved
                $v_data['status'] = 'Reserved'; // Override for UI categorization
                $summary['reserved']++;
            } else {
                $summary['available']++;
            }
        } else {
            $summary['maintenance']++;
        }

        $all_vehicles_data[] = $v_data;
    }

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

include 'view/vehicle_insight_report.php';
?>
