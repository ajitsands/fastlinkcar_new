<?PHP 
header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class VehiclesContractListController
{
	  var $varPDOModelObj;
      public $actionevents,$json;
      public $params = [];
      public $selectedBookingIds= [];
	  public $user_id,$company_id,$insertedDate,$bookingid,$vehicleid,$customer_code,$model_ids,$km_used;
	  public $booking_ids,$booking_ref_no,$customer_data,$vehicle_data,$contract_details,$company_driver_details,$vehicle_accessories,$tc_ids,$t_c_name,$terms_condition,$termsContent,$agreement_date,$contract_ids,$data_source_val,$filter_from,$filter_to,$booking_status,$hirer_name,$delivery_name,$hirer_signature,$delivery_signature,$agreementid,$agreement_no,$extend_ids,$vehicle_ids,$km_in,$return_date_in,$ReceiverSign,$receiver_name,$service_name,$close_otp_msg;
	  public $returnvehicleimages = [];
	  public $violations = [];
	  public $page, $limit, $offset, $status, $ReturnData;
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
       
        
        date_default_timezone_set('Asia/Bahrain');
        
        $this->actionevents = $data['action'] ?? null;
        $this->bookingid = $data['bookingid'] ?? null;
        $this->vehicleid = $data['vehicleid'] ?? null;
        $this->customer_code = $data['customer_code'] ?? null;
        $this->model_ids = $data['model_ids'] ?? null;
        $this->tc_ids = $data['tc_ids'] ?? null;
        $this->terms_condition = $data['terms_condition'] ?? '';
        $this->t_c_name = $data['t_c_name'] ?? '';
        $this->contract_ids = $data['contract_ids'] ?? '';
        $this->data_source_val = $data['data_source_val'] ?? '';
        $this->filter_from = $data['filter_from'] ?? '';
        $this->filter_to = $data['filter_to'] ?? '';
        $this->selectedBookingIds   = $data['selectedBookingIds'] ?? [];
        $this->hirer_name         = $data['hirer_name'] ?? '';
        $this->delivery_name      = $data['delivery_name'] ?? '';
        $this->hirer_signature    = $data['hirer_signature'] ?? '';
        $this->delivery_signature = $data['delivery_signature'] ?? '';
        $this->booking_status = $data['booking_status'] ?? 'All';
        $this->booking_ids = $data['booking_ids'] ?? '';
        $this->booking_ref_no = $data['booking_ref_no'] ?? '';
        $this->termsContent = $data['termsContent'] ?? '';
        $this->agreementid = $data['agreementid'] ?? '';
        $this->agreement_no = $data['agreement_no'] ?? '';
        $this->extend_ids = $data['extend_ids'] ?? '';
        $this->vehicle_ids = $data['vehicle_ids'] ?? '';
        $this->vehicle_number = $data['vehicle_number'] ?? '';
        $this->receiver_name      = $data['receiver_name'] ?? '';
        $this->ReceiverSign    = $data['ReceiverSign'] ?? '';
        $this->returnvehicleimages = $data['returnvehicleimages'] ?? [];
        $this->violations = $data['violations'] ?? [];
        $this->km_in = $data['km_in'] ?? '';
        $this->km_used = $data['km_used'] ?? '';
        
        $this->return_date_in = $data['return_date_in'] ?? '';
        $this->head_name = $data['head_name'] ?? '';

        $this->old_vehicle_id = $data['old_vehicle_id'] ?? '';
        $this->old_vehicle_no = $data['old_vehicle_no'] ?? '';
        $this->old_km_in = $data['old_km_in'] ?? '';
        $this->old_km_used = $data['old_km_used'] ?? '';
        $this->old_fuel_in = $data['old_fuel_in'] ?? '';
        $this->old_dt_in = $data['old_dt_in'] ?? '';
        $this->old_return_images = $data['old_return_images'] ?? [];
        $this->old_accessories = $data['old_accessories'] ?? [];
        $this->new_vehicle_id = $data['new_vehicle_id'] ?? '';
        $this->new_vehicle_no = $data['new_vehicle_no'] ?? '';
        $this->new_category_id = $data['new_category_id'] ?? '';
        $this->new_model_id = $data['new_model_id'] ?? '';
        $this->new_km_out = $data['new_km_out'] ?? '';
        $this->new_fuel_out = $data['new_fuel_out'] ?? '';
        $this->new_dt_out = $data['new_dt_out'] ?? '';
        $this->new_accessories = $data['new_accessories'] ?? [];
        $this->new_rentout_images = $data['new_rentout_images'] ?? [];
        $this->replace_remarks = $data['replace_remarks'] ?? '';
        $this->staff_name = $data['staff_name'] ?? '';
        $this->staff_signature = $data['staff_signature'] ?? '';
       
      
        
        $this->agreement_date = $data['agreement_date'] ?? date('Y-m-d');
               $this->customer_data = is_array($data['customer_data'] ?? null)
            ? $data['customer_data']
            : (json_decode($data['customer_data'] ?? '[]', true) ?? []);
        
        $this->vehicle_data = is_array($data['vehicle_data'] ?? null)
            ? $data['vehicle_data']
            : (json_decode($data['vehicle_data'] ?? '[]', true) ?? []);
        
        $this->contract_details = is_array($data['contract_details'] ?? null)
            ? $data['contract_details']
            : (json_decode($data['contract_details'] ?? '[]', true) ?? []);
        
        $this->company_driver_details = is_array($data['company_driver_details'] ?? null)
            ? $data['company_driver_details']
            : (json_decode($data['company_driver_details'] ?? '[]', true) ?? []);
        
        $this->vehicle_accessories = is_array($data['vehicle_accessories'] ?? null)
            ? $data['vehicle_accessories']
            : (json_decode($data['vehicle_accessories'] ?? '[]', true) ?? []);
      
      
        $this->close_otp_msg    = $data['close_otp_msg'] ?? '';
        $this->service_name    = $data['service_name'] ?? '';
        $this->company_id = !empty($data['company_id']) ? $data['company_id'] : ($_SESSION['company_id'] ?? 1);
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
     
         $array[1] = "INSERT INTO tbl_vehicle_contract_extensions (
            company_id,
            agreement_ids,
            agreement_no,
            booking_ids,
            customer_code,
            vehicle_ids,
            customer_details,
            vehicle_details,
            extension_date,
            extend_start_date,
            extend_end_date,
            extend_details,
            otp_details,
            extend_log_json
        ) VALUES (
            :company_id,
            :agreement_ids,
            :agreement_no,
            :booking_ids,
            :customer_code,
            :vehicle_id,
            :customer_details,
            :vechile_details,
            :extension_date,
            :service_start,
            :service_end,
            :contract_details,
            :otp_details,
            :log_details
        )";
        $array[2] = "UPDATE tbl_vehicle_rentout_contracts SET

                booking_ids = :booking_ids,
                company_id = :company_id,
                agreement_no = :agreement_no,
                agreement_group_ref_no = :booking_ref_no,
                agreement_date = :agreement_date,
                customer_code = :customer_code,
                customer_name = :customer_name,
                customer_details = :customer_details,
                quotation_number = :quotation_number,
                vehicle_category_id = :vehicle_category_id,
                vehicle_model_id = :vehicle_model_id,
                vehicle_id = :vehicle_id,
                vehicle_no = :vehicle_no,
                vechile_details = :vechile_details,
                service_type = :service_type,
                service_start_date_time = :service_start,
                service_end_date_time = :service_end,
                contract_details_json = :contract_details,
                km_out = :km_out,
                vehicle_accessories_details = :vehicle_accessories,
                vehicle_rentout_images = :vehicle_images,
                driver_ids = :driver_ids,
                driver_details = :driver_details,
                customer_driver_name = :cust_driver_name,
                customer_driver_contact_number = :cust_driver_mobile,
                customer_driver_attachments = :cust_driver_docs,
                minprice_otp_details = :otp_details,
                log_json = :log_details,
                terms_condition = :terms_condition
            WHERE ids = :contract_id";
            
        $array[3] = "SELECT terms_condition FROM tbl_terms_and_condition_contract WHERE ids = :tc_ids";
        
        $this->params[3] = [
             ':tc_ids' => $this->tc_ids
        ];
        $array[4] = "DELETE from tbl_terms_and_condition_contract WHERE ids = :tc_ids";
         $this->params[4] = [
             ':tc_ids' => $this->tc_ids
        ];
		return $array;
	}
	function generateAgreementNo($pdo) {
    
        $year = date('Y');
    
        $prefix = "AA/$year/AGR/";
    
        // Get last agreement number for this year
        $sql = "SELECT agreement_no 
                FROM tbl_vehicle_rentout_contracts
                WHERE agreement_no LIKE :prefix
                ORDER BY ids DESC
                LIMIT 1";
    
       
          $stmt = $pdo->selectexecuteQuery(
                    $sql,
                    [':prefix' => "$prefix%"]
                );
        $last = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($last) {
            // Extract last number
            $lastNo = (int) substr($last['agreement_no'], -4);
            $nextNo = $lastNo + 1;
        } else {
            $nextNo = 1;
        }
    
        // Pad with zeros
        $sequence = str_pad($nextNo, 4, '0', STR_PAD_LEFT);
    
        return $prefix . $sequence;
    }
	function DataRequest($action)
	{
	 	$var =  $this->SQLArray();
		switch($action)
		{
		case 'ListContracts':

                    $baseQuery = "
                        SELECT tbl_vehicle_rentout_contracts.*, tc.company_name,
                            DATE_FORMAT(tbl_vehicle_rentout_contracts.service_start_date_time, '%d-%m-%Y %H:%i') AS from_date_format,
                            DATE_FORMAT(tbl_vehicle_rentout_contracts.service_end_date_time, '%d-%m-%Y %H:%i') AS to_date_format,DATE_FORMAT(tbl_vehicle_rentout_contracts.agreement_date, '%d-%m-%Y') AS agreement_date_format
                        FROM tbl_vehicle_rentout_contracts
                        LEFT JOIN tbl_company tc ON tc.ids = tbl_vehicle_rentout_contracts.company_id
                        WHERE 1=1
                    ";
                
                    $params = [];
                    if ($this->company_id !== 'all') {
                        $baseQuery .= " AND tbl_vehicle_rentout_contracts.company_id = :company_id";
                        $params[':company_id'] = $this->company_id;
                    }
                
                    if (!($this->customer_code == '' || $this->customer_code == 'All')) {
                
                        $baseQuery .= " AND tbl_vehicle_rentout_contracts.customer_code = :customer_code";
                        $params[':customer_code'] = $this->customer_code;
                    }
                
                    if ($this->filter_from != '' && $this->filter_to != '') {
                
                        $baseQuery .= "
                            AND DATE(tbl_vehicle_rentout_contracts.agreement_date)
                            BETWEEN :filter_from AND :filter_to
                        ";
                
                        $params[':filter_from'] = $this->filter_from;
                        $params[':filter_to']   = $this->filter_to;
                    }
                
                    if (!($this->booking_status == '' || $this->booking_status == 'All')) {
                
                        $baseQuery .= " AND tbl_vehicle_rentout_contracts.agreement_status = :booking_status";
                        $params[':booking_status'] = $this->booking_status;
                    }
                
                    $baseQuery .= " ORDER BY tbl_vehicle_rentout_contracts.ids DESC";
                
                    $result = $this->varPDOModelObj
                        ->selectexecuteQuery($baseQuery, $params);
                
                    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
                
                    $data = [];
                
                    foreach ($rows as $row) {
                
                        $custdetails = json_decode(
                            $row['customer_details'],
                            true
                        ) ?? [];
                        $vehicledetails = json_decode(
                            $row['vechile_details'],
                            true
                        ) ?? [];
                        
                
                        $data[] = [
                
                            "id"                => $row['ids'],
                            "ids"               => $row['ids'],
                            "booking_ids"       => $row['booking_ids'],
                            "booking_no"       => $row['agreement_group_ref_no'],
                            "agreement_no"      => $row['agreement_no'],
                            "company_name"      => $row['company_name'] ?? 'Direct Contract',
                            "agreement_date"  => $row['agreement_date'],
                            "agreement_date_format"  => $row['agreement_date_format'],
                            "customer_name"     => $row['customer_name'],
                            "customer_code"     => $row['customer_code'],
                            "mobile"            => $custdetails['customer_mobile'] ?? '-',
                
                            "vehicle_id"        => $row['vehicle_id'],
                            "vehicle_no"        => $row['vehicle_no'],
                            "category_name"     => $vehicledetails['category_name'],
                            "model_name"        => $vehicledetails['model_name'],
                            "model_id"        => $vehicledetails['model_id'],
                
                            "agreement_status"  => $row['agreement_status'],
                
                            "from_date"         => $row['service_start_date_time'],
                            "to_date"           => $row['service_end_date_time'],
                
                            "from_date_format"  => $row['from_date_format'],
                            "to_date_format"    => $row['to_date_format']
                        ];
                    }
                
                    echo json_encode([
                        "data" => $data
                    ]);
                
                break;
                
                case 'ListContractExtensions':
                    $baseQuery = "
                        SELECT *,
                            DATE_FORMAT(extend_start_date, '%d-%m-%Y %H:%i') AS extend_start_date_format,
                            DATE_FORMAT(extend_end_date, '%d-%m-%Y %H:%i') AS extend_end_date_format,DATE_FORMAT(extension_date, '%d-%m-%Y') AS extension_date_format
                        FROM  tbl_vehicle_contract_extensions
                        WHERE company_id = :company_id and agreement_ids= :agreement_ids
                    ";
                
                    $params = [
                        ':company_id' => $this->company_id,
                        ':agreement_ids' => $this->agreementid
                    ];
                
                    $baseQuery .= " ORDER BY ids DESC";
                
                    $result = $this->varPDOModelObj
                        ->selectexecuteQuery($baseQuery, $params);
                
                    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
                
                    $data = [];
                
                    foreach ($rows as $row) {
                
                        $custdetails = json_decode(
                            $row['customer_details'],
                            true
                        ) ?? [];
                        $vehicledetails = json_decode(
                            $row['vehicle_details'],
                            true
                        ) ?? [];
                        $extend_details = json_decode(
                            $row['extend_details'],
                            true
                        ) ?? [];
                        $otp_details = json_decode(
                            $row['otp_details'],
                            true
                        ) ?? [];
                        $extend_log_json = json_decode(
                            $row['extend_log_json'],
                            true
                        ) ?? [];
                        $data[] = [
                
                            "id"                => $row['ids'],
                            "ids"               => $row['ids'],
                            "booking_ids"       => $row['booking_ids'],
                            "agreement_ids"       => $row['agreement_ids'],
                            "agreement_no"      => $row['agreement_no'],
                            "extension_date"  => $row['extension_date'],
                            "extension_date_format"  => $row['extension_date_format'],
                            "customer_name"     => $custdetails['customer_name'],
                            "customer_code"     => $row['customer_code'],
                            "mobile"            => $custdetails['customer_mobile'] ?? '-',
                            "vehicle_id"        => $row['vehicle_ids'],
                            "vehicle_no"        => $vehicledetails['veh_no'],
                            "category_name"     => $vehicledetails['category_name'],
                            "model_name"        => $vehicledetails['model_name'],
                            "model_id"        => $vehicledetails['model_id'],
                            "from_date"         => $row['extend_start_date'],
                            "to_date"           => $row['extend_end_date'],
                            "from_date_format"  => $row['extend_start_date_format'],
                            "to_date_format"    => $row['extend_end_date_format'],
                            "rate_type"    => $extend_details['rate_type'],
                            "service_name"    => $extend_details['service_name'],
                            "duration"    => $extend_details['duration'],
                            "unit_price"    => $extend_details['unit_price'],
                            "min_price"    => $extend_details['min_price'],
                            "vat"    => $extend_details['vat'],
                            "total_amt"    => $extend_details['total_amt'],
                            "qtn_ref_no"    => $extend_details['qtn_ref_no'],
                            "booking_notes"    => $extend_details['booking_notes'],
                            "otp_details"    => $extend_details['otp_details']
                        ];
                    }
                
                    echo json_encode([
                        "data" => $data
                    ]);
		  	
		  	break;
		   case 'ListContractExtensionsReturn':
                  $etnQuery = "

                            SELECT * FROM (
                        
                                SELECT 
                                    0 AS sort_order,
                                    'booking' AS record_type,
                        
                                    rc.ids,
                                    rc.booking_ids,
                                    rc.ids AS agreement_ids,
                                    rc.agreement_no,
                        
                                    rc.agreement_date AS extension_date,
                                    DATE_FORMAT(rc.agreement_date, '%d-%m-%Y') AS extension_date_format,
                        
                                    rc.customer_code,
                        
                                    rc.vehicle_id AS vehicle_ids,
                        
                                    rc.service_start_date_time AS from_date,
                                    rc.service_end_date_time AS to_date,
                        
                                    DATE_FORMAT(rc.service_start_date_time, '%d-%m-%Y %H:%i') AS from_date_format,
                                    DATE_FORMAT(rc.service_end_date_time, '%d-%m-%Y %H:%i') AS to_date_format,
                        
                                    rc.customer_details,
                        
                                    rc.vechile_details AS vehicle_details,
                        
                                    rc.contract_details_json AS extend_details,
                        
                                    rc.minprice_otp_details AS otp_details,
                        
                                    rc.log_json AS extend_log_json
                        
                                FROM tbl_vehicle_rentout_contracts rc
                        
                                WHERE rc.company_id = :company_id1
                                AND rc.ids = :agreement_ids1
                        
                                UNION ALL
                        
                                SELECT 
                                    1 AS sort_order,
                                    'extension' AS record_type,
                        
                                    ext.ids,
                                    ext.booking_ids,
                                    ext.agreement_ids,
                                    ext.agreement_no,
                        
                                    ext.extension_date,
                                    DATE_FORMAT(ext.extension_date, '%d-%m-%Y') AS extension_date_format,
                        
                                    ext.customer_code,
                        
                                    ext.vehicle_ids,
                        
                                    ext.extend_start_date AS from_date,
                                    ext.extend_end_date AS to_date,
                        
                                    DATE_FORMAT(ext.extend_start_date, '%d-%m-%Y %H:%i') AS from_date_format,
                                    DATE_FORMAT(ext.extend_end_date, '%d-%m-%Y %H:%i') AS to_date_format,
                        
                                    ext.customer_details,
                        
                                    ext.vehicle_details,
                        
                                    ext.extend_details,
                        
                                    ext.otp_details,
                        
                                    ext.extend_log_json
                        
                                FROM tbl_vehicle_contract_extensions ext
                        
                                WHERE ext.company_id = :company_id2
                                AND ext.agreement_ids = :agreement_ids2
                        
                            ) AS final_data
                        
                            ORDER BY final_data.sort_order ASC, final_data.ids ASC
                        
                        ";
                        
                        $params = [
                            ':company_id1'    => $this->company_id,
                            ':agreement_ids1' => $this->agreementid,
                        
                            ':company_id2'    => $this->company_id,
                            ':agreement_ids2' => $this->agreementid
                        ];
                        
                        $result = $this->varPDOModelObj
                            ->selectexecuteQuery($etnQuery, $params);
                        
                        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
                        
                        $data = [];
                        
                        foreach ($rows as $row) {
                        
                            $custdetails = json_decode($row['customer_details'] ?? '{}', true) ?? [];
                            $vehicledetails = json_decode($row['vehicle_details'] ?? '{}', true) ?? [];
                            $extend_details = json_decode($row['extend_details'] ?? '{}', true) ?? [];
                            $otp_details = json_decode($row['otp_details'] ?? '{}', true) ?? [];
                            $extend_log_json = json_decode($row['extend_log_json'] ?? '{}', true) ?? [];
                        
                            $data[] = [
                        
                                "record_type"           => $row['record_type'],
                        
                                "id"                    => $row['ids'],
                                "ids"                   => $row['ids'],
                                "booking_ids"           => $row['booking_ids'],
                                "agreement_ids"         => $row['agreement_ids'],
                                "agreement_no"          => $row['agreement_no'],
                        
                                "extension_date"        => $row['extension_date'],
                                "extension_date_format" => $row['extension_date_format'],
                        
                                "customer_name"         => $custdetails['customer_name'] ?? '',
                                "customer_code"         => $row['customer_code'],
                                "mobile"                => $custdetails['customer_mobile'] ?? '-',
                        
                                "vehicle_id"            => $row['vehicle_ids'],
                                "vehicle_no"            => $vehicledetails['veh_no'] ?? '',
                                "category_name"         => $vehicledetails['category_name'] ?? '',
                                "model_name"            => $vehicledetails['model_name'] ?? '',
                                "model_id"              => $vehicledetails['model_id'] ?? '',
                        
                                "from_date"             => $row['from_date'],
                                "to_date"               => $row['to_date'],
                        
                                "from_date_format"      => $row['from_date_format'],
                                "to_date_format"        => $row['to_date_format'],
                        
                                "rate_type"             => $extend_details['rate_type'] ?? '',
                                "service_name"          => $extend_details['service_name'] ?? '',
                                "duration"              => $extend_details['duration'] ?? '',
                                "unit_price"            => $extend_details['unit_price'] ?? '',
                                "min_price"             => $extend_details['min_price'] ?? '',
                                "vat"                   => $extend_details['vat'] ?? '',
                                "total_amt"             => $extend_details['total_amt'] ?? '',
                                "qtn_ref_no"            => $extend_details['qtn_ref_no'] ?? '',
                                "booking_notes"         => $extend_details['booking_notes'] ?? '',
                        
                                "otp_details"           => $otp_details,
                                "extend_log_json"       => $extend_log_json
                            ];
                        }
                        
                        echo json_encode([
                            "data" => $data
                        ]);
		  	break;
		   case 'GetContractDetails':
                    try {
                        $checkCol = $this->varPDOModelObj->selectexecuteQuery("SHOW COLUMNS FROM tbl_vehicle_rentout_contracts LIKE 'violations_json'");
                        if ($checkCol && $checkCol->rowCount() == 0) {
                            $this->varPDOModelObj->executeQuery("ALTER TABLE tbl_vehicle_rentout_contracts ADD COLUMN violations_json LONGTEXT NULL");
                        }
                    } catch (\Exception $colEx) {
                        // Ignore if column check fails or column already exists
                    }

                    // 1. Customer Details
                    $result_cust = $this->varPDOModelObj->selectexecuteQuery(
                        "SELECT customer_id, customer_name, customer_mobile, customer_email, customer_addr, customer_attn,customer_cr_cpr
                         FROM customer_details 
                         WHERE customer_id = :customer_code",
                        [':customer_code' => $this->customer_code]
                    );
                    $customer = $result_cust ? $result_cust->fetch(PDO::FETCH_ASSOC) : [];

                    // 2. Fetch Contract Details First
                    $contract = [];
                    try {
                        $result_rentout = $this->varPDOModelObj->selectexecuteQuery(
                            "SELECT *, contract_details_json as book_details_json FROM tbl_vehicle_rentout_contracts WHERE ids = :agreementid",
                            [':agreementid' => $this->agreementid]
                        );
                        $contract = $result_rentout ? $result_rentout->fetch(PDO::FETCH_ASSOC) : [];
                    } catch (\Exception $exSelect) {
                        $result_rentout = $this->varPDOModelObj->selectexecuteQuery(
                            "SELECT * FROM tbl_vehicle_rentout_contracts WHERE ids = :agreementid",
                            [':agreementid' => $this->agreementid]
                        );
                        $contract = $result_rentout ? $result_rentout->fetch(PDO::FETCH_ASSOC) : [];
                    }

                    // 3. Resolve Target Vehicle ID and Category ID for current contract vehicle
                    $targetVehId = !empty($contract['new_vehicle_id']) ? $contract['new_vehicle_id'] : (!empty($contract['vehicle_id']) ? $contract['vehicle_id'] : $this->vehicleid);
                    $targetVehNo = !empty($contract['new_vehicle_no']) ? $contract['new_vehicle_no'] : (!empty($contract['vehicle_no']) ? $contract['vehicle_no'] : '');
                    $targetModelId = !empty($contract['new_model_id']) ? $contract['new_model_id'] : (!empty($contract['model_id']) ? $contract['model_id'] : $this->model_ids);

                    $whereConds = ["v.ids = :veh_id"];
                    $queryParams = [':veh_id' => $targetVehId];

                    if (!empty($targetVehNo)) {
                        $whereConds[] = "v.vehicle_number = :veh_no";
                        $queryParams[':veh_no'] = $targetVehNo;
                    }
                    if (!empty($this->vehicleid) && $this->vehicleid != $targetVehId) {
                        $whereConds[] = "v.ids = :alt_id";
                        $queryParams[':alt_id'] = $this->vehicleid;
                    }

                    $whereSql = "WHERE " . implode(" OR ", $whereConds);

                    $result_vehicle = $this->varPDOModelObj->selectexecuteQuery(
                        "SELECT 
                            v.ids, 
                            COALESCE(v.category_id, m.category_id) AS category_id, 
                            v.model_id, 
                            v.vehicle_number,
                            v.chassis_number, 
                            v.vehicle_year, 
                            v.vehicle_color,
                            c.category_name, 
                            b.brand_name, 
                            m.modal_name AS model_names,
                            v.next_insurance_date, 
                            v.next_maintenance_date, 
                            v.next_passing_date,
                            DATE_FORMAT(v.next_insurance_date, '%d/%m/%Y') AS formatted_next_insurance_date,
                            DATE_FORMAT(v.next_maintenance_date, '%d/%m/%Y') AS formatted_next_maintenance_date,
                            DATE_FORMAT(v.next_passing_date, '%d/%m/%Y') AS formatted_next_passing_date,
                            v.image_json AS vehicle_images
                         FROM tbl_vehicles v
                         LEFT JOIN tbl_vehicle_model m ON m.ids = v.model_id
                         LEFT JOIN tbl_vehicle_category c ON c.ids = COALESCE(v.category_id, m.category_id)
                         LEFT JOIN tbl_vehicle_brand b ON b.ids = v.brand_id
                         {$whereSql}",
                        $queryParams
                    );
                    $vehicle = $result_vehicle ? $result_vehicle->fetch(PDO::FETCH_ASSOC) : [];

                    if (empty($vehicle['category_id'])) {
                        if (!empty($contract['new_category_id'])) {
                            $vehicle['category_id'] = $contract['new_category_id'];
                        } elseif (!empty($contract['category_id'])) {
                            $vehicle['category_id'] = $contract['category_id'];
                        } elseif (!empty($targetModelId)) {
                            $catModelStmt = $this->varPDOModelObj->selectexecuteQuery(
                                "SELECT category_id FROM tbl_vehicle_model WHERE ids = :mids",
                                [':mids' => $targetModelId]
                            );
                            if ($catModelStmt && $catModelRow = $catModelStmt->fetch(PDO::FETCH_ASSOC)) {
                                $vehicle['category_id'] = $catModelRow['category_id'];
                            }
                        }
                    }
                   
                    $result_model = $this->varPDOModelObj->selectexecuteQuery(
                        "SELECT price_json FROM tbl_vehicle_model WHERE ids = :model_ids",
                        [':model_ids' => $targetModelId]
                    );
                    $model = $result_model ? $result_model->fetch(PDO::FETCH_ASSOC) : [];
                    $price_list = [];
                    if (!empty($model['price_json'])) {
                        $price_list = json_decode($model['price_json'], true);
                    }
                
                     $result_extend = $this->varPDOModelObj->selectexecuteQuery(
                        "SELECT ids,extend_end_date FROM  tbl_vehicle_contract_extensions 
                         WHERE agreement_ids = :agreementid order by ids desc limit 1",
                        [':agreementid' => $this->agreementid]
                    );
                    $extend_row = $result_extend->fetch(PDO::FETCH_ASSOC);

                    $extend_end_date = $extend_row['extend_end_date'] ?? '';
                    // 5. Final Response
                    $response = [
                        'customer' => $customer ?: [],
                        'vehicle'  => $vehicle ?: [],
                        'contract' => $contract ?: [],
                        'price_list' => $price_list,
                        'source'   => 'agreement' ?? 'none',
                        'extend_end_date' => $extend_end_date,
                    ];
                
                    echo json_encode($response);
                    break;
                    case 'extendContractGeneration':
                        $log_details = [
                                    "user_id" => $this->user_id,
                                    "datetime" => date('Y-m-d H:i:s')
                                ];
                        
                        $json_log = json_encode($log_details);
                        $extension_date=date('Y-m-d');
                       try {
                      
                                $this->ReturnData = $this->varPDOModelObj->executeQuery(
                                    $var[1],
                                    [ ':company_id' => $this->company_id,
                                        ':agreement_ids' => $this->agreementid,
                                        ':agreement_no' => $this->agreement_no,
                                        ':booking_ids' => $this->booking_ids,
                                        ':customer_code' =>
                                            $this->customer_data['customer_code'] ?? '',
                                        ':vehicle_id' =>
                                            $this->vehicle_data['vehicle_id'] ?? 0,
                                        ':customer_details' =>
                                            json_encode($this->customer_data ?? []),
                                         ':vechile_details' =>
                                            json_encode($this->vehicle_data ?? []),
                                        ':extension_date' => $extension_date,
                                        ':service_start' =>
                                            $this->contract_details['period_from'] ?? null,
                                        ':service_end' =>
                                            $this->contract_details['period_to'] ?? null,
                                        ':contract_details' =>
                                            json_encode($this->contract_details ?? []),
                                         ':otp_details' =>
                                            json_encode(
                                                $this->contract_details['otp_details'] ?? []
                                            ),
                                        ':log_details' => $json_log
                                    ]
                                );
                             if ($this->ReturnData) {

                                    $updateBookingQuery = "
                                        UPDATE tbl_vehicle_bookings
                                        SET book_status = 'Extended'
                                        WHERE ids = :booking_id
                                    ";
                                
                                    $updateBookingParams = [
                                
                                        ':booking_id' => $this->booking_ids
                                
                                    ];
                                
                                    $this->varPDOModelObj->executeQuery(
                                        $updateBookingQuery,
                                        $updateBookingParams
                                    );
                                     $updateContractQuery = "
                                        UPDATE  tbl_vehicle_rentout_contracts
                                        SET agreement_status = 'Extended'
                                        WHERE ids = :agreement_id
                                    ";
                                
                                    $updateContractParams = [
                                
                                        ':agreement_id' => $this->agreementid
                                
                                    ];
                                
                                    $this->varPDOModelObj->executeQuery(
                                        $updateContractQuery,
                                        $updateContractParams
                                    );
                                     
                                    $duration   = (float)($this->contract_details['duration'] ?? 0);
                                    $unitPrice  = (float)($this->contract_details['unit_price'] ?? 0);
                                    $vatPercent = (float)($this->contract_details['vat'] ?? 0);
                                
                                    $extensionFee = $duration * $unitPrice;
                                    $vatAmount = ($extensionFee * $vatPercent) / 100;
                                
                                    // Insert Rental Fee row
                                    $sqlInsert = "
                                        INSERT INTO  tbl_customer_ledger
                                        (
                                            customer_code,
                                            quotation_no,
                                            booking_no,
                                            trans_date,
                                            trans_type,
                                            debit,
                                            description,
                                            user_id,
                                            company_id,
                                            created_at,
                                            booking_ids,
                                            contract_ids,
                                            agreement_no
                                        )
                                        VALUES
                                        (
                                            :customer_code,
                                            :quotation_number,
                                            :booking_no,
                                            :trans_date,
                                            :ledger_name,
                                            :amount,
                                            :description,
                                            :user_ids,
                                            :company_ids,
                                            :trans_date_time,
                                            :booking_ids,
                                            :contract_ids,
                                            :agreement_no
                                        )
                                    ";
                               
                                    // Rental Fee
                                    $params_rental =[
                                        ':customer_code'          => $this->customer_data['customer_code'],
                                        ':quotation_number'       => $this->contract_details['qtn_ref_no'],
                                        ':booking_no' => $this->booking_ref_no,
                                        ':trans_date'            => date('Y-m-d'),
                                        ':ledger_name'            => $this->service_name,
                                        ':amount'            =>  $extensionFee,
                                        ':description'            => 'Auto Post Extension Fee',
                                        ':user_ids'            =>  $this->user_id,
                                        ':company_ids'            =>  $this->company_id,
                                        ':trans_date_time'            => date('Y-m-d H:i:s'),
                                        ':booking_ids'            => $this->booking_ids,
                                        ':agreement_no'           => $this->agreement_no,
                                        ':contract_ids'           =>  $this->agreementid
                                        
                                    ];
                                $this->varPDOModelObj->executeQuery($sqlInsert, $params_rental);
                                    // VAT Row
                                    if ($vatAmount > 0) {
                                
                                        $params_vat =[
                                        ':customer_code'          => $this->customer_data['customer_code'],
                                        ':quotation_number'       => $this->contract_details['qtn_ref_no'],
                                        ':booking_no' => $this->booking_ref_no,
                                        ':trans_date'            => date('Y-m-d'),
                                        ':ledger_name'            => 'VAT',
                                        ':amount'            =>  $vatAmount,
                                        ':description'            => 'Auto Post VAT of Extension Fee',
                                        ':user_ids'            =>  $this->user_id,
                                        ':company_ids'            =>  $this->company_id,
                                        ':trans_date_time'            => date('Y-m-d H:i:s'),
                                        ':booking_ids'            => $this->booking_ids,
                                        ':agreement_no'           => $this->agreement_no,
                                        ':contract_ids'           =>  $this->agreementid
                                        
                                    ];
                                     $this->varPDOModelObj->executeQuery($sqlInsert, $params_vat);
                                    }
                                
                                
                                }
                                echo json_encode([
                                    "status" => true,
                                    "message" => "Saved successfully",
                                    "data" => $this->ReturnData
                                ]);
                        
                                Logger::ActivityLog(
                                    'VehiclesContractListController',
                                    "extendContractGeneration",
                                    [$this->ReturnData]
                                );
                        
                            } catch (Exception $e) {
                        
                                echo json_encode([
                                    "status" => false,
                                    "message" => $e->getMessage()
                                ]);
                            }
                            
                        
                        break;
            case 'delete_extension':

                // 1. Fetch extension details to reverse the ledger charges
                $extQry = $this->varPDOModelObj->selectexecuteQuery(
                    "SELECT * FROM tbl_vehicle_contract_extensions WHERE ids = :extend_ids",
                    [':extend_ids' => $this->extend_ids]
                );
                $extData = $extQry->fetch(PDO::FETCH_ASSOC);

                if ($extData) {
                    $extendDetails = json_decode($extData['extend_details'] ?? '{}', true);
                    $duration   = (float)($extendDetails['duration'] ?? 0);
                    $unitPrice  = (float)($extendDetails['unit_price'] ?? 0);
                    $vatPercent = (float)($extendDetails['vat'] ?? 0);

                    $extensionFee = $duration * $unitPrice;
                    $vatAmount = ($extensionFee * $vatPercent) / 100;

                    $custCode = $extData['customer_code'];
                    $agreementNo = $extData['agreement_no'];
                    $bookingIds = $extData['booking_ids'];
                    $agreementIds = $extData['agreement_ids'];

                    $agreeQry = $this->varPDOModelObj->selectexecuteQuery(
                        "SELECT quotation_number FROM tbl_vehicle_rentout_contracts WHERE ids = :agreement_ids",
                        [':agreement_ids' => $agreementIds]
                    );
                    $agreeData = $agreeQry->fetch(PDO::FETCH_ASSOC);
                    $quotationNo = $agreeData['quotation_number'] ?? '';
                    $bookingNo   = '';
                    
                    $userId = $_SESSION['user_id'] ?? 1;
                    $companyId = $_SESSION['company_id'] ?? 1;
                    $transDate = date('Y-m-d');
                    $transDateTime = date('Y-m-d H:i:s');
                    
                    if ($extensionFee > 0) {
                        $this->varPDOModelObj->executeQuery("
                            INSERT INTO tbl_customer_ledger
                            (customer_code, quotation_no, booking_no, trans_date, trans_type, payment_method, debit, credit, description, user_id, company_id, created_at, booking_ids, contract_ids, agreement_no)
                            VALUES
                            (:customer_code, :quotation_no, :booking_no, :trans_date, 'Extension Deleted', 'N/A', 0, :credit, :description, :user_id, :company_id, :created_at, :booking_ids, :contract_ids, :agreement_no)
                        ", [
                            ':customer_code' => $custCode,
                            ':quotation_no' => $quotationNo,
                            ':booking_no' => $bookingNo,
                            ':trans_date' => $transDate,
                            ':credit' => $extensionFee,
                            ':description' => 'Reversal of Extension Amount (Agreement No: ' . $agreementNo . ')',
                            ':user_id' => $userId,
                            ':company_id' => $companyId,
                            ':created_at' => $transDateTime,
                            ':booking_ids' => $bookingIds,
                            ':contract_ids' => $agreementIds,
                            ':agreement_no' => $agreementNo
                        ]);
                    }
                    
                    if ($vatAmount > 0) {
                        $this->varPDOModelObj->executeQuery("
                            INSERT INTO tbl_customer_ledger
                            (customer_code, quotation_no, booking_no, trans_date, trans_type, payment_method, debit, credit, description, user_id, company_id, created_at, booking_ids, contract_ids, agreement_no)
                            VALUES
                            (:customer_code, :quotation_no, :booking_no, :trans_date, 'Extension Deleted VAT', 'N/A', 0, :credit, :description, :user_id, :company_id, :created_at, :booking_ids, :contract_ids, :agreement_no)
                        ", [
                            ':customer_code' => $custCode,
                            ':quotation_no' => $quotationNo,
                            ':booking_no' => $bookingNo,
                            ':trans_date' => $transDate,
                            ':credit' => $vatAmount,
                            ':description' => 'Reversal of Extension VAT (Agreement No: ' . $agreementNo . ')',
                            ':user_id' => $userId,
                            ':company_id' => $companyId,
                            ':created_at' => $transDateTime,
                            ':booking_ids' => $bookingIds,
                            ':contract_ids' => $agreementIds,
                            ':agreement_no' => $agreementNo
                        ]);
                    }
                }
             
               $deleteExtensionQry = $this->varPDOModelObj->executeQuery(
                    "DELETE FROM tbl_vehicle_contract_extensions
                     WHERE ids = :extend_ids",
                    [
                        ':extend_ids' => $this->extend_ids
                    ]
                );
                
                /* get agreement extension count after delete */
                $countQry = $this->varPDOModelObj->selectexecuteQuery(
                    "SELECT COUNT(ids) AS total_count
                     FROM tbl_vehicle_contract_extensions
                     WHERE agreement_ids = :agreement_ids",
                    [
                        ':agreement_ids' => $this->agreementid
                    ]
                );
                
                $countRow = $countQry->fetch(PDO::FETCH_ASSOC);
                
                if (($countRow['total_count'] ?? 0) == 0) {

            $statusQry = $this->varPDOModelObj->selectexecuteQuery(
                "SELECT agreement_status
                 FROM tbl_vehicle_rentout_contracts
                 WHERE ids = :agreement_ids",
                [
                    ':agreement_ids' => $this->agreementid
                ]
            );
        
            $statusRow = $statusQry->fetch(PDO::FETCH_ASSOC);
        
            if (($statusRow['agreement_status'] ?? '') == 'Extended') {
        
                $this->varPDOModelObj->executeQuery(
                    "UPDATE tbl_vehicle_rentout_contracts
                     SET agreement_status = 'Rentout'
                     WHERE ids = :agreement_ids",
                    [
                        ':agreement_ids' => $this->agreementid
                    ]
                );
                 $this->varPDOModelObj->executeQuery(
                    "UPDATE  tbl_vehicle_bookings
                     SET book_status = 'Rentout'
                     WHERE ids = :booking_ids",
                    [
                        ':booking_ids' => $this->booking_ids
                    ]
                );
            }
        }
              
                
                echo json_encode([
                    "status" => true,
                    "message" => "Extension deleted successfully"
                ]);
                Logger::ActivityLog(
                    'VehiclesContractListController',
                    "delete_extension",
                    [$this->agreementid]
                );
            break;
           
            case 'LoadTermsCondition':

               
              $result_tc = $this->varPDOModelObj->selectexecuteQuery(
                            "SELECT * FROM tbl_terms_and_condition_contract WHERE company_id = :company_id ORDER BY ids DESC",
                            [':company_id' => $this->company_id]
                        );
                
                $terms = $result_tc->fetchAll(PDO::FETCH_ASSOC);
                 $response = [
                        'data' => $terms ?: []
                    ];
                
                    echo json_encode($response);
            
            break;
             case 'LoadTermsConditionToEditor':

                 $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[3],
                    $this->params[3]
                );
            
                $result = json_decode($this->ReturnData, true);
            
                $htmlContent = $result['data'][0]['terms_condition'] ?? '';
            
                echo json_encode([
                    'status' => true,
                    'html'   => $htmlContent
                ]);
            
            break;
             case 'deleteTermsCondition':
                $this->ReturnData = $this->varPDOModelObj->DeleteFromTable(
                    $var[4],
                    $this->params[4]
                );
            
             
                $result = json_decode($this->ReturnData, true);
            
                echo json_encode([
                    "status"  => $result['status'],
                    "message" => $result['message'],
                    "rows_affected" => $result['data']['rows_affected'] ?? 0
                ]);

            break;
            case 'SaveTermsCondition':

                $this->ReturnData = $this->varPDOModelObj->AddToTable(
                    "tbl_terms_and_condition_contract",
                    [
                        't_c_name' => $this->t_c_name,
                        'terms_condition' => $this->terms_condition,
                        'company_id' => $this->company_id,
                        'user_id' => $this->user_id,
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                );
            
                echo json_encode([
                    "status" => true,
                    "message" => "Saved successfully",
                    "data" => $this->ReturnData
                ]);
            
            break;
            
            case 'checkcontarctgenerate':

                $result = $this->varPDOModelObj->selectexecuteQuery(
                    "SELECT ids 
                     FROM tbl_vehicle_rentout_contracts 
                     WHERE booking_ids = :book_ids",
                    [':book_ids' => $this->bookingid]
                );
            
                if ($result->rowCount() >= 1) {
            
                    $response = [
                        'status'  => true,
                        'message' => 'Contract exists'
                    ];
            
                } else {
            
                    $response = [
                        'status'  => false,
                        'message' => 'Contract not exists'
                    ];
            
                }
            
                echo json_encode($response);
            
            break;
            case 'GetSignDetails':
                    $result_sign = $this->varPDOModelObj->selectexecuteQuery(
                            "SELECT hirer_signature,hirer_name,hirer_signature_date,hier_signature_status,delivered_signature_status,delivered_signature,delivered_signatory,delivered_signature_date FROM  tbl_vehicle_rentout_contracts WHERE booking_ids = :book_ids",
                            [':book_ids' => $this->bookingid]
                        );
                
                $sign_details = $result_sign->fetchAll(PDO::FETCH_ASSOC);
                 $response = [
                        'data' => $sign_details ?: []
                    ];
                
                    echo json_encode($response);
            break;
              case 'SaveSignature':
                
                    foreach ($this->selectedBookingIds as $bookids) {

                        $updateFields = [];
                        $params = [];
                    
                        $now = date('Y-m-d H:i:s');
                    
                        // ====================================
                        // HIRER SIGNATURE
                        // ====================================
                    
                        if (!empty($this->hirer_signature)) {
                    
                            $hirer_signature_path =
                                'uploads/signatures/hirer_' .
                                $bookids . '_' . time() . '.png';
                    
                            $hirer_signature = str_replace(
                                'data:image/png;base64,',
                                '',
                                $this->hirer_signature
                            );
                    
                            $hirer_signature = str_replace(
                                ' ',
                                '+',
                                $hirer_signature
                            );
                    
                            file_put_contents(
                                $hirer_signature_path,
                                base64_decode($hirer_signature)
                            );
                    
                            $updateFields[] =
                                "hirer_signature = :hirer_signature";
                    
                            $updateFields[] =
                                "hirer_name = :hirer_name";
                    
                            $updateFields[] =
                                "hirer_signature_date = :hirer_signature_date";
                    
                            $updateFields[] =
                                "hier_signature_status = :hirer_sign_status";
                    
                            $updateFields[] =
                                "hirer_signed_ip = :hirer_signed_ip";
                    
                            $updateFields[] =
                                "hirer_signed_device = :hirer_signed_device";
                    
                            $params[':hirer_signature'] =
                                $hirer_signature_path;
                    
                            $params[':hirer_name'] =
                                $this->hirer_name;
                    
                            $params[':hirer_signature_date'] =
                                $now;
                    
                            $params[':hirer_sign_status'] =
                                'Yes';
                    
                            $params[':hirer_signed_ip'] =
                                $_SERVER['REMOTE_ADDR'];
                    
                            $params[':hirer_signed_device'] =
                                $_SERVER['HTTP_USER_AGENT'];
                        }
                    
                        // ====================================
                        // DELIVERY SIGNATURE
                        // ====================================
                    
                        if (!empty($this->delivery_signature)) {
                    
                            $delivery_signature_path =
                                'uploads/signatures/delivery_' .
                                $bookids . '_' . time() . '.png';
                    
                            $delivery_signature = str_replace(
                                'data:image/png;base64,',
                                '',
                                $this->delivery_signature
                            );
                    
                            $delivery_signature = str_replace(
                                ' ',
                                '+',
                                $delivery_signature
                            );
                    
                            file_put_contents(
                                $delivery_signature_path,
                                base64_decode($delivery_signature)
                            );
                    
                            $updateFields[] =
                                "delivered_signature = :delivery_signature";
                    
                            $updateFields[] =
                                "delivered_signatory = :delivery_name";
                    
                            $updateFields[] =
                                "delivered_signature_date = :delivery_signature_date";
                    
                            $updateFields[] =
                                "delivered_signature_status = :del_sign_status";
                    
                            $updateFields[] =
                                "delivered_signed_ip = :del_signed_ip";
                    
                            $updateFields[] =
                                "delivered_signed_device = :del_signed_device";
                    
                            $params[':delivery_signature'] =
                                $delivery_signature_path;
                    
                            $params[':delivery_name'] =
                                $this->delivery_name;
                    
                            $params[':delivery_signature_date'] =
                                $now;
                    
                            $params[':del_sign_status'] =
                                'Yes';
                    
                            $params[':del_signed_ip'] =
                                $_SERVER['REMOTE_ADDR'];
                    
                            $params[':del_signed_device'] =
                                $_SERVER['HTTP_USER_AGENT'];
                        }
                    
                        // ====================================
                        // NOTHING TO UPDATE
                        // ====================================
                    
                        if (empty($updateFields)) {
                            continue;
                        }
                    
                        // ====================================
                        // FINAL QUERY
                        // ====================================
                    
                    
                      
                        $query = "
                            UPDATE tbl_vehicle_rentout_contracts
                            SET " . implode(', ', $updateFields) . "
                            WHERE booking_ids = :book_id
                        ";
                    
                        $params[':book_id'] = $bookids;
                    
                        $this->ReturnData =
                            $this->varPDOModelObj
                                 ->executeQuery($query, $params);
                          if ($this->ReturnData) {

                            $updateBookingQuery = "
                                UPDATE tbl_vehicle_bookings
                                SET book_status = 'Confirmed'
                                WHERE ids = :booking_id
                            ";
                        
                            $updateBookingParams = [
                        
                                ':booking_id' => $bookids
                        
                            ];
                        
                            $this->varPDOModelObj->executeQuery(
                                $updateBookingQuery,
                                $updateBookingParams
                            );
                        
                        }
                    }
                
                    echo json_encode([
                        "status" => true,
                        "message" => "Signature saved successfully"
                    ]);
                
                break;
            case 'returnContractGeneration':
                
                        $bookids=$this->booking_ids;
                       
                        $now = date('Y-m-d H:i:s');
                    
                        // ====================================
                        // Receiver SIGNATURE
                        // ====================================
                    
                        if (!empty($this->ReceiverSign)) {
                    
                            $receiver_signature_path =
                                'uploads/signatures/receiver_' .
                                $bookids . '_' . time() . '.png';
                    
                            $receiver_signature = str_replace(
                                'data:image/png;base64,',
                                '',
                                $this->ReceiverSign
                            );
                    
                            $receiver_signature = str_replace(
                                ' ',
                                '+',
                                $receiver_signature
                            );
                    
                            file_put_contents(
                                $receiver_signature_path,
                                base64_decode($receiver_signature)
                            );
                    
                           
                            $receiver_signature =
                                $receiver_signature_path;
                    
                            $receiver_name=
                                $this->receiver_name;
                    
                            $receiver_signature_date =
                                $now;
                    
                            
                            $receiver_signed_ip =
                                $_SERVER['REMOTE_ADDR'];
                    
                            $receiver_signed_device =
                                $_SERVER['HTTP_USER_AGENT'];
                        }
                    
                      $returnlog_details = [
                                    "user_id" => $this->user_id,
                                    "datetime" => date('Y-m-d H:i:s')
                                ];
                        
                        $returnjson_log = json_encode($returnlog_details);
                        $return_date=date('Y-m-d');
                        $returnvehicleimages_upload = json_encode($this->returnvehicleimages);
                        
                        $rawViolations = is_array($this->violations) ? $this->violations : json_decode($this->violations ?? '[]', true);
                        $formattedViolations = [];

                        if (is_array($rawViolations)) {
                            $fallbackVehNo = $this->vehicle_number ?? '';
                            if (empty($fallbackVehNo) && !empty($this->vehicle_ids)) {
                                try {
                                    $stmtV = $this->varPDOModelObj->selectexecuteQuery("SELECT vehicle_number FROM tbl_vehicles WHERE ids = :vids", [':vids' => $this->vehicle_ids]);
                                    if ($stmtV) {
                                        $rowV = $stmtV->fetch(PDO::FETCH_ASSOC);
                                        $fallbackVehNo = $rowV['vehicle_number'] ?? '';
                                    }
                                } catch (\Exception $eV) {}
                            }

                            foreach ($rawViolations as $v) {
                                $vTitle = trim($v['title'] ?? '');
                                $vFee = floatval($v['fee'] ?? 0);
                                $vRemarks = trim($v['remarks'] ?? '');
                                $vDate = !empty($v['violation_date']) ? $v['violation_date'] : (!empty($v['date']) ? $v['date'] : date('Y-m-d'));
                                $vVehId = !empty($v['vehicle_id']) ? $v['vehicle_id'] : ($this->vehicle_ids ?? '');
                                $vVehNo = !empty($v['vehicle_number']) ? $v['vehicle_number'] : $fallbackVehNo;
                                $vLedgerId = !empty($v['ledger_id']) ? intval($v['ledger_id']) : 0;

                                if (empty($vLedgerId) && !empty($vTitle)) {
                                    try {
                                        $stmtL = $this->varPDOModelObj->selectexecuteQuery("SELECT ids FROM tbl_ledger_heads WHERE head_name = :hname", [':hname' => $vTitle]);
                                        if ($stmtL) {
                                            $rowL = $stmtL->fetch(PDO::FETCH_ASSOC);
                                            $vLedgerId = $rowL['ids'] ?? 0;
                                        }
                                    } catch (\Exception $eL) {}
                                }

                                if ($vTitle !== '' || $vFee > 0 || $vRemarks !== '') {
                                    $formattedViolations[] = [
                                        'vehicle_id'     => $vVehId,
                                        'vehicle_number' => $vVehNo,
                                        'violation_date' => $vDate,
                                        'title'          => $vTitle,
                                        'ledger_id'      => $vLedgerId,
                                        'fee'            => $vFee,
                                        'remarks'        => $vRemarks
                                    ];
                                }
                            }
                        }

                        $violations_json_data = json_encode($formattedViolations);
                          
                       try {
                                try {
                                    $checkCol = $this->varPDOModelObj->selectexecuteQuery("SHOW COLUMNS FROM tbl_vehicle_rentout_contracts LIKE 'violations_json'");
                                    if ($checkCol && $checkCol->rowCount() == 0) {
                                        $this->varPDOModelObj->executeQuery("ALTER TABLE tbl_vehicle_rentout_contracts ADD COLUMN violations_json LONGTEXT NULL");
                                    }
                                } catch (\Exception $colEx) {
                                    // Ignore if column check fails or column already exists
                                }

                                $updateContractQuery = "
                                        UPDATE  tbl_vehicle_rentout_contracts
                                        SET agreement_status = 'Returned',return_log_json=:return_log,km_in=:km_in,km_used=:km_used,return_date=:return_date,received_by=:received_by,receiver_name=:receiver_name,receiver_signature=:receiver_signature,receiver_signature_datetime=:receiver_signature_datetime,receiver_signed_device=:receiver_signed_device,receiver_signed_ip=:receiver_signed_ip,vehicle_return_images=:vehicle_return_images,violations_json=:violations_json
                                        WHERE ids = :agreement_id
                                    ";
                                     $updateContractParams = [
                                
                                        ':return_log' => $returnjson_log,
                                        ':km_in' => $this->km_in,
                                        ':km_used' => $this->km_used,
                                        ':return_date' => $this->return_date_in,
                                        ':received_by' => $this->user_id,
                                        ':receiver_name' => $receiver_name,
                                        ':receiver_signature' => $receiver_signature,
                                         ':receiver_signature_datetime' => $receiver_signature_date,
                                          ':receiver_signed_device' => $receiver_signed_device,
                                           ':receiver_signed_ip' => $receiver_signed_ip,
                                          ':vehicle_return_images' => $returnvehicleimages_upload,
                                          ':violations_json' => $violations_json_data,
                                            ':agreement_id' => $this->agreementid
                                
                                    ];
                                
                                    $this->ReturnData = $this->varPDOModelObj->executeQuery(
                                        $updateContractQuery,
                                        $updateContractParams
                                    );
                               
                             if ($this->ReturnData) {
                                 
                                     if (!empty($formattedViolations)) {
                                             try {
                                                 $this->varPDOModelObj->executeQuery("ALTER TABLE tbl_customer_ledger MODIFY trans_type VARCHAR(100) NOT NULL");
                                             } catch (\Exception $exTrans) {}

                                             $stmtContractInfo = $this->varPDOModelObj->selectexecuteQuery(
                                                 "SELECT 
                                                     c.quotation_number AS contract_qtn, 
                                                     c.booking_ids, 
                                                     c.agreement_no, 
                                                     c.customer_code AS contract_cust_code,
                                                     b.booking_no AS booking_no_str,
                                                     b.quotation_number AS booking_qtn_str,
                                                     b.customer_code AS booking_cust_code
                                                  FROM tbl_vehicle_rentout_contracts c
                                                  LEFT JOIN tbl_vehicle_bookings b ON b.ids = c.booking_ids
                                                  WHERE c.ids = :agreementid",
                                                 [':agreementid' => $this->agreementid]
                                             );
                                             $contractInfoRow = $stmtContractInfo ? $stmtContractInfo->fetch(PDO::FETCH_ASSOC) : [];

                                             $ledgerCustCode = !empty($this->customer_code) ? $this->customer_code : ($contractInfoRow['contract_cust_code'] ?? ($contractInfoRow['booking_cust_code'] ?? ''));
                                             $ledgerQtnNo    = !empty($contractInfoRow['contract_qtn']) ? $contractInfoRow['contract_qtn'] : (!empty($contractInfoRow['booking_qtn_str']) ? $contractInfoRow['booking_qtn_str'] : ($contractInfoRow['agreement_no'] ?? ''));
                                             $ledgerBookNo   = !empty($contractInfoRow['booking_no_str']) ? $contractInfoRow['booking_no_str'] : (!empty($this->booking_ref_no) ? $this->booking_ref_no : ($contractInfoRow['booking_ids'] ?? ''));
                                             $ledgerAgreeNo  = !empty($this->agreement_no) ? $this->agreement_no : ($contractInfoRow['agreement_no'] ?? '');

                                             foreach ($formattedViolations as $violation) {
                                                 $vTitle = trim($violation['title'] ?? '');
                                                 $vFee = floatval($violation['fee'] ?? 0);
                                                 $vRemarks = trim($violation['remarks'] ?? '');
                                                 $vDateStr = !empty($violation['violation_date']) ? date('Y-m-d', strtotime($violation['violation_date'])) : (!empty($this->return_date_in) ? date('Y-m-d', strtotime($this->return_date_in)) : date('Y-m-d'));
                                                 $transTypeStr = !empty($vTitle) ? $vTitle : 'Vehicle Violation';

                                                 if ($vTitle !== '' || $vFee > 0 || $vRemarks !== '') {
                                                     $vDesc = 'Vehicle Violation: ' . $vTitle;
                                                     if (!empty($vRemarks)) {
                                                         $vDesc .= ' (Remarks: ' . $vRemarks . ')';
                                                     }
                                                     $vDesc .= ' (Agreement No: ' . $ledgerAgreeNo . ')';

                                                     $ledgerSql = "
                                                         INSERT INTO tbl_customer_ledger
                                                         (
                                                             customer_code,
                                                             quotation_no,
                                                             booking_no,
                                                             trans_date,
                                                             trans_type,
                                                             payment_method,
                                                             debit,
                                                             credit,
                                                             ref_no,
                                                             description,
                                                             user_id,
                                                             company_id,
                                                             created_at,
                                                             booking_ids,
                                                             contract_ids,
                                                             agreement_no
                                                         )
                                                         VALUES
                                                         (
                                                             :customer_code,
                                                             :quotation_no,
                                                             :booking_no,
                                                             :trans_date,
                                                             :trans_type,
                                                             'N/A',
                                                             :debit,
                                                             :credit,
                                                             :ref_no,
                                                             :description,
                                                             :user_id,
                                                             :company_id,
                                                             :created_at,
                                                             :booking_ids,
                                                             :contract_ids,
                                                             :agreement_no
                                                         )
                                                     ";

                                                     $ledgerParams = [
                                                         ':customer_code' => $ledgerCustCode,
                                                         ':quotation_no'  => $ledgerQtnNo,
                                                         ':booking_no'    => $ledgerBookNo,
                                                         ':trans_date'    => $vDateStr,
                                                         ':trans_type'    => $transTypeStr,
                                                         ':debit'         => $vFee,
                                                         ':credit'        => 0,
                                                         ':ref_no'        => $ledgerAgreeNo,
                                                         ':description'   => $vDesc,
                                                         ':user_id'       => $this->user_id ?? 1,
                                                         ':company_id'    => $this->company_id ?? 1,
                                                         ':created_at'    => date('Y-m-d H:i:s'),
                                                         ':booking_ids'   => $ledgerBookNo,
                                                         ':contract_ids'  => $this->agreementid ?? 0,
                                                         ':agreement_no'  => $ledgerAgreeNo
                                                     ];

                                                     try {
                                                         $this->varPDOModelObj->executeQuery($ledgerSql, $ledgerParams);
                                                     } catch (\Exception $ledgerEx) {
                                                         $fallbackLedgerSql = "
                                                             INSERT INTO tbl_customer_ledger
                                                             (
                                                                 customer_code,
                                                                 quotation_no,
                                                                 booking_no,
                                                                 trans_date,
                                                                 trans_type,
                                                                 payment_method,
                                                                 debit,
                                                                 credit,
                                                                 ref_no,
                                                                 description,
                                                                 user_id,
                                                                 company_id,
                                                                 created_at
                                                             )
                                                             VALUES
                                                             (
                                                                 :customer_code,
                                                                 :quotation_no,
                                                                 :booking_no,
                                                                 :trans_date,
                                                                 :trans_type,
                                                                 'N/A',
                                                                 :debit,
                                                                 :credit,
                                                                 :ref_no,
                                                                 :description,
                                                                 :user_id,
                                                                 :company_id,
                                                                 :created_at
                                                             )
                                                         ";

                                                         $fallbackParams = [
                                                             ':customer_code' => $ledgerCustCode,
                                                             ':quotation_no'  => $ledgerQtnNo,
                                                             ':booking_no'    => $ledgerBookNo,
                                                             ':trans_date'    => $vDateStr,
                                                             ':trans_type'    => $transTypeStr,
                                                             ':debit'         => $vFee,
                                                             ':credit'        => 0,
                                                             ':ref_no'        => $ledgerAgreeNo,
                                                             ':description'   => $vDesc,
                                                             ':user_id'       => $this->user_id ?? 1,
                                                             ':company_id'    => $this->company_id ?? 1,
                                                             ':created_at'    => date('Y-m-d H:i:s')
                                                         ];

                                                         $this->varPDOModelObj->executeQuery($fallbackLedgerSql, $fallbackParams);
                                                     }
                                                 }
                                             }
                                     }
                               
                                    $sqlOldStatus = "
                                        SELECT vehicle_status
                                        FROM tbl_vehicles
                                        WHERE ids = :vehicle_id
                                    ";
                                
                                    $stmtOldStatus = $this->varPDOModelObj->selectexecuteQuery($sqlOldStatus, [
                                        ':vehicle_id' => $this->vehicle_ids
                                    ]);
                                
                                    $vehicleInfo = $stmtOldStatus->fetch(PDO::FETCH_ASSOC);
                                
                                    $oldStatus = $vehicleInfo['vehicle_status'] ?? 'Rentout';
                                    
                                    $updateBookingQuery = "
                                        UPDATE tbl_vehicle_bookings
                                        SET book_status = 'Returned'
                                        WHERE ids = :booking_id
                                    ";
                                
                                    $updateBookingParams = [
                                
                                        ':booking_id' => $this->booking_ids
                                
                                    ];
                                
                                    $this->varPDOModelObj->executeQuery(
                                        $updateBookingQuery,
                                        $updateBookingParams
                                    );
                                    
                                 $updateVehicleQuery = "
                                        UPDATE  tbl_vehicles
                                        SET vehicle_status = 'Parking'
                                        WHERE ids = :vehicle_id
                                    ";
                                
                                    $updateVehicleParams = [
                                
                                        ':vehicle_id' => $this->vehicle_ids
                                
                                    ];
                                
                                    $this->varPDOModelObj->executeQuery(
                                        $updateVehicleQuery,
                                        $updateVehicleParams
                                    );
                                   
                                $this->varPDOModelObj->logVehicleMovement([
                                'vehicle_id'     => $this->vehicle_ids,
                                'action_type'    => 'Return',
                                'old_status'     => $oldStatus,
                                'new_status'     => 'Parking',
                                'reference_type' => 'Agreement',
                                'reference_id'   => $this->agreementid,
                                'reference_no'   => $this->agreement_no ?? null,
                                'location_from'  => 'Customer',
                                'location_to'    => 'Main Parking',
                                'staff_id'       => null,
                                'customer_id'    => $this->customer_code ?? null,
                                'garage_id'      => null,
                                'odometer'       => $this->km_in,
                                'fuel_level'     => null,
                                'remarks'        => 'Vehicle returned under Agreement No. ' . ($this->agreement_no ?? '')
                            ]);
                                }
                                echo json_encode([
                                    "status" => true,
                                    "message" => "Saved successfully",
                                    "data" => $this->ReturnData
                                ]);
                        
                                Logger::ActivityLog(
                                    'VehiclesContractListController',
                                    "returnContractGeneration",
                                    [$this->ReturnData]
                                );
                        
                            } catch (Exception $e) {
                        
                                echo json_encode([
                                    "status" => false,
                                    "message" => $e->getMessage()
                                ]);
                            }
                            
                     
            break;
          case 'closeContract':

    $log_details = [
        "user_id" => $this->user_id,
        "datetime" => date('Y-m-d H:i:s')
    ];

    $json_log = json_encode($log_details);

    // 🔥 PDOStatement returned here
    $stmt = $this->varPDOModelObj->selectexecuteQuery(
        "SELECT ids, booking_ids, agreement_no
         FROM tbl_vehicle_rentout_contracts
         WHERE ids = :contract_ids",
        [':contract_ids' => $this->agreementid]
    );

    // ✅ FIX: fetch manually
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        return json_encode([
            'status' => false,
            'message' => 'Contract not found'
        ]);
    }

    $booking_id = $data['booking_ids'] ?? null;

    if (!$booking_id) {
        return json_encode([
            'status' => false,
            'message' => 'Booking ID not found'
        ]);
    }

    // Close contract
    $this->varPDOModelObj->executeQuery(
        "UPDATE tbl_vehicle_rentout_contracts
         SET agreement_status = 'Closed',
             close_log_json = :close_log_json,
             close_otp_details = :close_otp_msg
         WHERE ids = :id",
        [
            ':close_log_json' => $json_log,
            ':close_otp_msg' => json_encode([
                'message' => $this->close_otp_msg,
                'closed_on' => date('Y-m-d H:i:s')
            ]),
            ':id' => $this->agreementid
        ]
    );

    // Close booking
    $this->varPDOModelObj->executeQuery(
        "UPDATE tbl_vehicle_bookings
         SET book_status = 'Closed'
         WHERE ids = :booking_id",
        [
            ':booking_id' => $booking_id
        ]
    );

    echo json_encode([
        'status' => true,
        'message' => 'Contract and booking closed successfully'
    ]);

