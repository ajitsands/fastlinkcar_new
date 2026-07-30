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
        $this->vehicleModal = $data['vehicleModel'] ?? null;
        $this->vehiclePurchaseDate = $data['vehiclePurchaseDate'] ?? null;
        $this->brand_id = $data['brand_id'] ?? null;
        $this->category_id = $data['category_id'] ?? null;
        $this->modelName = $data['modelName'] ?? null;
        
        $this->vehicle_ids = $data['ids'] ?? null;
        
        $this->vehiclePassingDate = $data['vehiclePassingDate'] ?? null;
        $this->vehicleInsuranceExpDate = $data['vehicleInsuranceExpDate'] ?? null;
        $this->vehicleStatus = $data['vehicleStatus'] ?? null;
        $this->category = $data['category'] ?? null;
        $this->belongsToCompanyID = $data['belongsToCompanyID'] ?? null;
        $this->belongsToCompanyName = $data['belongsToCompanyName'] ?? null;
        
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
       
        
        $this->company_id = $_SESSION['company_id'] ?? 1;
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
                        (category_id,model_id,model_names,brand_id,company_id,vehicle_number,vehicle_year,vehicle_color,image_json,other_details_json,vehicle_attachments,vehicle_status,created_on,created_by,vehicle_purchase_date) VALUES
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->params[0] = [
                $this->category_id,
                $this->vehicleModal,
                $this->modelName,
                $this->brand_id,
                $this->company_id,
                $this->vehicleRegNumber,
                $this->vehicleYear,
                $this->vehicleColor,
                $this->vehicleimages,
                $this->vehicleDetails,
                $this->vehiclesDocObj,
                'Available',
                $this->insertedDate,
                $this->user_id,
                $this->vehiclePurchaseDate
        ];
        
        $array[4] = "SELECT * FROM tbl_vehicles ORDER BY ids DESC";
        $array[5] = "UPDATE tbl_vehicles SET
                        category_id = ?,
                        model_id = ?,
                        model_names = ?,
                        brand_id = ?,
                        company_id = ?,
                        vehicle_number = ?,
                        vehicle_year = ?,
                        vehicle_color = ?,
                        image_json = ?,
                        other_details_json = ?,
                        vehicle_attachments = ?,
                        vehicle_purchase_date = ?
                    WHERE ids = ?";
        $this->params[5] = [
            $this->category_id,
            $this->vehicleModal,
            $this->modelName,
            $this->brand_id,
            $this->company_id,
            $this->vehicleRegNumber,
            $this->vehicleYear,
            $this->vehicleColor,
            $this->vehicleimages,
            $this->vehicleDetails,
            $this->vehiclesDocObj,
            $this->vehiclePurchaseDate,
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
			    
			     $result = $this->varPDOModelObj->UpdateTable($var[5], $this->params[5]);
			     // Logger::ActivityLog('UpdateVehicleInformation',"Send to Client - 103 ",[$var[5],$this->params[5],$result]);
			    
                echo $result;
			break;
			
		
            case 'ListVehicleMaster':
			    
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[4]);
			   
                echo json_encode([
                    "status" => "success",
                    "data" => json_decode($this->ReturnData, true)
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
                
                LEFT JOIN tbl_vehicle_model vm
                    ON vm.ids = v.model_id
                
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
                        DATE_FORMAT(service_start_date_time, '%d-%m-%Y %H:%i') AS start_date,
                       DATE_FORMAT(
                                CASE 
                                    WHEN c.agreement_status = 'Extended' 
                                         AND ext.extend_end_date IS NOT NULL 
                                    THEN ext.extend_end_date
                                    ELSE c.service_end_date_time
                                END,
                                '%d-%m-%Y'
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
                        ':filter_date' => $this->filter_date
                    ];
                
                
                
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql, $sqlparams);

               $decoded = json_decode($this->ReturnData, true);

                echo json_encode([
                    "status" => "success",
                    "data" => $decoded['data'] ?? []
                ]);
            break;
            case 'return_vehicle_calendar':
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
                       
                        DATE_FORMAT(service_start_date_time, '%d-%m-%Y %H:%i') AS start_date,
                       DATE_FORMAT(
                                CASE 
                                    WHEN c.agreement_status = 'Extended' 
                                         AND ext.extend_end_date IS NOT NULL 
                                    THEN ext.extend_end_date
                                    ELSE c.service_end_date_time
                                END,
                                '%d-%m-%Y'
                            ) AS return_date_format
                    
                    FROM tbl_vehicle_rentout_contracts c
                    
                    LEFT JOIN (
                        SELECT agreement_ids, MAX(extend_end_date) AS extend_end_date
                        FROM tbl_vehicle_contract_extensions
                        GROUP BY agreement_ids
                    ) ext 
                        ON ext.agreement_ids = c.ids
                    
                    WHERE c.agreement_status IN ('Rentout', 'Extended')";
                   
                
                
			   $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql);

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
