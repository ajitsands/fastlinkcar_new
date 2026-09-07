<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../envfiles');
$dotenv->load();

include_once __DIR__ . '/../../model/common/pdoCommonFunctions.php';
include_once __DIR__ . '/../../model/db_connection/pdo_db_connection.php';

$db = new CommonPDOModel();
$pdo = $db->varDBPDO;

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

if (!isset($input['action'])) {
    echo json_encode(['status' => 'error', 'message' => 'Action not provided']);
    exit;
}

$action = $input['action'];
$user_id = $_SESSION['user_ids'] ?? 1;
$company_id = $input['company_id'] ?? $_SESSION['company_id'] ?? 1;

try {
    if ($action === 'get_dropdowns') {
        // Fetch Vehicles
        $stmtV = $pdo->prepare("
            SELECT v.ids, v.vehicle_number, b.brand_name, m.modal_name as model_name 
            FROM tbl_vehicles v
            LEFT JOIN tbl_vehicle_brand b ON v.brand_id = b.ids
            LEFT JOIN tbl_vehicle_model m ON v.model_id = m.ids
            WHERE v.vehicle_status NOT IN ('Sold', 'Written Off')
        ");
        $stmtV->execute();
        $vehicles = $stmtV->fetchAll(PDO::FETCH_ASSOC);

        // Fetch Garages
        $stmtG = $pdo->prepare("SELECT ids, garage_name FROM tbl_garages WHERE status = 'Available'");
        $stmtG->execute();
        $garages = $stmtG->fetchAll(PDO::FETCH_ASSOC);

        // Fetch Services
        $stmtS = $pdo->prepare("SELECT ids, service_name, unit, charge_per_unit FROM tbl_garage_services WHERE status = 'Available'");
        $stmtS->execute();
        $services = $stmtS->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'data' => [
                'vehicles' => $vehicles,
                'garages' => $garages,
                'services' => $services
            ]
        ]);
    } 
    elseif ($action === 'get_vehicles_by_company') {
        $filterCompanyId = $input['company_id'] ?? null;
        if (!$filterCompanyId) {
            echo json_encode(['status' => 'error', 'message' => 'Company ID is required']);
            exit;
        }
        
        $stmtV = $pdo->prepare("
            SELECT v.ids, v.vehicle_number, b.brand_name, m.modal_name as model_name 
            FROM tbl_vehicles v
            LEFT JOIN tbl_vehicle_brand b ON v.brand_id = b.ids
            LEFT JOIN tbl_vehicle_model m ON v.model_id = m.ids
            WHERE v.vehicle_status NOT IN ('Sold', 'Written Off') AND v.company_id = ?
        ");
        $stmtV->execute([$filterCompanyId]);
        $vehicles = $stmtV->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'status' => 'success',
            'data' => ['vehicles' => $vehicles]
        ]);
    } 
    elseif ($action === 'save_request') {
        $request_id = $input['request_id'] ?? null;
        $vehicle_id = $input['vehicle_id'] ?? null;
        $garage_id = $input['garage_id'] ?? null;
        $services = $input['services'] ?? [];

        if (!$vehicle_id || !$garage_id || empty($services)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
            exit;
        }

        $pdo->beginTransaction();
        
        $request_no = '';

        if ($request_id) {
            // Check status (only allow update if Pending)
            $stmtC = $pdo->prepare("SELECT status, request_no FROM tbl_maintenance_requests WHERE ids = ? AND company_id = ?");
            $stmtC->execute([$request_id, $company_id]);
            $req = $stmtC->fetch(PDO::FETCH_ASSOC);
            if (!$req || $req['status'] !== 'Pending') {
                echo json_encode(['status' => 'error', 'message' => 'Only Pending requests can be edited.']);
                $pdo->rollBack();
                exit;
            }
            $request_no = $req['request_no'];

            // Update Master
            $stmt = $pdo->prepare("
                UPDATE tbl_maintenance_requests 
                SET vehicle_id = ?, garage_id = ?
                WHERE ids = ?
            ");
            $stmt->execute([$vehicle_id, $garage_id, $request_id]);
            
            // Delete old services
            $stmtDel = $pdo->prepare("DELETE FROM tbl_maintenance_request_services WHERE request_id = ?");
            $stmtDel->execute([$request_id]);
            
        } else {
            // Generate Request Number (e.g., COMP-MR-2026-0001)
            $year = date('Y');
            
            $stmtC = $pdo->prepare("SELECT company_code FROM tbl_company WHERE ids = ?");
            $stmtC->execute([$company_id]);
            $compRow = $stmtC->fetch(PDO::FETCH_ASSOC);
            $company_code = $compRow ? $compRow['company_code'] : 'COMP';
    
            // Extract the sequence number part from request_no to find max for this year
            $stmt = $pdo->prepare("
                SELECT MAX(CAST(SUBSTRING_INDEX(request_no, '-', -1) AS UNSIGNED)) as max_seq 
                FROM tbl_maintenance_requests 
                WHERE request_no LIKE ?
            ");
            $stmt->execute(["{$company_code}-MR-{$year}-%"]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $nextId = ($row['max_seq'] ? $row['max_seq'] : 0) + 1;
            
            $request_no = "{$company_code}-MR-{$year}-" . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    
            // Insert Master
            $stmt = $pdo->prepare("
                INSERT INTO tbl_maintenance_requests 
                (request_no, vehicle_id, garage_id, status, company_id, created_on, created_by) 
                VALUES (?, ?, ?, 'Pending', ?, NOW(), ?)
            ");
            $stmt->execute([$request_no, $vehicle_id, $garage_id, $company_id, $user_id]);
            $request_id = $pdo->lastInsertId();
        }

        // Insert Details
        $stmtS = $pdo->prepare("
            INSERT INTO tbl_maintenance_request_services 
            (request_id, service_id, qty, unit, remarks) 
            VALUES (?, ?, ?, ?, ?)
        ");
        foreach ($services as $srv) {
            $qty = $srv['qty'] ?? 1;
            $unit = $srv['unit'] ?? '';
            $stmtS->execute([$request_id, $srv['service_id'], $qty, $unit, $srv['remarks']]);
        }

        $pdo->commit();

        echo json_encode([
            'status' => 'success',
            'data' => ['request_id' => $request_id, 'request_no' => $request_no]
        ]);
    } 
    elseif ($action === 'get_requests') {
        $fromDate = $input['fromDate'] ?? '';
        $toDate = $input['toDate'] ?? '';
        $status = $input['status'] ?? 'All';
        $filterCompanyId = $input['company_id'] ?? 'All';

        $where = "WHERE 1=1";
        $params = [];

        // Security: Restrict to allowed companies
        $allowedCompanyIds = [];
        if (!empty($_SESSION['company_json'])) {
            $cData = json_decode($_SESSION['company_json'], true);
            if (is_array($cData)) {
                foreach ($cData as $c) {
                    $allowedCompanyIds[] = $c['ids'];
                }
            }
        }
        if (empty($allowedCompanyIds) && !empty($_SESSION['company_id'])) {
            $allowedCompanyIds[] = $_SESSION['company_id'];
        }

        if (!empty($allowedCompanyIds)) {
            $placeholders = implode(',', array_fill(0, count($allowedCompanyIds), '?'));
            $where .= " AND v.company_id IN ($placeholders)";
            $params = array_merge($params, $allowedCompanyIds);
        }

        // Apply chosen company filter
        if ($filterCompanyId !== 'All' && !empty($filterCompanyId)) {
            $where .= " AND v.company_id = ?";
            $params[] = $filterCompanyId;
        }

        if ($fromDate && $toDate) {
            $where .= " AND DATE(r.created_on) BETWEEN ? AND ?";
            $params[] = $fromDate;
            $params[] = $toDate;
        }

        if ($status !== 'All') {
            $where .= " AND r.status = ?";
            $params[] = $status;
        }

        $stmt = $pdo->prepare("
            SELECT r.ids, r.request_no, r.status, r.created_on, 
                   v.vehicle_number, v.chassis_number, v.is_outsourced, v.vehicle_status,
                   (SELECT odometer FROM tbl_vehicle_log_movement WHERE vehicle_ids = v.ids AND odometer IS NOT NULL AND odometer != '' ORDER BY log_datetime DESC, ids DESC LIMIT 1) as present_odometer,
                   b.brand_name, m.modal_name as model_name,
                   g.garage_name, g.contact_person, g.contact_number, g.email_id,
                   cmp.company_name as registration_company,
                   o.company_name as outsourcing_company_name
            FROM tbl_maintenance_requests r
            LEFT JOIN tbl_vehicles v ON r.vehicle_id = v.ids
            LEFT JOIN tbl_vehicle_brand b ON v.brand_id = b.ids
            LEFT JOIN tbl_vehicle_model m ON v.model_id = m.ids
            LEFT JOIN tbl_garages g ON r.garage_id = g.ids
            LEFT JOIN tbl_company cmp ON v.company_id = cmp.ids
            LEFT JOIN tbl_outsourcing_companies o ON v.outsourcing_company_id = o.ids
            $where
            ORDER BY r.ids DESC
        ");
        $stmt->execute($params);
        $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dateFormat = defined('SYS_DATE_FORMAT') ? SYS_DATE_FORMAT : 'Y-m-d';
        foreach ($requests as &$req) {
            if ($req['created_on']) {
                $req['created_on'] = date($dateFormat, strtotime($req['created_on']));
            }
        }

        echo json_encode(['status' => 'success', 'data' => $requests]);
    }
    elseif ($action === 'approve_request') {
        $request_id = $input['request_id'] ?? null;
        if (!$request_id) {
            echo json_encode(['status' => 'error', 'message' => 'Request ID required']);
            exit;
        }
        $stmt = $pdo->prepare("UPDATE tbl_maintenance_requests SET status = 'Approved' WHERE ids = ?");
        $stmt->execute([$request_id]);
        echo json_encode(['status' => 'success']);
    }
    elseif ($action === 'release_request') {
        $request_id = $input['request_id'] ?? null;
        $log_datetime = $input['log_datetime'] ?? null;
        $odometer = $input['odometer'] ?? null;

        if (!$request_id || !$log_datetime || $odometer === null) {
            echo json_encode(['status' => 'error', 'message' => 'Missing required fields for release.']);
            exit;
        }

        // Fetch request details
        $stmt = $pdo->prepare("SELECT vehicle_id, request_no, garage_id FROM tbl_maintenance_requests WHERE ids = ?");
        $stmt->execute([$request_id]);
        $req = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$req) {
            echo json_encode(['status' => 'error', 'message' => 'Request not found.']);
            exit;
        }

        $vehicle_id = $req['vehicle_id'];

        // Verify vehicle status is Parking or Available
        $stmtV = $pdo->prepare("SELECT vehicle_status, vehicle_number, company_id, outsourcing_company_id FROM tbl_vehicles WHERE ids = ?");
        $stmtV->execute([$vehicle_id]);
        $veh = $stmtV->fetch(PDO::FETCH_ASSOC);

        if (!$veh) {
            echo json_encode(['status' => 'error', 'message' => 'Vehicle not found.']);
            exit;
        }

        if ($veh['vehicle_status'] !== 'Parking' && $veh['vehicle_status'] !== 'Available') {
            echo json_encode(['status' => 'error', 'message' => 'The action cannot be performed from here, first return the vehicle and continue.']);
            exit;
        }

        $remarks = $input['remarks'] ?? '';
        $login_id = $_SESSION['login_id'] ?? null;
        $login_name = $_SESSION['login_name'] ?? null;
        
        try {
            $pdo->beginTransaction();

            // Insert into tbl_vehicle_log_movement
            $stmtLog = $pdo->prepare("
                INSERT INTO tbl_vehicle_log_movement 
                (vehicle_ids, vehicle_no, log_datetime, action_type, old_status, new_status, reference_type, reference_id, reference_no, garage_id, odometer, remarks, staff_id, created_by, created_name)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmtLog->execute([
                $vehicle_id,
                $veh['vehicle_number'],
                $log_datetime,
                'Maintenance Out',
                $veh['vehicle_status'],
                'Maintenance',
                'Maintenance Request',
                $request_id,
                $req['request_no'],
                $req['garage_id'],
                $odometer,
                $remarks,
                $login_id, // logged into staff_id
                $login_id, // created_by
                $login_name // created_name
            ]);

            // Update Vehicle
            $stmtUpdateV = $pdo->prepare("UPDATE tbl_vehicles SET vehicle_status = 'Maintenance' WHERE ids = ?");
            $stmtUpdateV->execute([$vehicle_id]);

            // Update Maintenance Request
            $stmtUpdateR = $pdo->prepare("UPDATE tbl_maintenance_requests SET status = 'In Progress' WHERE ids = ?");
            $stmtUpdateR->execute([$request_id]);

            $pdo->commit();
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Database error during release.', 'debug' => $e->getMessage()]);
        }
    }
    elseif ($action === 'receive_request') {
        $request_id = $input['request_id'] ?? null;
        $log_datetime = $input['log_datetime'] ?? null;
        $odometer = $input['odometer'] ?? null;
        $new_status = $input['new_status'] ?? 'Parking';
        $remarks = $input['remarks'] ?? '';

        if (!$request_id || !$log_datetime || $odometer === null) {
            echo json_encode(['status' => 'error', 'message' => 'Missing required fields for receive.']);
            exit;
        }

        if (!in_array($new_status, ['Parking', 'Available'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid status. Must be Parking or Available.']);
            exit;
        }

        // Fetch request details
        $stmt = $pdo->prepare("SELECT vehicle_id, request_no, garage_id, status FROM tbl_maintenance_requests WHERE ids = ?");
        $stmt->execute([$request_id]);
        $req = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$req) {
            echo json_encode(['status' => 'error', 'message' => 'Request not found.']);
            exit;
        }

        if ($req['status'] !== 'In Progress') {
            echo json_encode(['status' => 'error', 'message' => 'Only In Progress requests can be received.']);
            exit;
        }

        $vehicle_id = $req['vehicle_id'];

        // Verify vehicle is in Maintenance
        $stmtV = $pdo->prepare("SELECT vehicle_status, vehicle_number FROM tbl_vehicles WHERE ids = ?");
        $stmtV->execute([$vehicle_id]);
        $veh = $stmtV->fetch(PDO::FETCH_ASSOC);

        if (!$veh) {
            echo json_encode(['status' => 'error', 'message' => 'Vehicle not found.']);
            exit;
        }

        if ($veh['vehicle_status'] !== 'Maintenance') {
            echo json_encode(['status' => 'error', 'message' => 'Vehicle is not currently in Maintenance.']);
            exit;
        }

        $login_id = $_SESSION['login_id'] ?? null;
        $login_name = $_SESSION['login_name'] ?? null;

        try {
            $pdo->beginTransaction();

            // Insert into tbl_vehicle_log_movement
            $stmtLog = $pdo->prepare("
                INSERT INTO tbl_vehicle_log_movement 
                (vehicle_ids, vehicle_no, log_datetime, action_type, old_status, new_status, reference_type, reference_id, reference_no, garage_id, odometer, remarks, staff_id, created_by, created_name)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmtLog->execute([
                $vehicle_id,
                $veh['vehicle_number'],
                $log_datetime,
                'Maintenance In',
                $veh['vehicle_status'],
                $new_status,
                'Maintenance Request',
                $request_id,
                $req['request_no'],
                $req['garage_id'],
                $odometer,
                $remarks,
                $login_id,
                $login_id,
                $login_name
            ]);

            // Update Vehicle status
            $stmtUpdateV = $pdo->prepare("UPDATE tbl_vehicles SET vehicle_status = ? WHERE ids = ?");
            $stmtUpdateV->execute([$new_status, $vehicle_id]);

            // Update Maintenance Request to Completed
            $stmtUpdateR = $pdo->prepare("UPDATE tbl_maintenance_requests SET status = 'Completed' WHERE ids = ?");
            $stmtUpdateR->execute([$request_id]);

            $pdo->commit();
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Database error during receive.', 'debug' => $e->getMessage()]);
        }
    }
    elseif ($action === 'get_request_details') {
        $request_id = $input['request_id'] ?? null;
        if (!$request_id) {
            echo json_encode(['status' => 'error', 'message' => 'Request ID required']);
            exit;
        }

        // Security check: ensure this request belongs to an allowed company
        $allowedCompanyIds = [];
        if (!empty($_SESSION['company_json'])) {
            $cData = json_decode($_SESSION['company_json'], true);
            if (is_array($cData)) {
                foreach ($cData as $c) {
                    $allowedCompanyIds[] = $c['ids'];
                }
            }
        }
        
        $whereCompany = "1=1";
        if (!empty($allowedCompanyIds)) {
            $inList = implode(',', array_fill(0, count($allowedCompanyIds), '?'));
            $whereCompany = "r.company_id IN ($inList)";
        }

        $params = [$request_id];
        if (!empty($allowedCompanyIds)) {
            $params = array_merge($params, $allowedCompanyIds);
        }

        // Fetch Master
        $stmt = $pdo->prepare("SELECT r.* FROM tbl_maintenance_requests r WHERE r.ids = ? AND $whereCompany");
        $stmt->execute($params);
        $request = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$request) {
            echo json_encode(['status' => 'error', 'message' => 'Request not found or access denied.']);
            exit;
        }

        // Fetch Odometer Out from Movement Log
        $stmtLog = $pdo->prepare("SELECT odometer FROM tbl_vehicle_log_movement WHERE reference_id = ? AND action_type = 'Maintenance Out' ORDER BY ids DESC LIMIT 1");
        $stmtLog->execute([$request_id]);
        $logOut = $stmtLog->fetch(PDO::FETCH_ASSOC);
        $request['odometer_out'] = $logOut ? $logOut['odometer'] : null;

        // Fetch Services
        $stmtS = $pdo->prepare("
            SELECT s.*, gs.service_name, gs.charge_per_unit 
            FROM tbl_maintenance_request_services s
            LEFT JOIN tbl_garage_services gs ON s.service_id = gs.ids
            WHERE s.request_id = ?
        ");
        $stmtS->execute([$request_id]);
        $services = $stmtS->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'data' => [
                'request' => $request,
                'services' => $services
            ]
        ]);
    }
    elseif ($action === 'get_full_request_details') {
        $request_id = $input['request_id'] ?? null;
        if (!$request_id) {
            echo json_encode(['status' => 'error', 'message' => 'Request ID required']);
            exit;
        }

        // Fetch Master Request with joined details
        $stmt = $pdo->prepare("
            SELECT r.*, 
                   v.vehicle_number, v.vehicle_status, 
                   b.brand_name, m.modal_name as model_name,
                   g.garage_name, g.contact_person
            FROM tbl_maintenance_requests r
            LEFT JOIN tbl_vehicles v ON r.vehicle_id = v.ids
            LEFT JOIN tbl_vehicle_brand b ON v.brand_id = b.ids
            LEFT JOIN tbl_vehicle_model m ON v.model_id = m.ids
            LEFT JOIN tbl_garages g ON r.garage_id = g.ids
            WHERE r.ids = ?
        ");
        $stmt->execute([$request_id]);
        $request = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$request) {
            echo json_encode(['status' => 'error', 'message' => 'Request not found.']);
            exit;
        }

        // Fetch Movement Logs (Out and In)
        $stmtLogOut = $pdo->prepare("SELECT log_datetime, odometer, created_name FROM tbl_vehicle_log_movement WHERE reference_id = ? AND action_type = 'Maintenance Out' ORDER BY ids DESC LIMIT 1");
        $stmtLogOut->execute([$request_id]);
        $logOut = $stmtLogOut->fetch(PDO::FETCH_ASSOC);

        $stmtLogIn = $pdo->prepare("SELECT log_datetime, odometer, created_name FROM tbl_vehicle_log_movement WHERE reference_id = ? AND action_type = 'Maintenance In' ORDER BY ids DESC LIMIT 1");
        $stmtLogIn->execute([$request_id]);
        $logIn = $stmtLogIn->fetch(PDO::FETCH_ASSOC);

        // Fetch Services
        $stmtS = $pdo->prepare("
            SELECT s.*, gs.service_name, gs.charge_per_unit
            FROM tbl_maintenance_request_services s
            LEFT JOIN tbl_garage_services gs ON s.service_id = gs.ids
            WHERE s.request_id = ?
        ");
        $stmtS->execute([$request_id]);
        $services = $stmtS->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'success',
            'data' => [
                'request' => $request,
                'log_out' => $logOut,
                'log_in' => $logIn,
                'services' => $services
            ]
        ]);
    }
    elseif ($action === 'save_request_costs') {
        $request_id = $input['request_id'] ?? null;
        $additional_charges = floatval($input['additional_charges'] ?? 0);
        $additional_charges_remarks = $input['additional_charges_remarks'] ?? null;
        $services = $input['services'] ?? [];

        if (!$request_id) {
            echo json_encode(['status' => 'error', 'message' => 'Request ID required']);
            exit;
        }

        try {
            $pdo->beginTransaction();

            $total_services_cost = 0;

            // Update or Insert individual service costs
            $stmtUpdateS = $pdo->prepare("UPDATE tbl_maintenance_request_services SET qty = ?, unit = ?, remarks = ?, cost = ? WHERE ids = ? AND request_id = ?");
            $stmtInsertS = $pdo->prepare("INSERT INTO tbl_maintenance_request_services (request_id, service_id, qty, unit, remarks, cost) VALUES (?, ?, ?, ?, ?, ?)");
            foreach ($services as $srv) {
                $cost = floatval($srv['cost'] ?? 0);
                $qty = floatval($srv['qty'] ?? 1);
                $unit = $srv['unit'] ?? '';
                $remarks = $srv['remarks'] ?? '';
                
                $total_services_cost += $cost;
                
                if (!empty($srv['ids'])) {
                    // Update existing
                    $stmtUpdateS->execute([$qty, $unit, $remarks, $cost, $srv['ids'], $request_id]);
                } else {
                    // Insert new
                    if (!empty($srv['service_id'])) {
                        $stmtInsertS->execute([$request_id, $srv['service_id'], $qty, $unit, $remarks, $cost]);
                    }
                }
            }

            $total_cost = $total_services_cost + $additional_charges;

            // Update master request total cost and additional charges
            $stmtUpdateR = $pdo->prepare("UPDATE tbl_maintenance_requests SET additional_charges = ?, additional_charges_remarks = ?, total_cost = ? WHERE ids = ?");
            $stmtUpdateR->execute([$additional_charges, $additional_charges_remarks, $total_cost, $request_id]);

            $pdo->commit();
            echo json_encode(['status' => 'success', 'data' => ['total_cost' => $total_cost]]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Database error while saving costs.', 'debug' => $e->getMessage()]);
        }
    }
    elseif ($action === 'get_vehicle_details') {
        $vehicle_id = $input['vehicle_id'] ?? null;
        if (!$vehicle_id) {
            echo json_encode(['status' => 'error', 'message' => 'Vehicle ID required']);
            exit;
        }

        $stmt = $pdo->prepare("
            SELECT v.ids, v.vehicle_number, v.chassis_number, v.vehicle_status, v.vehicle_status_notes,
                   v.is_outsourced, o.company_name as outsourcing_company_name,
                   cmp.company_name as reg_company_name,
                   b.brand_name, m.modal_name as model_name, c.category_name,
                   v.next_insurance_date, v.next_passing_date
            FROM tbl_vehicles v
            LEFT JOIN tbl_vehicle_brand b ON v.brand_id = b.ids
            LEFT JOIN tbl_vehicle_model m ON v.model_id = m.ids
            LEFT JOIN tbl_vehicle_category c ON v.category_id = c.ids
            LEFT JOIN tbl_outsourcing_companies o ON v.outsourcing_company_id = o.ids
            LEFT JOIN tbl_company cmp ON v.company_id = cmp.ids
            WHERE v.ids = ?
        ");
        $stmt->execute([$vehicle_id]);
        $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$vehicle) {
            echo json_encode(['status' => 'error', 'message' => 'Vehicle not found']);
            exit;
        }

        $assignment = null;
        if ($vehicle['vehicle_status'] === 'Rentout') {
            // Fetch from Rentout Contracts directly
            $rSql = "SELECT ids, agreement_no as contract_ref, customer_code, customer_name, service_end_date_time as expected_return FROM tbl_vehicle_rentout_contracts WHERE vehicle_id = ? AND agreement_status = 'Rentout' ORDER BY ids DESC LIMIT 1";
            $rStmt = $pdo->prepare($rSql);
            $rStmt->execute([$vehicle_id]);
            $r = $rStmt->fetch(PDO::FETCH_ASSOC);
            
            if ($r) {
                $assignment = [
                    'customer_name' => $r['customer_name'],
                    'contract_ref' => $r['contract_ref'],
                    'expected_return' => $r['expected_return'],
                    'customer_mobile' => ''
                ];
                
                // Fetch contact
                $cSql = "SELECT customer_mobile FROM customer_details WHERE customer_id = ?";
                $cStmt = $pdo->prepare($cSql);
                $cStmt->execute([$r['customer_code']]);
                $c = $cStmt->fetch(PDO::FETCH_ASSOC);
                if ($c) {
                    $assignment['customer_mobile'] = $c['customer_mobile'];
                }
                
                // Check for extensions
                $extSql = "SELECT extend_end_date FROM tbl_vehicle_contract_extensions WHERE agreement_ids = ? ORDER BY ids DESC LIMIT 1";
                $extStmt = $pdo->prepare($extSql);
                $extStmt->execute([$r['ids']]);
                $ext = $extStmt->fetch(PDO::FETCH_ASSOC);
                if ($ext && !empty($ext['extend_end_date'])) {
                    $assignment['expected_return'] = $ext['extend_end_date'];
                }
            }
        } elseif ($vehicle['vehicle_status'] === 'Staff Use') {
            $nrSql = "SELECT booking_no as contract_ref, staff_name as customer_name, book_to_date as expected_return FROM tbl_vehicle_non_revenue_ticket WHERE vehicle_id = ? AND book_status != 'Closed' ORDER BY ids DESC LIMIT 1";
            $nrStmt = $pdo->prepare($nrSql);
            $nrStmt->execute([$vehicle_id]);
            $nr = $nrStmt->fetch(PDO::FETCH_ASSOC);
            
            if ($nr) {
                $assignment = [
                    'customer_name' => $nr['customer_name'],
                    'contract_ref' => $nr['contract_ref'],
                    'expected_return' => $nr['expected_return'],
                    'customer_mobile' => ''
                ];
            }
        }

        echo json_encode(['status' => 'success', 'data' => ['vehicle' => $vehicle, 'assignment' => $assignment]]);
    }
    else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