break;

case 'getViolationHeads':
    try {
        $checkCol = $this->varPDOModelObj->selectexecuteQuery("SHOW COLUMNS FROM tbl_ledger_heads LIKE 'violation_fine_type'");
        if ($checkCol && $checkCol->rowCount() == 0) {
            $this->varPDOModelObj->executeQuery("ALTER TABLE tbl_ledger_heads ADD COLUMN violation_fine_type VARCHAR(10) NOT NULL DEFAULT 'No'");
        }
    } catch (\Exception $exCol) {}

    $stmtHeads = $this->varPDOModelObj->selectexecuteQuery(
        "SELECT ids, head_name FROM tbl_ledger_heads WHERE violation_fine_type = 'Yes' ORDER BY head_name ASC"
    );
    $headsList = $stmtHeads ? $stmtHeads->fetchAll(PDO::FETCH_ASSOC) : [];
    echo json_encode([
        'status' => true,
        'data'   => $headsList
    ]);
    break;

case 'addViolationHead':
    $headName = trim($this->head_name ?? '');
    if (empty($headName)) {
        echo json_encode(['status' => false, 'message' => 'Violation head name is required']);
        break;
    }

    try {
        $checkCol = $this->varPDOModelObj->selectexecuteQuery("SHOW COLUMNS FROM tbl_ledger_heads LIKE 'violation_fine_type'");
        if ($checkCol && $checkCol->rowCount() == 0) {
            $this->varPDOModelObj->executeQuery("ALTER TABLE tbl_ledger_heads ADD COLUMN violation_fine_type VARCHAR(10) NOT NULL DEFAULT 'No'");
        }
    } catch (\Exception $exCol) {}

    $stmtCheck = $this->varPDOModelObj->selectexecuteQuery(
        "SELECT ids FROM tbl_ledger_heads WHERE head_name = :hname",
        [':hname' => $headName]
    );
    $existHead = $stmtCheck ? $stmtCheck->fetch(PDO::FETCH_ASSOC) : null;

    if ($existHead) {
        $this->varPDOModelObj->executeQuery(
            "UPDATE tbl_ledger_heads SET violation_fine_type = 'Yes' WHERE ids = :id",
            [':id' => $existHead['ids']]
        );
        echo json_encode([
            'status' => true,
            'message' => 'Violation head enabled successfully',
            'head_name' => $headName
        ]);
    } else {
        $this->varPDOModelObj->executeQuery(
            "INSERT INTO tbl_ledger_heads (head_name, head_type, violation_fine_type, is_locked, company_id) VALUES (:hname, 'Debit', 'Yes', 0, :company_id)",
            [
                ':hname' => $headName,
                ':company_id' => $this->company_id ?? 1
            ]
        );
        echo json_encode([
            'status' => true,
            'message' => 'Violation head added successfully',
            'head_name' => $headName
        ]);
    }
    break;

