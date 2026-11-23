<?PHP 
header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class VehiclesController
{
	  var $varPDOModelObj;
     public $actionevents,$json;
      public $booking, $payments, $drivers, $vehicles, $clients, $params =  array();
      public $vehicleName, $vehicleRegNumber, $vehicleModal, $vehiclePurchaseDate, $vehiclePassingDate, $vehicleInsuranceExpDate, $vehicleStatus, $category, $vehicleDetails, $modelName;
	  public $belongsToCompanyID,$belongsToCompanyName,$category_id,$brand_id,$vehiclesDocObj,$vehicleimages,$vehicle_ids,$filter_date,$vehicle_model,$vehicleYear,$vehicleColor,$user_id,$company_id;
	  public $page, $limit, $offset, $status,$filter_start_date,$filter_end_date,$filter_start_date_time,$filter_end_date_time,$contract_status;
	  public $is_active, $daily_rent, $weekly_rent, $monthly_rent, $mileage_km, $body_type, $engine_type, $capacity_cc, $transmission;
	function __construct()
	{
	    $this->varPDOModelObj = new CommonPDOModel();
	    
	
        $this->json = file_get_contents("php://input");
        
        
        if (!$this->json) {
            echo json_encode([
                "status" => "error",
                "message" => "No input data received"
            ]);
            exit;
        }
        
        $data = json_decode($this->json, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid JSON"
            ]);
            exit;
        }
          $this->actionevents = $data['action'] ?? null;
          $this->filter_start_date = $data['filter_start_date'] ?? null;
        $this->filter_start_date_time = !empty($this->filter_start_date)
        ? date('Y-m-d 00:00:00', strtotime($this->filter_start_date))
        : null;
        
      $this->filter_end_date = $data['filter_end_date'] ?? null;

    $this->filter_end_date_time = !empty($this->filter_end_date)
    ? date('Y-m-d 23:59:59', strtotime($this->filter_end_date))
    : null;
      $this->contract_status = $data['contract_status'] ?? 'All';
        $this->filter_date = $data['filter_date'] ?? null;
        $this->vehicle_model  = $data['vehicle_model'] ?? null;
        // Access values
        $this->vehicleYear = $data['vehicleYear'] ?? null;
        $this->vehicleColor = $data['vehicleColor'] ?? null;
        $this->vehicleRegNumber = $data['vehicleNumber'] ?? null;
        $this->chassisNumber = $data['chassisNumber'] ?? null;
        $this->vehicleModal = $data['vehicleModel'] ?? null;
        $this->vehiclePurchaseDate = $data['vehiclePurchaseDate'] ?? null;
        $this->brand_id = $data['brand_id'] ?? null;
        $this->category_id = $data['category_id'] ?? null;
        $this->modelName = $data['modelName'] ?? null;
        
        $this->vehicle_ids = $data['ids'] ?? null;
        
        $this->vehiclePassingDate = !empty($data['vehiclePassingDate']) ? $data['vehiclePassingDate'] : null;
        $this->vehicleInsuranceExpDate = !empty($data['vehicleInsuranceExpDate']) ? $data['vehicleInsuranceExpDate'] : null;
        $this->vehicleStatus = !empty($data['vehicleStatus']) ? $data['vehicleStatus'] : 'Available';
        $this->is_active = isset($data['is_active']) ? (!empty($data['is_active']) ? 1 : 0) : 1;
        $this->daily_rent = isset($data['daily_rent']) && $data['daily_rent'] !== '' ? floatval($data['daily_rent']) : 0.000;
        $this->weekly_rent = isset($data['weekly_rent']) && $data['weekly_rent'] !== '' ? floatval($data['weekly_rent']) : 0.000;
        $this->monthly_rent = isset($data['monthly_rent']) && $data['monthly_rent'] !== '' ? floatval($data['monthly_rent']) : 0.000;
        $this->mileage_km = isset($data['mileage_km']) && $data['mileage_km'] !== '' ? intval($data['mileage_km']) : null;
        $this->body_type = $data['body_type'] ?? null;
        $this->engine_type = $data['engine_type'] ?? null;
        $this->capacity_cc = $data['capacity_cc'] ?? null;
        $this->transmission = $data['transmission'] ?? null;
        $this->category = $data['category'] ?? null;
        $this->belongsToCompanyID = !empty($data['belongsToCompanyID']) ? intval($data['belongsToCompanyID']) : ($_SESSION['company_id'] ?? 1);
        $this->belongsToCompanyName = $data['belongsToCompanyName'] ?? null;
        $this->isOutsourced = !empty($data['is_outsourced']) ? $data['is_outsourced'] : 'No';
        $this->outsourcingCompanyId = ($this->isOutsourced === 'Yes' && !empty($data['outsourcing_company_id'])) ? intval($data['outsourcing_company_id']) : 0;
        
        $this->status = $data['status'] ?? 'Available';
        
        date_default_timezone_set('Asia/Bahrain');
        
        
       
        // Convert vehicleDetails to JSON string for DB
       $this->vehicleDetails = json_encode(
    is_array($data['vehicleDetails'] ?? null)
        ? $data['vehicleDetails']
                : (json_decode($data['vehicleDetails'] ?? '[]', true) ?? [])
        );
        
        $this->vehiclesDocObj = json_encode(
            is_array($data['vehiclesDocObj'] ?? null)
                ? $data['vehiclesDocObj']
                : (json_decode($data['vehiclesDocObj'] ?? '[]', true) ?? [])
        );
        
        $this->vehicleimages = json_encode(
            is_array($data['vehicleimages'] ?? null)
                ? $data['vehicleimages']
                : (json_decode($data['vehicleimages'] ?? '[]', true) ?? [])
        );
       
        
        $this->company_id = $this->belongsToCompanyID;
        $this->user_id = $_SESSION['user_id'] ?? 1;
        $this->insertedDate = date('Y-m-d');
        $this->page = isset($data['page']) ? (int)$data['page'] : 1;
        $this->limit = 8;
        $this->offset = ($this->page - 1) * $this->limit;
        
        

	}
	function onOff($val) {
        return ($val === 'on') ? 1 : 0;
    }

	function SQLArray()
    {
		$array =  array();
        
        $array[0] = "INSERT INTO tbl_vehicles
                        (category_id,model_id,model_names,brand_id,company_id,vehicle_number,chassis_number,vehicle_year,vehicle_color,daily_rent,weekly_rent,monthly_rent,mileage_km,body_type,engine_type,capacity_cc,transmission,next_passing_date,next_insurance_date,image_json,other_details_json,vehicle_attachments,vehicle_status,is_active,created_on,created_by,vehicle_purchase_date,is_outsourced,outsourcing_company_id) VALUES
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->params[0] = [
                $this->category_id,
                $this->vehicleModal,
                $this->modelName,
                $this->brand_id,
                $this->belongsToCompanyID,
                $this->vehicleRegNumber,
                $this->chassisNumber,
                $this->vehicleYear,
                $this->vehicleColor,
                $this->daily_rent,
                $this->weekly_rent,
                $this->monthly_rent,
                $this->mileage_km,
                $this->body_type,
                $this->engine_type,
                $this->capacity_cc,
                $this->transmission,
                $this->vehiclePassingDate,
                $this->vehicleInsuranceExpDate,
                $this->vehicleimages,
                $this->vehicleDetails,
                $this->vehiclesDocObj,
                $this->vehicleStatus,
                $this->is_active,
                $this->insertedDate,
                $this->user_id,
                $this->vehiclePurchaseDate,
                $this->isOutsourced,
                $this->outsourcingCompanyId
        ];
        
        $array[4] = "SELECT v.*, o.company_name AS outsourcing_company_name, c.company_name AS reg_company_name, cat.category_name, b.brand_name, m.price_json AS model_price_json FROM tbl_vehicles v LEFT JOIN tbl_outsourcing_companies o ON o.ids = v.outsourcing_company_id LEFT JOIN tbl_company c ON c.ids = v.company_id LEFT JOIN tbl_vehicle_category cat ON cat.ids = v.category_id LEFT JOIN tbl_vehicle_brand b ON b.ids = v.brand_id LEFT JOIN tbl_vehicle_model m ON m.ids = v.model_id ORDER BY v.ids DESC";
        $array[5] = "UPDATE tbl_vehicles SET
                        category_id = ?,
                        model_id = ?,
                        model_names = ?,
                        brand_id = ?,
                        company_id = ?,
                        vehicle_number = ?,
                        chassis_number = ?,
                        vehicle_year = ?,
                        vehicle_color = ?,
                        daily_rent = ?,
                        weekly_rent = ?,
                        monthly_rent = ?,
                        mileage_km = ?,
                        body_type = ?,
                        engine_type = ?,
                        capacity_cc = ?,
                        transmission = ?,
                        next_passing_date = ?,
                        next_insurance_date = ?,
                        vehicle_status = ?,
                        is_active = ?,
                        image_json = ?,
                        other_details_json = ?,
                        vehicle_attachments = ?,
                        vehicle_purchase_date = ?,
                        is_outsourced = ?,
                        outsourcing_company_id = ?
                    WHERE ids = ?";
        $this->params[5] = [
            $this->category_id,
            $this->vehicleModal,
            $this->modelName,
            $this->brand_id,
            $this->belongsToCompanyID,
            $this->vehicleRegNumber,
            $this->chassisNumber,
            $this->vehicleYear,
            $this->vehicleColor,
            $this->daily_rent,
            $this->weekly_rent,
            $this->monthly_rent,
            $this->mileage_km,
            $this->body_type,
            $this->engine_type,
            $this->capacity_cc,
            $this->transmission,
            $this->vehiclePassingDate,
            $this->vehicleInsuranceExpDate,
            $this->vehicleStatus,
            $this->is_active,
            $this->vehicleimages,
            $this->vehicleDetails,
            $this->vehiclesDocObj,
            $this->vehiclePurchaseDate,
            $this->isOutsourced,
            $this->outsourcingCompanyId,
            $this->vehicle_ids
        ];           
                    
                    
       

		return $array;
	}

	function DataRequest($action)
	{
	 	$var =  $this->SQLArray();
		switch($action)
		{
			
case 'AddVehicleInformationnew':

    if (!empty($this->chassisNumber)) {
        $checkSql = "SELECT ids FROM tbl_vehicles WHERE chassis_number = ?";
        $checkStmt = $this->varPDOModelObj->varDBPDO->prepare($checkSql);
        $checkStmt->execute([$this->chassisNumber]);
        if ($checkStmt->rowCount() > 0) {
            echo json_encode(['status' => false, 'message' => 'Chassis Number already exists.']);
            break;
        }
    }

    $this->ReturnData = $this->varPDOModelObj
        ->AddToTableAndReturnSpecifiedColumn(
            $var[0],
            'ids',
            'tbl_vehicles',
            $this->params[0]
        );

    $response = json_decode($this->ReturnData, true);

    $Vehicle_id = null;

    if (
        isset($response['data']['return_ids_value'])
    ) {
        $returnIds = json_decode(
            $response['data']['return_ids_value'],
            true
        );

        $Vehicle_id = $returnIds['data'][0]['ids'] ?? null;
    }
    
 // Vehicle Movement Log
    if ($Vehicle_id) {

        $this->varPDOModelObj->logVehicleMovement([

            'vehicle_id' => $Vehicle_id,

            'action_type' => 'Vehicle Added',

            'old_status' => null,

            'new_status' => 'Available',

            'reference_type' => 'Vehicle',

            'reference_id' => $Vehicle_id,

            'reference_no' => $this->vehicleRegNumber,

            'location_from' => null,

            'location_to' => 'Main Parking',

            'staff_id' => null,

            'customer_id' => null,

            'garage_id' => null,

            'odometer' => null,

            'fuel_level' => null,

            'remarks' => 'New vehicle registered into the system.'

        ]);
    }
    echo json_encode([
        'status'     => $Vehicle_id ? true : false,
        'message'    => $Vehicle_id
            ? 'Successfully Added!'
            : 'Failed to retrieve vehicle ID',
        'vehicle_id' => $Vehicle_id
    ]);

break;
			case 'AddVehicleInformationnewold':
			 $this->ReturnData = $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn($var[0],'ids',' tbl_vehicles', $this->params[0]);
		//	 Logger::ActivityLog('AddVehicleInformation',"Send to Client - 103 ",[$this->ReturnData]);
			    $Vehicle_id = json_decode(
                    json_decode($this->ReturnData, true)['data']['return_ids_value'],
                    true
                )['data'][0]['ids'] ?? null;
                $outSend = json_encode([
                    'status'  => true,
                    'message' => "Successfully Added..!",
                    'vehicle_id' => $Vehicle_id
                ]);
               // Logger::ActivityLog('AddVehicleInformation',"Send to Client - 103 ",[json_decode($outSend)]);
			    echo $outSend;
			break;
			case 'UpdateVehicleInformation':
			    
			    if (!empty($this->chassisNumber)) {
                    $checkSql = "SELECT ids FROM tbl_vehicles WHERE chassis_number = ? AND ids != ?";
                    $checkStmt = $this->varPDOModelObj->varDBPDO->prepare($checkSql);
                    $checkStmt->execute([$this->chassisNumber, $this->vehicle_ids]);
                    if ($checkStmt->rowCount() > 0) {
                        echo json_encode(['status' => false, 'message' => 'Chassis Number already exists.']);
                        break;
                    }
                }
			    
			     $result = $this->varPDOModelObj->UpdateTable($var[5], $this->params[5]);
			     // Logger::ActivityLog('UpdateVehicleInformation',"Send to Client - 103 ",[$var[5],$this->params[5],$result]);
			    
                echo $result;
			break;
			case 'update_status':
			    if (empty($this->vehicle_ids) || empty($this->status)) {
                    echo json_encode(['status' => false, 'message' => 'Missing vehicle ID or status.']);
                    break;
                }
                
                $sql = "UPDATE tbl_vehicles SET vehicle_status = :status WHERE ids = :id";
                $stmt = $this->varPDOModelObj->varDBPDO->prepare($sql);
                $result = $stmt->execute([
                    ':status' => $this->status,
                    ':id' => $this->vehicle_ids
                ]);
                
                echo json_encode([
                    'status' => $result,
                    'message' => $result ? 'Status updated successfully' : 'Failed to update status'
                ]);
			break;
			
		
            case 'ListVehicleMaster':
                $allowedCompanies = [];
                if (!empty($_SESSION['company_json'])) {
                    $companyData = json_decode($_SESSION['company_json'], true);
                    if (is_array($companyData)) {
                        $allowedCompanies = array_column($companyData, 'ids');
                    }
                }
                if (empty($allowedCompanies)) {
                    $allowedCompanies = [$_SESSION['company_id'] ?? 1];
                }

                $inputData = json_decode($this->json, true);
                $selectedCompanyId = $inputData['company_id'] ?? '';
                $filterCompanyId = '';
                if ($selectedCompanyId !== '' && in_array($selectedCompanyId, $allowedCompanies)) {
                    $filterCompanyId = $selectedCompanyId;
                }

                $sql = "SELECT v.*, 
                               c.company_name as ownership_company,
                               o.company_name AS outsourcing_company_name 
                        FROM tbl_vehicles v 
                        LEFT JOIN tbl_company c ON v.company_id = c.ids
                        LEFT JOIN tbl_outsourcing_companies o ON o.ids = v.outsourcing_company_id 
                        WHERE 1=1 ";
                
                $params = [];
                if ($filterCompanyId !== '') {
                    $sql .= " AND v.company_id = ? ";
                    $params[] = $filterCompanyId;
                } else {
                    $inQuery = implode(',', array_fill(0, count($allowedCompanies), '?'));
                    $sql .= " AND v.company_id IN ($inQuery) ";
                    $params = array_merge($params, $allowedCompanies);
                }
                $sql .= " ORDER BY v.ids DESC";

                // Use PDO prepare/execute to safely bind parameters
                $stmt = $this->varPDOModelObj->varDBPDO->prepare($sql);
                $stmt->execute($params);
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $vehIds = array_values(array_filter(array_map('intval', array_column($results, 'ids'))));
                $txMap = [];
                if (!empty($vehIds)) {
                    $inVeh = implode(',', $vehIds);
                    $txQueries = [
                        'Contracts'             => "SELECT vehicle_id AS vid, COUNT(*) AS cnt FROM tbl_vehicle_rentout_contracts WHERE vehicle_id IN ({$inVeh}) GROUP BY vehicle_id",
                        'Bookings'              => "SELECT vehicle_id AS vid, COUNT(*) AS cnt FROM tbl_vehicle_bookings WHERE vehicle_id IN ({$inVeh}) GROUP BY vehicle_id",
                        'Maintenance Requests'  => "SELECT vehicle_id AS vid, COUNT(*) AS cnt FROM tbl_maintenance_requests WHERE vehicle_id IN ({$inVeh}) GROUP BY vehicle_id",
                        'Staff Use'             => "SELECT vehicle_id AS vid, COUNT(*) AS cnt FROM tbl_vehicle_non_revenue_ticket WHERE vehicle_id IN ({$inVeh}) GROUP BY vehicle_id",
                        'Movement Logs'         => "SELECT vehicle_ids AS vid, COUNT(*) AS cnt FROM tbl_vehicle_log_movement WHERE vehicle_ids IN ({$inVeh}) GROUP BY vehicle_ids",
                    ];
                    foreach ($txQueries as $label => $qSql) {
                        try {
                            $qStmt = $this->varPDOModelObj->varDBPDO->query($qSql);
                            if ($qStmt) {
                                while ($qRow = $qStmt->fetch(PDO::FETCH_ASSOC)) {
                                    $vid = (int)$qRow['vid'];
                                    $cnt = (int)$qRow['cnt'];
                                    if ($vid > 0 && $cnt > 0) {
                                        $txMap[$vid][] = "{$label} ({$cnt})";
                                    }
                                }
                            }
                        } catch (Exception $eTx) {}
                    }
                }

                foreach ($results as &$r) {
                    $vid = (int)($r['ids'] ?? 0);
                    $sources = $txMap[$vid] ?? [];
                    $r['has_transactions'] = !empty($sources) ? 1 : 0;
                    $r['transaction_sources'] = implode(', ', $sources);
                }
                unset($r);

                echo json_encode([
                    "status" => "success",
                    "data" => $results
                ]);
            break;

            case 'delete_vehicle':
                $inputData = json_decode($this->json, true);
                $vehicleId = (int)($inputData['vehicle_id'] ?? 0);
                if ($vehicleId <= 0) {
                    echo json_encode(['status' => false, 'message' => 'Invalid vehicle ID.']);
                    break;
                }

                $txChecks = [
                    'Contracts'            => "SELECT COUNT(*) FROM tbl_vehicle_rentout_contracts WHERE vehicle_id = ?",
                    'Bookings'             => "SELECT COUNT(*) FROM tbl_vehicle_bookings WHERE vehicle_id = ?",
                    'Maintenance Requests' => "SELECT COUNT(*) FROM tbl_maintenance_requests WHERE vehicle_id = ?",
                    'Staff Use'            => "SELECT COUNT(*) FROM tbl_vehicle_non_revenue_ticket WHERE vehicle_id = ?",
                    'Movement Logs'        => "SELECT COUNT(*) FROM tbl_vehicle_log_movement WHERE vehicle_ids = ?",
                ];
                $foundSources = [];
                foreach ($txChecks as $label => $cSql) {
                    try {
                        $cStmt = $this->varPDOModelObj->varDBPDO->prepare($cSql);
                        $cStmt->execute([$vehicleId]);
                        $cnt = (int)$cStmt->fetchColumn();
                        if ($cnt > 0) {
                            $foundSources[] = "{$label} ({$cnt})";
                        }
                    } catch (Exception $eChk) {}
                }

                if (!empty($foundSources)) {
                    echo json_encode([
                        'status' => false,
                        'message' => 'Cannot delete this vehicle because transactions exist in: ' . implode(', ', $foundSources)
                    ]);
                    break;
                }

                $delStmt = $this->varPDOModelObj->varDBPDO->prepare("DELETE FROM tbl_vehicles WHERE ids = ?");
                $ok = $delStmt->execute([$vehicleId]);
                echo json_encode([
                    'status' => (bool)$ok,
                    'message' => $ok ? 'Vehicle deleted successfully.' : 'Failed to delete vehicle.'
                ]);
            break;
             case 'vehicle_calendar':
                  $sql = "
                SELECT 
                    v.ids,
                    v.model_names,
                    v.vehicle_number,
                    v.vehicle_year,
                    v.vehicle_color,
                    v.other_details_json,
                    v.vehicle_status,
                    v.vehicle_purchase_date,
                    v.next_passing_date,
                    v.next_insurance_date,
                    v.next_maintenance_date,
                    v.passing_histroy,
                    v.insurance_histroy,
                    v.maintenance_histroy,
                    DATE_FORMAT(v.vehicle_purchase_date, '%d-%m-%Y') as vehicle_purchase_date_format,
                    DATE_FORMAT(v.next_passing_date, '%d-%m-%Y') as next_passing_date_format,
                    DATE_FORMAT(v.next_insurance_date, '%d-%m-%Y') as next_insurance_date_format,
                    DATE_FORMAT(v.next_maintenance_date, '%d-%m-%Y') as next_maintenance_date_format
                
                FROM tbl_vehicles v
                WHERE v.vehicle_status != 'Sold Out'
                ";
                
               
                
			   
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql);

               $decoded = json_decode($this->ReturnData, true);

                echo json_encode([
                    "status" => "success",
                    "data" => $decoded['data'] ?? []
                ]);
            break;
            
            case 'ListVehicleMaster_Due_days':
                $allowedCompanies = [];
                if (!empty($_SESSION['company_json'])) {
                    $companyData = json_decode($_SESSION['company_json'], true);
                    if (is_array($companyData)) {
                        $allowedCompanies = array_column($companyData, 'ids');
                    }
                }
                if (empty($allowedCompanies)) {
                    $allowedCompanies = [$_SESSION['company_id'] ?? 1];
                }

                $inputData = json_decode($this->json, true);
                $selectedCompanyId = $inputData['company_id'] ?? '';
                $filterCompanyId = '';
                if ($selectedCompanyId !== '' && in_array($selectedCompanyId, $allowedCompanies)) {
                    $filterCompanyId = $selectedCompanyId;
                }

                $sql = "
                SELECT 
                    v.ids,
                    v.model_names,
                    v.vehicle_number,
                    v.vehicle_year,
                    v.vehicle_color,
                    v.other_details_json,
                    v.vehicle_status,
                    v.vehicle_purchase_date,
                    v.next_passing_date,
                    v.next_insurance_date,
                    v.next_maintenance_date,
                    v.passing_histroy,
                    v.insurance_histroy,
                    v.maintenance_histroy,
                    v.is_outsourced,
                    c.company_name AS ownership_company,
                    o.company_name AS outsourcing_company_name,
                    DATE_FORMAT(v.vehicle_purchase_date, '%d-%m-%Y') as vehicle_purchase_date_format,
                    DATE_FORMAT(v.next_passing_date, '%d-%m-%Y') as next_passing_date_format,
                    DATE_FORMAT(v.next_insurance_date, '%d-%m-%Y') as next_insurance_date_format,
                    DATE_FORMAT(v.next_maintenance_date, '%d-%m-%Y') as next_maintenance_date_format,
                    DATEDIFF(v.next_passing_date, :filter_date1) AS passing_age_days,
                    DATEDIFF(v.next_insurance_date, :filter_date2) AS insurance_age_days,
                    DATEDIFF(v.next_maintenance_date, :filter_date3) AS maintenance_age_days,
                     IFNULL(MAX(CASE
                        WHEN jt.item = 'Price per hour rental without driver'
                        THEN jt.amount END), 0) AS price_hour_without_driver,
                
                    IFNULL(MAX(CASE
                        WHEN jt.item = 'Price per hour rental with driver'
                        THEN jt.amount END), 0) AS price_hour_with_driver,
                
                    IFNULL(MAX(CASE
                        WHEN jt.item = 'Price per day rental without driver'
                        THEN jt.amount END), 0) AS price_day_without_driver,
                
                    IFNULL(MAX(CASE
                        WHEN jt.item = 'Price per day rental with driver'
                        THEN jt.amount END), 0) AS price_day_with_driver,
                
                    IFNULL(MAX(CASE
                        WHEN jt.item = 'Price per week rental without driver'
                        THEN jt.amount END), 0) AS price_week_without_driver,
                
                    IFNULL(MAX(CASE
                        WHEN jt.item = 'Price per week rental with driver'
                        THEN jt.amount END), 0) AS price_week_with_driver,
                
                    IFNULL(MAX(CASE
                        WHEN jt.item = 'Price per month rental without driver'
                        THEN jt.amount END), 0) AS price_month_without_driver,
                
                    IFNULL(MAX(CASE
                        WHEN jt.item = 'Price per month rental with driver'
                        THEN jt.amount END), 0) AS price_month_with_driver
                
                FROM tbl_vehicles v
                
                LEFT JOIN tbl_vehicle_model vm ON vm.ids = v.model_id
                LEFT JOIN tbl_company c ON c.ids = v.company_id
                LEFT JOIN tbl_outsourcing_companies o ON o.ids = v.outsourcing_company_id
                
                LEFT JOIN JSON_TABLE(
                    vm.price_json,
                    '$[*]' COLUMNS (
                        item VARCHAR(255) PATH '$.item',
                        amount DECIMAL(10,3) PATH '$.amount'
                    )
                ) jt ON TRUE
                
                WHERE v.vehicle_status != 'Sold Out'
                ";
                
                $sqlparams = [
                    ':filter_date1' => $this->filter_date,
                    ':filter_date2' => $this->filter_date,
                    ':filter_date3' => $this->filter_date,
                ];
                
                
                if (!empty($this->vehicle_model) && $this->vehicle_model !== 'All') {
                    $sql .= " AND v.model_id = :vehicle_model";
                    $sqlparams[':vehicle_model'] = $this->vehicle_model;
                }

                if ($filterCompanyId !== '') {
                    $sql .= " AND v.company_id = :company_id";
                    $sqlparams[':company_id'] = $filterCompanyId;
                } else {
                    $inQueryParts = [];
                    foreach ($allowedCompanies as $index => $comp_id) {
                        $paramName = ":comp_" . $index;
                        $inQueryParts[] = $paramName;
                        $sqlparams[$paramName] = $comp_id;
                    }
                    if (!empty($inQueryParts)) {
                        $inQueryStr = implode(',', $inQueryParts);
                        $sql .= " AND v.company_id IN ($inQueryStr) ";
                    }
                }

			   $sql .= " GROUP BY v.ids ";
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql, $sqlparams);

               $decoded = json_decode($this->ReturnData, true);

                echo json_encode([
                    "status" => "success",
                    "data" => $decoded['data'] ?? []
                ]);
		
			    
            break;
            case 'vehicle_dashboard_load':
                 $sql = "SELECT COALESCE(COUNT(CASE WHEN vehicle_status = 'Available' THEN ids END), 0) AS available_count, COALESCE(COUNT(CASE WHEN vehicle_status = 'Parking' THEN ids END), 0) AS parking_count, COALESCE(COUNT(CASE WHEN vehicle_status = 'Rentout' THEN ids END), 0) AS rentout_count, COALESCE(COUNT(CASE WHEN vehicle_status = 'Blocked' THEN ids END), 0) AS blocked_count, COALESCE(COUNT(CASE WHEN vehicle_status = 'Maintenance' THEN ids END), 0) AS maintainence_count, COALESCE(COUNT(ids), 0) AS total_count FROM tbl_vehicles";
                 $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql);

               $decoded = json_decode($this->ReturnData, true);

                echo json_encode([
                    "status" => "success",
                    "data" => $decoded['data'] ?? []
                ]);
            break;
           case 'ListVehicleMaster_Due_days_dash':
              $sql = "
                        SELECT 
                            v.ids,
                            v.model_names,
                            v.vehicle_number,
                            v.vehicle_year,
                            v.vehicle_color,
                            v.other_details_json,
                            v.vehicle_status,
                            v.vehicle_purchase_date,
                            v.next_passing_date,
                            v.next_insurance_date,
                            v.next_maintenance_date,
                            v.passing_histroy,
                                v.insurance_histroy,
                                v.maintenance_histroy,
                            DATE_FORMAT(v.vehicle_purchase_date, '%d-%m-%Y') as vehicle_purchase_date_format,
                            DATE_FORMAT(v.next_passing_date, '%d-%m-%Y') as next_passing_date_format,
                            DATE_FORMAT(v.next_insurance_date, '%d-%m-%Y') as next_insurance_date_format,
                            DATE_FORMAT(v.next_maintenance_date, '%d-%m-%Y') as next_maintenance_date_format,
                        
                            CASE 
                                WHEN v.next_passing_date IS NOT NULL 
                                THEN DATEDIFF(v.next_passing_date, :filter_date1)
                                ELSE NULL 
                            END AS passing_age_days,
                        
                            CASE 
                                WHEN v.next_insurance_date IS NOT NULL 
                                THEN DATEDIFF(v.next_insurance_date, :filter_date2)
                                ELSE NULL 
                            END AS insurance_age_days,
                        
                            CASE 
                                WHEN v.next_maintenance_date IS NOT NULL 
                                THEN DATEDIFF(v.next_maintenance_date, :filter_date3)
                                ELSE NULL 
                            END AS maintenance_age_days
                        
                        FROM tbl_vehicles v
                        WHERE v.vehicle_status != 'Sold Out'
                        
                        AND (
                            (v.next_passing_date IS NOT NULL 
                                AND DATEDIFF(v.next_passing_date, :filter_date4) <= 5)
                        
                            OR (v.next_insurance_date IS NOT NULL 
                                AND DATEDIFF(v.next_insurance_date, :filter_date5) <= 5)
                        
                            OR (v.next_maintenance_date IS NOT NULL 
                                AND DATEDIFF(v.next_maintenance_date, :filter_date6) <= 5)
                        )
                        ";
                
               $sqlparams = [
                        ':filter_date1' => $this->filter_date,
                        ':filter_date2' => $this->filter_date,
                        ':filter_date3' => $this->filter_date,
                        ':filter_date4' => $this->filter_date,
                        ':filter_date5' => $this->filter_date,
                        ':filter_date6' => $this->filter_date,
                    ];
                
                
                
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql, $sqlparams);

               $decoded = json_decode($this->ReturnData, true);

                echo json_encode([
                    "status" => "success",
                    "data" => $decoded['data'] ?? []
                ]);
		
			    
            break;
            case 'ListVehicleMaster_Due_days_dash_new':
                $sql = " SELECT 
                        v.ids,
                        v.model_names,
                        v.vehicle_number,
                        v.vehicle_year,
                        v.vehicle_color,
                        v.other_details_json,
                        v.vehicle_status,
                        v.vehicle_purchase_date,
                    
                        v.passing_histroy,
                        v.insurance_histroy,
                        v.maintenance_histroy,
                    
                        DATE_FORMAT(v.vehicle_purchase_date, '%d-%m-%Y') AS vehicle_purchase_date_format,
                    
                        pass.next_date AS next_passing_date,
                        ins.next_date  AS next_insurance_date,
                        main.next_date AS next_maintenance_date,
                    
                        DATE_FORMAT(pass.next_date, '%d-%m-%Y') AS next_passing_date_format,
                        DATE_FORMAT(ins.next_date, '%d-%m-%Y')  AS next_insurance_date_format,
                        DATE_FORMAT(main.next_date, '%d-%m-%Y') AS next_maintenance_date_format,
                    
                        CASE 
                            WHEN pass.next_date IS NOT NULL 
                            THEN DATEDIFF(pass.next_date, :filter_date1)
                        END AS passing_age_days,
                    
                        CASE 
                            WHEN ins.next_date IS NOT NULL 
                            THEN DATEDIFF(ins.next_date, :filter_date2)
                        END AS insurance_age_days,
                    
                        CASE 
                            WHEN main.next_date IS NOT NULL 
                            THEN DATEDIFF(main.next_date, :filter_date3)
                        END AS maintenance_age_days
                    
                    FROM tbl_vehicles v
                    
                    
                    -- PASSING HISTORY (latest next_date)
                    LEFT JOIN (
                        SELECT vehicle_id, MAX(next_date) AS next_date
                        FROM (
                            SELECT v.ids AS vehicle_id,
                                   jt.next_date
                            FROM tbl_vehicles v,
                            JSON_TABLE(v.passing_histroy, '$[*]'
                                COLUMNS (
                                    next_date DATE PATH '$.next_date'
                                )
                            ) jt
                            WHERE jt.next_date IS NOT NULL
                        ) x
                        GROUP BY vehicle_id
                    ) pass ON pass.vehicle_id = v.ids
                    
                    
                    -- INSURANCE HISTORY
                    LEFT JOIN (
                        SELECT vehicle_id, MAX(next_date) AS next_date
                        FROM (
                            SELECT v.ids AS vehicle_id,
                                   jt.next_date
                            FROM tbl_vehicles v,
                            JSON_TABLE(v.insurance_histroy, '$[*]'
                                COLUMNS (
                                    next_date DATE PATH '$.next_date'
                                )
                            ) jt
                            WHERE jt.next_date IS NOT NULL
                        ) x
                        GROUP BY vehicle_id
                    ) ins ON ins.vehicle_id = v.ids
                    
                    
                    -- MAINTENANCE HISTORY
                    LEFT JOIN (
                        SELECT vehicle_id, MAX(next_date) AS next_date
                        FROM (
                            SELECT v.ids AS vehicle_id,
                                   jt.next_date
                            FROM tbl_vehicles v,
                            JSON_TABLE(v.maintenance_histroy, '$[*]'
                                COLUMNS (
                                    next_date DATE PATH '$.next_date'
                                )
                            ) jt
                            WHERE jt.next_date IS NOT NULL
                        ) x
                        GROUP BY vehicle_id
                    ) main ON main.vehicle_id = v.ids
                    
                    
                    WHERE v.vehicle_status != 'Sold Out'";
                    $sqlparams = [
                        ':filter_date1' => $this->filter_date,
                        ':filter_date2' => $this->filter_date,
                        ':filter_date3' => $this->filter_date
                    ];
                
                
                
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql, $sqlparams);

               $decoded = json_decode($this->ReturnData, true);

                echo json_encode([
                    "status" => "success",
                    "data" => $decoded['data'] ?? []
                ]);
		
            break;
            case 'vehicle_return_due_dashboard':
            case 'return_vehicle_calendar':
                $sysSettings = get_system_settings($_SESSION['company_id'] ?? 1);
                $dateFormatSetting = $sysSettings['date_format'] ?? 'Y-m-d';

                switch ($dateFormatSetting) {
                    case 'd/m/Y':
                        $sqlDateFormat = '%d/%m/%Y';
                        $sqlDateTimeFormat = '%d/%m/%Y %H:%i';
                        break;
                    case 'd-M-Y':
                        $sqlDateFormat = '%d-%b-%Y';
                        $sqlDateTimeFormat = '%d-%b-%Y %H:%i';
                        break;
                    case 'm/d/Y':
                        $sqlDateFormat = '%m/%d/%Y';
                        $sqlDateTimeFormat = '%m/%d/%Y %H:%i';
                        break;
                    case 'Y-m-d':
                    default:
                        $sqlDateFormat = '%Y-%m-%d';
                        $sqlDateTimeFormat = '%Y-%m-%d %H:%i';
                        break;
                }

                $filterDate = !empty($this->filter_date) ? $this->filter_date : date('Y-m-d');

                $sql = "  SELECT 
                         c.ids,
                         c.agreement_no,
                         JSON_UNQUOTE(JSON_EXTRACT(c.customer_details, '$.customer_name')) AS customer_name,
                         JSON_UNQUOTE(JSON_EXTRACT(c.customer_details, '$.customer_mobile')) AS customer_mobile,
                         JSON_UNQUOTE(JSON_EXTRACT(c.vechile_details, '$.model_name')) AS model_name,
                         c.vehicle_no,
                         c.agreement_status,
                         c.service_start_date_time,
                         CASE 
                             WHEN c.agreement_status = 'Extended' 
                                  AND ext.extend_end_date IS NOT NULL 
                             THEN ext.extend_end_date
                             ELSE c.service_end_date_time
                         END AS return_date,
                         DATEDIFF(
                             CASE 
                                 WHEN c.agreement_status = 'Extended' 
                                      AND ext.extend_end_date IS NOT NULL 
                                 THEN ext.extend_end_date
                                 ELSE c.service_end_date_time
                             END,
                             :filter_date
                         ) AS days_left,
                         DATE_FORMAT(service_start_date_time, '{$sqlDateTimeFormat}') AS start_date,
                         DATE_FORMAT(
                                 CASE 
                                     WHEN c.agreement_status = 'Extended' 
                                          AND ext.extend_end_date IS NOT NULL 
                                     THEN ext.extend_end_date
                                     ELSE c.service_end_date_time
                                 END,
                                 '{$sqlDateFormat}'
                             ) AS return_date_format
                     
                     FROM tbl_vehicle_rentout_contracts c
                     
                     LEFT JOIN (
                         SELECT agreement_ids, MAX(extend_end_date) AS extend_end_date
                         FROM tbl_vehicle_contract_extensions
                         GROUP BY agreement_ids
                     ) ext 
                         ON ext.agreement_ids = c.ids
                     
                     WHERE c.agreement_status IN ('Rentout', 'Extended')";

                $sqlparams = [
                    ':filter_date' => $filterDate
                ];

                $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql, $sqlparams);

                $decoded = json_decode($this->ReturnData, true);

                echo json_encode([
                    "status" => "success",
                    "data" => $decoded['data'] ?? []
                ]);
            break;
            case 'unbilled_invocies':
                switch($this->contract_status)
                {
                    case 'Rentout':
                         $sql="SELECT
                                t.*
                            FROM
                            (
                                /* RENTOUT CONTRACTS */
                                SELECT
                                    c.ids,
                                    c.agreement_no,
                                    c.customer_name,
                                    c.customer_code,
                                    c.booking_ids,
                                    c.vehicle_no,
                                    c.vehicle_id,
                                    c.vehicle_model_id as model_id,
                                    JSON_UNQUOTE(
                                        JSON_EXTRACT(c.vechile_details, '$.model_name')
                                    ) AS model_name,
                                    c.agreement_status AS source_type
                            
                                FROM tbl_vehicle_rentout_contracts c
                            
                                WHERE
                                    c.agreement_status = 'Rentout'
                                   AND c.service_start_date_time <= '$this->filter_end_date_time'
                                    AND c.service_end_date_time >= '$this->filter_start_date_time'
                            
                                UNION
                            
                                /* EXTENDED CONTRACTS */
                                SELECT
                                    c.ids,
                                    c.agreement_no,
                                    c.customer_name,
                                    c.customer_code,
                                    c.booking_ids,
                                    c.vehicle_no,
                                    c.vehicle_id,
                                    c.vehicle_model_id as model_id,
                                    JSON_UNQUOTE(
                                        JSON_EXTRACT(c.vechile_details, '$.model_name')
                                    ) AS model_name,
                                    c.agreement_status AS source_type
                            
                                FROM tbl_vehicle_rentout_contracts c
                            
                                INNER JOIN tbl_vehicle_contract_extensions e
                                    ON e.agreement_ids = c.ids
                            
                                WHERE
                                    c.agreement_status = 'Extended'
                                    AND e.extend_start_date <= '$this->filter_end_date_time'
                                    AND e.extend_end_date >= '$this->filter_start_date_time'
                            
                            ) t
                            
                            WHERE NOT EXISTS
                            (
                                SELECT 1
                                FROM invoices i
                            
                                JOIN JSON_TABLE(
                                    i.items,
                                    '$[*]'
                                    COLUMNS (
                                        agreement_no VARCHAR(200) PATH '$.agreement_no',
                                        period_from DATE PATH '$.period_from',
                                        period_to DATE PATH '$.period_to'
                                    )
                                ) jt
                            
                                WHERE
                                    REGEXP_REPLACE(jt.agreement_no, '[[:space:]]+', '')
                                    =
                                    REGEXP_REPLACE(t.agreement_no, '[[:space:]]+', '')
                            
                                   AND jt.period_from <= '$this->filter_end_date'
                                    AND jt.period_to   >= '$this->filter_start_date'
                            )";
                    break;
                    case 'Returned':
                        $sql="SELECT
                                t.*
                            FROM
                            (
                                /* RENTOUT CONTRACTS */
                                SELECT
                                   c.ids,
                                    c.agreement_no,
                                    c.customer_name,
                                    c.customer_code,
                                    c.booking_ids,
                                    c.vehicle_no,
                                    c.vehicle_id,
                                    c.vehicle_model_id as model_id,
                                    JSON_UNQUOTE(
                                        JSON_EXTRACT(c.vechile_details, '$.model_name')
                                    ) AS model_name,
                                    c.agreement_status AS source_type
                            
                                FROM tbl_vehicle_rentout_contracts c
                            
                                WHERE
                                    c.agreement_status = 'Returned'
                                   AND c.service_start_date_time <= '$this->filter_end_date_time'
                                    AND c.service_end_date_time >= '$this->filter_start_date_time'
                            
                                UNION
                            
                                /* EXTENDED CONTRACTS */
                                SELECT
                                   c.ids,
                                    c.agreement_no,
                                    c.customer_name,
                                    c.customer_code,
                                    c.booking_ids,
                                    c.vehicle_no,
                                    c.vehicle_id,
                                    c.vehicle_model_id as model_id,
                                    JSON_UNQUOTE(
                                        JSON_EXTRACT(c.vechile_details, '$.model_name')
                                    ) AS model_name,
                                    c.agreement_status AS source_type
                            
                                FROM tbl_vehicle_rentout_contracts c
                            
                                INNER JOIN tbl_vehicle_contract_extensions e
                                    ON e.agreement_ids = c.ids
                            
                                WHERE
                                    c.agreement_status = 'Returned'
                                    AND e.extend_start_date <= '$this->filter_end_date_time'
                                    AND e.extend_end_date >= '$this->filter_start_date_time'
                            
                            ) t
                            
                            WHERE NOT EXISTS
                            (
                                SELECT 1
                                FROM invoices i
                            
                                JOIN JSON_TABLE(
                                    i.items,
                                    '$[*]'
                                    COLUMNS (
                                        agreement_no VARCHAR(200) PATH '$.agreement_no',
                                        period_from DATE PATH '$.period_from',
                                        period_to DATE PATH '$.period_to'
                                    )
                                ) jt
                            
                                WHERE
                                    REGEXP_REPLACE(jt.agreement_no, '[[:space:]]+', '')
                                    =
                                    REGEXP_REPLACE(t.agreement_no, '[[:space:]]+', '')
                            
                                   AND jt.period_from <= '$this->filter_end_date'
                                    AND jt.period_to   >= '$this->filter_start_date'
                            )";
                    break;
                    case 'Closed':
                         $sql="SELECT
                                t.*
                            FROM
                            (
                                /* RENTOUT CONTRACTS */
                                SELECT
                                   c.ids,
                                    c.agreement_no,
                                    c.customer_name,
                                    c.customer_code,
                                    c.booking_ids,
                                    c.vehicle_no,
                                    c.vehicle_id,
                                    c.vehicle_model_id as model_id,
                                    JSON_UNQUOTE(
                                        JSON_EXTRACT(c.vechile_details, '$.model_name')
                                    ) AS model_name,
                                    c.agreement_status AS source_type
                            
                                FROM tbl_vehicle_rentout_contracts c
                            
                                WHERE
                                    c.agreement_status = 'Closed'
                                  AND c.service_start_date_time <= '$this->filter_end_date_time'
                                    AND c.service_end_date_time >= '$this->filter_start_date_time'
                            
                                UNION
                            
                                /* EXTENDED CONTRACTS */
                                SELECT
                                    c.ids,
                                    c.agreement_no,
                                    c.customer_name,
                                    c.customer_code,
                                    c.booking_ids,
                                    c.vehicle_no,
                                    c.vehicle_id,
                                    c.vehicle_model_id as model_id,
                                    JSON_UNQUOTE(
                                        JSON_EXTRACT(c.vechile_details, '$.model_name')
                                    ) AS model_name,
                                    c.agreement_status AS source_type
                            
                                FROM tbl_vehicle_rentout_contracts c
                            
                                INNER JOIN tbl_vehicle_contract_extensions e
                                    ON e.agreement_ids = c.ids
                            
                                WHERE
                                    c.agreement_status = 'Closed'
                                    AND e.extend_start_date <= '$this->filter_end_date_time'
                                    AND e.extend_end_date >= '$this->filter_start_date_time'
                            
                            ) t
                            
                            WHERE NOT EXISTS
                            (
                                SELECT 1
                                FROM invoices i
                            
                                JOIN JSON_TABLE(
                                    i.items,
                                    '$[*]'
                                    COLUMNS (
                                        agreement_no VARCHAR(200) PATH '$.agreement_no',
                                        period_from DATE PATH '$.period_from',
                                        period_to DATE PATH '$.period_to'
                                    )
                                ) jt
                            
                                WHERE
                                    REGEXP_REPLACE(jt.agreement_no, '[[:space:]]+', '')
                                    =
                                    REGEXP_REPLACE(t.agreement_no, '[[:space:]]+', '')
                            
                                  AND jt.period_from <= '$this->filter_end_date'
                                    AND jt.period_to   >= '$this->filter_start_date'
                            )";
                    break;
                    default:
                         $sql="SELECT
                                t.*
                            FROM
                            (
                                /* RENTOUT CONTRACTS */
                                SELECT
                                   c.ids,
                                    c.agreement_no,
                                    c.customer_name,
                                    c.customer_code,
                                    c.booking_ids,
                                    c.vehicle_no,
                                    c.vehicle_id,
                                    c.vehicle_model_id as model_id,
                                    JSON_UNQUOTE(
                                        JSON_EXTRACT(c.vechile_details, '$.model_name')
                                    ) AS model_name,
                                    c.agreement_status AS source_type
                            
                                FROM tbl_vehicle_rentout_contracts c
                            
                                WHERE
                                    c.service_start_date_time <= '$this->filter_end_date_time'
                                    AND c.service_end_date_time >= '$this->filter_start_date_time'
                            
                                UNION
                            
                                /* EXTENDED CONTRACTS */
                                SELECT
                                    c.ids,
                                    c.agreement_no,
                                    c.customer_name,
                                    c.customer_code,
                                    c.booking_ids,
                                    c.vehicle_no,
                                    c.vehicle_id,
                                    c.vehicle_model_id as model_id,
                                    JSON_UNQUOTE(
                                        JSON_EXTRACT(c.vechile_details, '$.model_name')
                                    ) AS model_name,
                                    c.agreement_status AS source_type
                            
                                FROM tbl_vehicle_rentout_contracts c
                            
                                INNER JOIN tbl_vehicle_contract_extensions e
                                    ON e.agreement_ids = c.ids
                            
                                WHERE
                                     e.extend_start_date <= '$this->filter_end_date_time'
                                    AND e.extend_end_date >= '$this->filter_start_date_time'
                            
                            ) t
                            
                            WHERE NOT EXISTS
                            (
                                SELECT 1
                                FROM invoices i
                            
                                JOIN JSON_TABLE(
                                    i.items,
                                    '$[*]'
                                    COLUMNS (
                                        agreement_no VARCHAR(200) PATH '$.agreement_no',
                                        period_from DATE PATH '$.period_from',
                                        period_to DATE PATH '$.period_to'
                                    )
                                ) jt
                            
                                WHERE
                                    REGEXP_REPLACE(jt.agreement_no, '[[:space:]]+', '')
                                    =
                                    REGEXP_REPLACE(t.agreement_no, '[[:space:]]+', '')
                            
                                    AND jt.period_from <= '$this->filter_end_date'
                                    AND jt.period_to   >= '$this->filter_start_date'
                            )";
                        
                    break;
                    
                }
            
                  $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql);

               $decoded = json_decode($this->ReturnData, true);

                echo json_encode([
                    "status" => "success",
                    "data" => $decoded['data'] ?? []
                ]);
            break;
            case 'get_vehicle_profile':
                $inputData = json_decode($this->json, true);
                $vehicleId = $inputData['vehicle_id'] ?? ($_GET['vehicle_id'] ?? null);

                if (!$vehicleId) {
                    echo json_encode(['status' => false, 'message' => 'Vehicle ID is required']);
                    break;
                }

                $sql = "SELECT v.*, 
                               c.company_name as ownership_company,
                               o.company_name AS outsourcing_company_name,
                               vb.brand_name,
                               vc.category_name,
                               vm.price_json as model_price_json,
                               DATE_FORMAT(v.vehicle_purchase_date, '%d-%b-%Y') as formatted_purchase_date,
                               DATE_FORMAT(v.next_insurance_date, '%d-%b-%Y') as formatted_insurance_date,
                               DATE_FORMAT(v.next_passing_date, '%d-%b-%Y') as formatted_passing_date,
                               DATE_FORMAT(v.next_maintenance_date, '%d-%b-%Y') as formatted_maintenance_date
                        FROM tbl_vehicles v 
                        LEFT JOIN tbl_company c ON v.company_id = c.ids
                        LEFT JOIN tbl_outsourcing_companies o ON o.ids = v.outsourcing_company_id 
                        LEFT JOIN tbl_vehicle_brand vb ON v.brand_id = vb.ids
                        LEFT JOIN tbl_vehicle_category vc ON v.category_id = vc.ids
                        LEFT JOIN tbl_vehicle_model vm ON v.model_id = vm.ids
                        WHERE v.ids = ?";
                
                $stmt = $this->varPDOModelObj->varDBPDO->prepare($sql);
                $stmt->execute([$vehicleId]);
                $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($vehicle) {
                    $vehicle['current_user_name'] = null;
                    $vehicle['current_user_contact'] = null;
                    
                    if (in_array($vehicle['vehicle_status'], ['Rentout', 'Staff Use'])) {
                        $vehicle['contract_ref'] = null;
                        $vehicle['expected_return_date'] = null;
                        
                        if ($vehicle['vehicle_status'] === 'Rentout') {
                            // Fetch from Rentout Contracts directly
                            $rSql = "SELECT ids, agreement_no, customer_code, customer_name, service_end_date_time FROM tbl_vehicle_rentout_contracts WHERE vehicle_id = ? AND agreement_status = 'Rentout' ORDER BY ids DESC LIMIT 1";
                            $rStmt = $this->varPDOModelObj->varDBPDO->prepare($rSql);
                            $rStmt->execute([$vehicleId]);
                            $r = $rStmt->fetch(PDO::FETCH_ASSOC);
                            
                            if ($r) {
                                $vehicle['contract_ref'] = $r['agreement_no'];
                                $vehicle['current_user_name'] = $r['customer_name'];
                                $vehicle['expected_return_date'] = $r['service_end_date_time'];
                                
                                // Fetch contact
                                $cSql = "SELECT customer_mobile FROM customer_details WHERE customer_id = ?";
                                $cStmt = $this->varPDOModelObj->varDBPDO->prepare($cSql);
                                $cStmt->execute([$r['customer_code']]);
                                $c = $cStmt->fetch(PDO::FETCH_ASSOC);
                                if ($c) {
                                    $vehicle['current_user_contact'] = $c['customer_mobile'];
                                }
                                
                                // Check for extensions
                                $extSql = "SELECT extend_end_date FROM tbl_vehicle_contract_extensions WHERE agreement_ids = ? ORDER BY ids DESC LIMIT 1";
                                $extStmt = $this->varPDOModelObj->varDBPDO->prepare($extSql);
                                $extStmt->execute([$r['ids']]);
                                $ext = $extStmt->fetch(PDO::FETCH_ASSOC);
                                if ($ext && !empty($ext['extend_end_date'])) {
                                    $vehicle['expected_return_date'] = $ext['extend_end_date'];
                                }
                            }
                        } else if ($vehicle['vehicle_status'] === 'Staff Use') {
                            // Staff Use - use non revenue ticket
                            $nrSql = "SELECT booking_no, staff_ids, staff_name, book_to_date FROM tbl_vehicle_non_revenue_ticket WHERE vehicle_id = ? AND book_status != 'Closed' ORDER BY ids DESC LIMIT 1";
                            $nrStmt = $this->varPDOModelObj->varDBPDO->prepare($nrSql);
                            $nrStmt->execute([$vehicleId]);
                            $nr = $nrStmt->fetch(PDO::FETCH_ASSOC);
                            
                            if ($nr) {
                                $vehicle['contract_ref'] = $nr['booking_no'];
                                $vehicle['current_user_name'] = $nr['staff_name'];
                                $vehicle['expected_return_date'] = $nr['book_to_date'];
                                
                                if (!empty($nr['staff_ids'])) {
                                    $sSql = "SELECT staff_contact_no FROM tbl_staff WHERE ids = ?";
                                    $sStmt = $this->varPDOModelObj->varDBPDO->prepare($sSql);
                                    $sStmt->execute([$nr['staff_ids']]);
                                    $s = $sStmt->fetch(PDO::FETCH_ASSOC);
                                    if ($s) {
                                        $vehicle['current_user_contact'] = $s['staff_contact_no'];
                                    }
                                }
                            }
                        }
                    }

                    // Parse JSON fields
                    $vehicle['other_details'] = json_decode($vehicle['other_details_json'] ?? '{}', true);
                    $vehicle['images'] = json_decode($vehicle['image_json'] ?? '[]', true);
                    
                    echo json_encode([
                        "status" => true,
                        "data" => $vehicle
                    ]);
                } else {
                    echo json_encode([
                        "status" => false,
                        "message" => "Vehicle not found"
                    ]);
                }
            break;
			default:
        	      $noAction= json_encode([
                    'status'  => false,
                    'message' => "No Action Found..!"
                 ]);
                 echo $noAction;
                 Logger::ActivityLog('VehiclesController',"default",[json_decode($noAction)]);
			break;
			
		}
	 }
	
}

$obj = new VehiclesController();
$obj->DataRequest($obj->actionevents);

?>