case 'getAvailableVehicles':
    $rawCat = trim($data['category_id'] ?? '');
    $whereClause = "WHERE v.vehicle_status = 'Available'";
    $params = [];

    if (!empty($rawCat)) {
        if (is_numeric($rawCat)) {
            $catId = intval($rawCat);
            $whereClause .= " AND (v.category_id = {$catId} OR m.category_id = {$catId} OR c.ids = {$catId})";
        } else {
            $whereClause .= " AND (c.category_name LIKE :cname OR (SELECT category_name FROM tbl_vehicle_category WHERE ids = m.category_id) LIKE :cname)";
            $params[':cname'] = '%' . $rawCat . '%';
        }
    }

    $sqlVeh = "
        SELECT 
            v.ids,
            v.vehicle_number,
            COALESCE(v.category_id, m.category_id) AS vehicle_category_id,
            v.model_id AS vehicle_model_id,
            v.vehicle_color,
            v.vehicle_year AS manufacture_year,
            v.vehicle_status,
            v.other_details_json,
            v.image_json,
            COALESCE(c.category_name, (SELECT category_name FROM tbl_vehicle_category WHERE ids = m.category_id)) AS category_name,
            m.modal_name AS model_name
        FROM tbl_vehicles v
        LEFT JOIN tbl_vehicle_category c ON c.ids = v.category_id
        LEFT JOIN tbl_vehicle_model m ON m.ids = v.model_id
        {$whereClause}
        ORDER BY v.vehicle_number ASC
    ";
    $stmtVeh = !empty($params) 
        ? $this->varPDOModelObj->selectexecuteQuery($sqlVeh, $params)
        : $this->varPDOModelObj->selectexecuteQuery($sqlVeh);
    $availableList = [];
    if ($stmtVeh) {
        $rows = $stmtVeh->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $r) {
            $other = !empty($r['other_details_json']) ? (json_decode($r['other_details_json'], true) ?: []) : [];
            $r['odo_meter'] = $other['current_km'] ?? ($other['odo_meter'] ?? ($other['km'] ?? 0));
            $r['fuel_level'] = $other['fuel_level'] ?? ($other['fuel'] ?? '');
            $r['fuel_type'] = $other['fuel_type'] ?? ($other['fuel'] ?? 'Petrol');
            $r['gear_type'] = $other['gear_type'] ?? ($other['transmission'] ?? 'Automatic');
            $r['next_passing_date'] = $other['next_passing_date'] ?? ($other['passing_date'] ?? 'NA');
            $r['next_insurance_date'] = $other['next_insurance_date'] ?? ($other['insurance_date'] ?? 'NA');
            $r['next_maintenance_date'] = $other['next_maintenance_date'] ?? ($other['maintenance_date'] ?? 'NA');

            $lastImage = '';
            if (!empty($r['image_json'])) {
                $imgs = json_decode($r['image_json'], true);
                if (is_array($imgs) && count($imgs) > 0) {
                    $lastImage = end($imgs);
                }
            }
            if (empty($lastImage) && !empty($other['vehicle_images'])) {
                $imgs = is_array($other['vehicle_images']) ? $other['vehicle_images'] : json_decode($other['vehicle_images'], true);
                if (is_array($imgs) && count($imgs) > 0) {
                    $lastImage = end($imgs);
                }
            }
            $r['last_image'] = $lastImage;
            $r['vehicle_images'] = $other['vehicle_images'] ?? ($other['images'] ?? []);
            $availableList[] = $r;
        }
    }
    echo json_encode([
        'status' => true,
        'data'   => $availableList
    ]);
    break;

case 'replaceContractGeneration':
    try {
        $agreementId = intval($this->agreementid);
        if (empty($agreementId)) {
            echo json_encode(['status' => false, 'message' => 'Agreement ID is required']);
            break;
        }

        $stmtContract = $this->varPDOModelObj->selectexecuteQuery(
            "SELECT * FROM tbl_vehicle_rentout_contracts WHERE ids = :id",
            [':id' => $agreementId]
        );
        $contractRow = $stmtContract ? $stmtContract->fetch(PDO::FETCH_ASSOC) : null;
        if (!$contractRow) {
            echo json_encode(['status' => false, 'message' => 'Contract not found']);
            break;
        }

        if (strtolower($contractRow['agreement_status']) !== 'rentout') {
            echo json_encode(['status' => false, 'message' => 'Vehicle replacement is only allowed for active Rentout contracts.']);
            break;
        }

        $newVehId = intval($this->new_vehicle_id);
        if (empty($newVehId)) {
            echo json_encode(['status' => false, 'message' => 'Please select a replacement vehicle']);
            break;
        }

        $stmtNewVeh = $this->varPDOModelObj->selectexecuteQuery(
            "SELECT v.*, c.category_name, m.modal_name AS model_name 
             FROM tbl_vehicles v
             LEFT JOIN tbl_vehicle_category c ON c.ids = v.category_id
             LEFT JOIN tbl_vehicle_model m ON m.ids = v.model_id
             WHERE v.ids = :id",
            [':id' => $newVehId]
        );
        $newVehRow = $stmtNewVeh ? $stmtNewVeh->fetch(PDO::FETCH_ASSOC) : null;
        if (!$newVehRow) {
            echo json_encode(['status' => false, 'message' => 'Replacement vehicle not found']);
            break;
        }

        $oldVehId = intval($contractRow['vehicle_id']);
        $oldVehNo = $contractRow['vehicle_no'] ?? '';
        $oldCatId = $contractRow['vehicle_category_id'] ?? '';
        $oldModelId = $contractRow['vehicle_model_id'] ?? '';
        $agreementNo = $contractRow['agreement_no'] ?? ($this->agreement_no ?? '');
        $custCode = $contractRow['customer_code'] ?? ($this->customer_code ?? '');

        // 1. Process Old Vehicle Return -> Parking
        $oldKmIn = !empty($this->old_km_in) ? floatval($this->old_km_in) : floatval($contractRow['km_in'] ?? 0);
        $oldKmOut = floatval($contractRow['km_out'] ?? 0);
        $oldKmUsed = !empty($this->old_km_used) ? floatval($this->old_km_used) : max(0, $oldKmIn - $oldKmOut);
        $oldFuelIn = !empty($this->old_fuel_in) ? $this->old_fuel_in : '';
        $oldDtIn = !empty($this->old_dt_in) ? $this->old_dt_in : date('Y-m-d H:i:s');
        $oldDtOut = $contractRow['date_out'] ?? date('Y-m-d H:i:s');

        $stmtOldOther = $this->varPDOModelObj->selectexecuteQuery("SELECT other_details_json FROM tbl_vehicles WHERE ids = :id", [':id' => $oldVehId]);
        $oldOtherRow = $stmtOldOther ? $stmtOldOther->fetch(PDO::FETCH_ASSOC) : null;
        $oldOtherJson = !empty($oldOtherRow['other_details_json']) ? (json_decode($oldOtherRow['other_details_json'], true) ?: []) : [];
        $oldOtherJson['current_km'] = $oldKmIn;
        $oldOtherJson['fuel_level'] = $oldFuelIn;

        $this->varPDOModelObj->executeQuery(
            "UPDATE tbl_vehicles SET vehicle_status = 'Parking', other_details_json = :oth WHERE ids = :id",
            [':oth' => json_encode($oldOtherJson), ':id' => $oldVehId]
        );

        $this->varPDOModelObj->logVehicleMovement([
            'vehicle_id'     => $oldVehId,
            'action_type'    => 'Replace Return',
            'old_status'     => 'Rentout',
            'new_status'     => 'Parking',
            'reference_type' => 'Agreement',
            'reference_id'   => $agreementId,
            'reference_no'   => $agreementNo,
            'location_from'  => 'Customer',
            'location_to'    => 'Main Parking',
            'staff_id'       => null,
            'customer_id'    => $custCode,
            'garage_id'      => null,
            'odometer'       => $oldKmIn,
            'fuel_level'     => $oldFuelIn,
            'remarks'        => 'Replaced on contract: ' . ($this->replace_remarks ?? 'Vehicle replacement')
        ]);

        // Process Old Vehicle Traffic Violations
        $rawViolations = is_array($this->violations) ? $this->violations : [];
        $formattedViolations = [];
        foreach ($rawViolations as $v) {
            $vTitle = trim($v['title'] ?? '');
            $vFee = floatval($v['fee'] ?? 0);
            $vRemarks = trim($v['remarks'] ?? '');
            $vDate = !empty($v['violation_date']) ? $v['violation_date'] : date('Y-m-d');
            $vLedgerId = !empty($v['ledger_id']) ? intval($v['ledger_id']) : 0;

            if (empty($vLedgerId) && !empty($vTitle)) {
                try {
                    $stmtL = $this->varPDOModelObj->selectexecuteQuery("SELECT ids FROM tbl_ledger_heads WHERE head_name = :hname", [':hname' => $vTitle]);
                    if ($stmtL) {
                        $rowL = $stmtL->fetch(PDO::FETCH_ASSOC);
                        $vLedgerId = $rowL['ids'] ?? 0;
                    }
                } catch (\Exception $eL) {}
            }

            if ($vTitle !== '' || $vFee > 0 || $vRemarks !== '') {
                $formattedViolations[] = [
                    'vehicle_id'     => $oldVehId,
                    'vehicle_number' => $oldVehNo,
                    'violation_date' => $vDate,
                    'title'          => $vTitle,
                    'ledger_id'      => $vLedgerId,
                    'fee'            => $vFee,
                    'remarks'        => $vRemarks
                ];

                $transTypeStr = !empty($vTitle) ? $vTitle : 'Vehicle Violation';
                $vDesc = 'Vehicle Violation (Replaced Vehicle ' . $oldVehNo . '): ' . $vTitle;
                if (!empty($vRemarks)) $vDesc .= ' (Remarks: ' . $vRemarks . ')';
                $vDesc .= ' (Agreement No: ' . $agreementNo . ')';

                try {
                    $this->varPDOModelObj->executeQuery("
                        INSERT INTO tbl_customer_ledger
                        (customer_code, quotation_no, booking_no, trans_date, trans_type, payment_method, debit, credit, ref_no, description, user_id, company_id, created_at, booking_ids, contract_ids, agreement_no)
                        VALUES
                        (:customer_code, :quotation_no, :booking_no, :trans_date, :trans_type, 'N/A', :debit, 0, :ref_no, :description, :user_id, :company_id, :created_at, :booking_ids, :contract_ids, :agreement_no)
                    ", [
                        ':customer_code' => $custCode,
                        ':quotation_no'  => $contractRow['quotation_number'] ?? '',
                        ':booking_no'    => $contractRow['booking_ids'] ?? '',
                        ':trans_date'    => $vDate,
                        ':trans_type'    => $transTypeStr,
                        ':debit'         => $vFee,
                        ':ref_no'        => $agreementNo,
                        ':description'   => $vDesc,
                        ':user_id'       => $this->user_id ?? 1,
                        ':company_id'    => $this->company_id ?? 1,
                        ':created_at'    => date('Y-m-d H:i:s'),
                        ':booking_ids'   => $contractRow['booking_ids'] ?? '',
                        ':contract_ids'  => $agreementId,
                        ':agreement_no'  => $agreementNo
                    ]);
                } catch (\Exception $exLedger) {}
            }
        }

        // 2. Process New Vehicle -> Rentout
        $newVehNo = $newVehRow['vehicle_number'] ?? '';
        $newCatId = $newVehRow['category_id'] ?? '';
        $newModelId = $newVehRow['model_id'] ?? '';
        $newOtherJson = !empty($newVehRow['other_details_json']) ? (json_decode($newVehRow['other_details_json'], true) ?: []) : [];
        $newKmOut = !empty($this->new_km_out) ? floatval($this->new_km_out) : floatval($newOtherJson['current_km'] ?? 0);
        $newFuelOut = !empty($this->new_fuel_out) ? $this->new_fuel_out : ($newOtherJson['fuel_level'] ?? '');
        $newDtOut = !empty($this->new_dt_out) ? $this->new_dt_out : date('Y-m-d H:i:s');

        $this->varPDOModelObj->executeQuery(
            "UPDATE tbl_vehicles SET vehicle_status = 'Rentout' WHERE ids = :id",
            [':id' => $newVehId]
        );

        $this->varPDOModelObj->logVehicleMovement([
            'vehicle_id'     => $newVehId,
            'action_type'    => 'Replace Rentout',
            'old_status'     => 'Parking',
            'new_status'     => 'Rentout',
            'reference_type' => 'Agreement',
            'reference_id'   => $agreementId,
            'reference_no'   => $agreementNo,
            'location_from'  => 'Main Parking',
            'location_to'    => 'Customer',
            'staff_id'       => null,
            'customer_id'    => $custCode,
            'garage_id'      => null,
            'odometer'       => $newKmOut,
            'fuel_level'     => $newFuelOut,
            'remarks'        => 'Assigned on contract replacement: ' . ($this->replace_remarks ?? '')
        ]);

        // 3. Build Historical Node & Update `replaced_vehicle_json`
        try {
            $checkCol = $this->varPDOModelObj->selectexecuteQuery("SHOW COLUMNS FROM tbl_vehicle_rentout_contracts LIKE 'replaced_vehicle_json'");
            if ($checkCol && $checkCol->rowCount() == 0) {
                $this->varPDOModelObj->executeQuery("ALTER TABLE tbl_vehicle_rentout_contracts ADD COLUMN replaced_vehicle_json LONGTEXT NULL");
            }
        } catch (\Exception $colEx) {}

        $existingReplacedList = [];
        if (!empty($contractRow['replaced_vehicle_json'])) {
            $existingReplacedList = json_decode($contractRow['replaced_vehicle_json'], true) ?: [];
        }

        $oldCatName = $contractRow['category_name'] ?? '';
        $oldModelName = $contractRow['model_name'] ?? '';
        $oldFuelOut = '';
        if (!empty($contractRow['contract_details_json'])) {
            $cdj = json_decode($contractRow['contract_details_json'], true) ?: [];
            $oldFuelOut = $cdj['fuel_out'] ?? ($cdj['fuel_level'] ?? '');
        }

        $replacementRecordNode = [
            'replacement_id'   => 'REPL-' . time() . '-' . rand(100, 999),
            'replaced_on'      => date('Y-m-d H:i:s'),
            'replaced_by_user' => $this->user_id ?? 1,
            'staff_name'       => $this->staff_name ?? '',
            'staff_signature'  => $this->staff_signature ?? '',
            'old_vehicle'      => [
                'vehicle_id'        => $oldVehId,
                'vehicle_number'    => $oldVehNo,
                'category_id'       => $oldCatId,
                'model_id'          => $oldModelId,
                'category_name'     => $oldCatName,
                'model_name'        => $oldModelName,
                'km_out'            => $oldKmOut,
                'km_in'             => $oldKmIn,
                'km_used'           => $oldKmUsed,
                'dt_out'            => $oldDtOut,
                'dt_in'             => $oldDtIn,
                'fuel_level_out'    => $oldFuelOut,
                'fuel_level_in'     => $oldFuelIn,
                'accessories'       => $this->old_accessories,
                'old_return_images' => $this->old_return_images,
                'violations'        => $formattedViolations
            ],
            'new_vehicle'      => [
                'vehicle_id'        => $newVehId,
                'vehicle_number'    => $newVehNo,
                'category_id'       => $newCatId,
                'model_id'          => $newModelId,
                'category_name'     => $newVehRow['category_name'] ?? '',
                'model_name'        => $newVehRow['model_name'] ?? '',
                'km_out'            => $newKmOut,
                'fuel_level_out'    => $newFuelOut,
                'dt_out'            => $newDtOut,
                'accessories'       => $this->new_accessories,
                'new_rentout_images'=> $this->new_rentout_images
            ],
            'remarks'          => $this->replace_remarks ?? ''
        ];

        $existingReplacedList[] = $replacementRecordNode;
        $replacedJsonStr = json_encode($existingReplacedList);

        $newVehDetailsStr = json_encode([
            'vehicle_id'     => (string)$newVehId,
            'category_id'    => (string)$newCatId,
            'model_id'       => (string)$newModelId,
            'veh_no'         => (string)$newVehNo,
            'category_name'  => (string)($newVehRow['category_name'] ?? ''),
            'model_name'     => (string)($newVehRow['model_name'] ?? ''),
            'vehicle_color'  => (string)($newVehRow['vehicle_color'] ?? ''),
            'vehicle_year'   => (string)($newVehRow['manufacture_year'] ?? ($newVehRow['vehicle_year'] ?? ''))
        ]);

        $existingContractDetails = !empty($contractRow['contract_details_json']) ? (json_decode($contractRow['contract_details_json'], true) ?: []) : [];
        $existingContractDetails['fuel_out'] = $newFuelOut;
        $existingContractDetails['fuel_level'] = $newFuelOut;
        $contractDetailsJsonStr = json_encode($existingContractDetails);

        $this->varPDOModelObj->executeQuery("
            UPDATE tbl_vehicle_rentout_contracts
            SET 
                vehicle_category_id    = :new_cat_id,
                vehicle_model_id       = :new_model_id,
                vehicle_id             = :new_veh_id,
                vehicle_no             = :new_veh_no,
                vechile_details        = :new_veh_details,
                km_out                 = :new_km_out,
                contract_details_json  = :contract_details_json,
                vehicle_rentout_images = :new_rentout_images,
                replaced_vehicle_json  = :replaced_json
            WHERE ids = :agreement_id
        ", [
            ':new_cat_id'            => $newCatId,
            ':new_model_id'          => $newModelId,
            ':new_veh_id'            => $newVehId,
            ':new_veh_no'            => $newVehNo,
            ':new_veh_details'       => $newVehDetailsStr,
            ':new_km_out'            => $newKmOut,
            ':contract_details_json' => $contractDetailsJsonStr,
            ':new_rentout_images'    => $newRentoutImagesStr,
            ':replaced_json'         => $replacedJsonStr,
            ':agreement_id'          => $agreementId
        ]);

        echo json_encode([
            'status'  => true,
            'message' => 'Vehicle replaced successfully! Old vehicle moved to parking and contract updated.'
        ]);

    } catch (\Exception $e) {
        echo json_encode([
            'status'  => false,
            'message' => 'Error replacing vehicle: ' . $e->getMessage()
        ]);
    }
    break;
                
			default:
        	      $noAction= json_encode([
                    'status'  => false,
                    'message' => "No Action Found..!"
                 ]);
                 echo $noAction;
                 Logger::ActivityLog('VehiclesContractListController',"default",[json_decode($noAction)]);
			break;
			
		}
	 }
	
}

$obj = new VehiclesContractListController();
$obj->DataRequest($obj->actionevents);

?>
