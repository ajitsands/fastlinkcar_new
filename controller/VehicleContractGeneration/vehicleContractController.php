<?PHP 
header('Content-Type: application/json');
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
class VehiclesContractController
{
	  var $varPDOModelObj;
      public $actionevents,$json;
      public $params = [];
      public $selectedBookingIds= [];
	  public $user_id,$company_id,$insertedDate,$bookingid,$vehicleid,$customer_code,$model_ids;
	  public $booking_ids,$booking_ref_no,$customer_data,$vehicle_data,$contract_details,$company_driver_details,$vehicle_accessories,$tc_ids,$t_c_name,$terms_condition,$termsContent,$agreement_date,$contract_ids,$data_source_val,$filter_from,$filter_to,$booking_status,$hirer_name,$delivery_name,$hirer_signature,$delivery_signature;
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
         
        // Access values
        //$this->vehicleYear = $data['vehicleYear'] ?? null;
       
        
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
        $this->is_rentout = isset($data['is_rentout']) ? (int)$data['is_rentout'] : 0;
        $this->hirer_name         = $data['hirer_name'] ?? '';
        $this->delivery_name      = $data['delivery_name'] ?? '';
        $this->hirer_signature    = $data['hirer_signature'] ?? '';
        $this->delivery_signature = $data['delivery_signature'] ?? '';
         $this->booking_status = $data['booking_status'] ?? 'All';
        
        $this->booking_ids = $data['booking_ids'] ?? '';
        $this->booking_ref_no = $data['booking_ref_no'] ?? '';
        $this->termsContent = $data['termsContent'] ?? '';
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
        if (isset($data['action']) && $data['action'] === 'contractGeneration') {
            file_put_contents('scratch/debug_payload_constructor.log', print_r([
                'vehicle_accessories' => $this->vehicle_accessories
            ], true), FILE_APPEND);
        }
       
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
          $array[0] = "SELECT *, FROM tbl_vehicle_bookings where company_id=:company_id ORDER BY ids DESC";
          
          
      
        
        $array[1] = "INSERT INTO tbl_vehicle_rentout_contracts (
            booking_ids,
            company_id,
            agreement_no,
            agreement_group_ref_no,
            agreement_date,
            customer_code,
            customer_name,
            customer_details,
            quotation_number,
            vehicle_category_id,
            vehicle_model_id,
            vehicle_id,
            vehicle_no,
            vechile_details,
            service_type,
            service_start_date_time,
            service_end_date_time,
            contract_details_json,
            km_out,
            vehicle_accessories_details,
            vehicle_rentout_images,
            driver_ids,
            driver_details,
            customer_driver_name,
            customer_driver_contact_number,
            customer_driver_attachments,
            minprice_otp_details,
            log_json,
            terms_condition,
            agreement_status
        ) VALUES (
            :booking_ids,
            :company_id,
            :agreement_no,
            :booking_ref_no,
            :agreement_date,
            :customer_code,
            :customer_name,
            :customer_details,
            :quotation_number,
            :vehicle_category_id,
            :vehicle_model_id,
            :vehicle_id,
            :vehicle_no,
            :vechile_details,
            :service_type,
            :service_start,
            :service_end,
            :contract_details,
            :km_out,
            :vehicle_accessories,
            :vehicle_images,
            :driver_ids,
            :driver_details,
            :cust_driver_name,
            :cust_driver_mobile,
            :cust_driver_docs,
            :otp_details,
            :log_details,
            :terms_condition,
            :agreement_status
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
                terms_condition = :terms_condition,
                agreement_status = :agreement_status
            WHERE ids = :contract_id";
            
        $array[3] = "SELECT t_c_name, terms_condition FROM tbl_terms_and_condition_contract WHERE ids = :tc_ids";
        
        $this->params[3] = [
             ':tc_ids' => $this->tc_ids
        ];
        $array[4] = "DELETE from tbl_terms_and_condition_contract WHERE ids = :tc_ids";
         $this->params[4] = [
             ':tc_ids' => $this->tc_ids
        ];
		return $array;
	}
	function generateAgreementNo($pdo, $bookingCompanyId = null, $contractId = null) {
        if (!empty($contractId)) {
            $stmtExist = $pdo->selectexecuteQuery(
                "SELECT agreement_no FROM tbl_vehicle_rentout_contracts WHERE ids = :contract_id",
                [':contract_id' => $contractId]
            );
            $existRow = $stmtExist->fetch(PDO::FETCH_ASSOC);
            if ($existRow && !empty($existRow['agreement_no'])) {
                return $existRow['agreement_no'];
            }
        }

        if (empty($bookingCompanyId)) {
            $bookingCompanyId = $this->company_id;
        }

        $companyCode = 'AA'; // Default fallback
        if (!empty($bookingCompanyId) && $bookingCompanyId !== 'all') {
            $stmtComp = $pdo->selectexecuteQuery(
                "SELECT company_code FROM tbl_company WHERE ids = :company_id",
                [':company_id' => $bookingCompanyId]
            );
            $compRow = $stmtComp->fetch(PDO::FETCH_ASSOC);
            if ($compRow && !empty($compRow['company_code'])) {
                $companyCode = $compRow['company_code'];
            }
        }
    
        $year = date('Y');
    
        $prefix = "$companyCode/AGR/$year/";
    
        // Get last agreement number for this year and company
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
			
             case 'ListBookings':

                        $baseQuery = "SELECT b.*, c.company_name, v.chassis_number, r.ids AS contract_id
    FROM tbl_vehicle_bookings b
    LEFT JOIN tbl_company c ON b.company_id = c.ids 
    LEFT JOIN tbl_vehicles v ON b.vehicle_id = v.ids
    LEFT JOIN tbl_vehicle_rentout_contracts r ON b.ids = r.booking_ids
    WHERE 1=1";

                            $params = [];
                            
                            if ($this->company_id !== 'all') {
                                $baseQuery .= " AND b.company_id = :company_id";
                                $params[':company_id'] = $this->company_id;
                            }
                            
                            if (
                                !($this->customer_code == '' || $this->customer_code == 'All')
                            ) {
                                $baseQuery .= " AND b.customer_code = :customer_code";
                                $params[':customer_code'] = $this->customer_code;
                            }
                            
                            if ($this->filter_from != '' && $this->filter_to != '') {

                                $baseQuery .= "
                                    AND (
                                        (
                                            DATE(b.book_from_date) BETWEEN :filter_from1 AND :filter_to1
                                        )
                                        OR
                                        (
                                            DATE(b.book_to_date) BETWEEN :filter_from2 AND :filter_to2
                                        )
                                        OR
                                        (
                                            DATE(b.book_from_date) <= :filter_from3
                                            AND DATE(b.book_to_date) >= :filter_to3
                                        )
                                    )
                                ";
                            
                                $params[':filter_from1'] = $this->filter_from;
                                $params[':filter_to1']   = $this->filter_to;
                            
                                $params[':filter_from2'] = $this->filter_from;
                                $params[':filter_to2']   = $this->filter_to;
                            
                                $params[':filter_from3'] = $this->filter_from;
                                $params[':filter_to3']   = $this->filter_to;
                            }
                            
                            if (
                                !($this->booking_status == '' || $this->booking_status == 'All')
                            ) {
                                $baseQuery .= " AND b.book_status = :booking_status";
                                $params[':booking_status'] = $this->booking_status;
                            }
                            
                            $baseQuery .= " ORDER BY b.ids DESC";
                            
                            $result = $this->varPDOModelObj->selectexecuteQuery($baseQuery, $params);
                 
			   
                
                $rows = $result ->fetchAll(PDO::FETCH_ASSOC);
                    $data = [];

                   $data = [];

                    foreach ($rows as $row) {
                    
                        $bookingNo = $row['booking_no'];
                    
                        // ✅ ALWAYS initialize first
                        if (!isset($data[$bookingNo])) {
                    
                            $details = json_decode($row['customer_details_json'], true) ?? [];
                    
                            $data[$bookingNo] = [
                                "booking_ref"     => $bookingNo,
                                "customer_name"   => $row['customer_name'],
                                "customer_code"   => $row['customer_code'],
                                "mobile"          => $details['phone'] ?? '-',
                                "company_name"    => $row['company_name'],
                                "reservation_date"=> date(defined('SYS_DATE_FORMAT') ? SYS_DATE_FORMAT : 'd-m-Y', strtotime($row['created_date'])),
                                "entries"         => [],
                                "pending_count"   => 0,   // ✅ initialize
                                "confirmed_count"   => 0,   // ✅ initialize
                                "rentout_count" => 0,    // ✅ initialize
                                "return_count" => 0,    // ✅ initialize
                                "cancelled_count" => 0,  // ✅ initialize
                                 "closed_count" => 0    // ✅ initialize
                            ];
                        }
                    
                        // ✅ THEN apply status logic
                        $status = strtolower(trim($row['book_status']));
                    
                        if (in_array($status, ['booked'])) {
                            $data[$bookingNo]["pending_count"]++;
                        }
                        if (in_array($status, ['confirmed'])) {
                            $data[$bookingNo]["confirmed_count"]++;
                        }
                        if (in_array($status, ['rentout'])) {
                            $data[$bookingNo]["rentout_count"]++;
                        }
                        if (in_array($status, ['returned'])) {
                            $data[$bookingNo]["return_count"]++;
                        }
                        if (in_array($status, ['cancelled'])) {
                            $data[$bookingNo]["cancelled_count"]++;
                        }
                        if (in_array($status, ['closed'])) {
                            $data[$bookingNo]["closed_count"]++;
                        }
                    
                        // ✅ Add child entry
                        $data[$bookingNo]["entries"][] = [
                            "id"=> $row['ids'],
                            "ids" => $row['ids'],
                            "contract_id" => $row['contract_id'],
                            "booking_ref"     => $bookingNo,
                            "vehicle_id" => $row['vehicle_id'],
                            "model_id" => $row['model_id'],
                            "customer_code" => $row['customer_code'],
                            "customer_name"   => $row['customer_name'],
                            "vehicle_no" => $row['vehicle_no'],
                            "brand_name" => $row['brand_name'],
                            "book_status" => $row['book_status'],
                            "model_name" => $row['model_name'],
                            "from_date"  => $row['book_from_date'],
                            "to_date"    => $row['book_to_date'],
                            "from_date_format"  => date((defined('SYS_DATE_FORMAT') ? SYS_DATE_FORMAT : 'd-m-Y').' H:i', strtotime($row['book_from_date'])),
                            "to_date_format"    => $row['book_to_date'] ? date((defined('SYS_DATE_FORMAT') ? SYS_DATE_FORMAT : 'd-m-Y').' H:i', strtotime($row['book_to_date'])) : null,
                            "chassis_number" => $row['chassis_number'] ?? null
                        ];
                    }
                    
                    echo json_encode([
                        "data" => array_values($data)
                    ]);
			    
            break;
		  
		   
		   case 'GetContractDetails':

                    // 1. Customer Details
                    $result_cust = $this->varPDOModelObj->selectexecuteQuery(
                        "SELECT customer_id, customer_name, customer_mobile, customer_email, customer_addr, customer_attn 
                         FROM customer_details 
                         WHERE customer_id = :customer_code",
                        [':customer_code' => $this->customer_code]
                    );
                    $customer = $result_cust->fetch(PDO::FETCH_ASSOC);
                
                    // 2. Vehicle Details
                    $result_vehicle = $this->varPDOModelObj->selectexecuteQuery(
                        "SELECT v.ids, v.category_id, v.model_id, v.category_name, v.brand_name, v.model_names, v.vehicle_number, v.vehicle_year, v.vehicle_color,
                                v.next_insurance_date, v.next_maintenance_date,v.next_passing_date,DATE_FORMAT(v.next_insurance_date, '%d/%m/%Y') AS formatted_next_insurance_date,DATE_FORMAT(v.next_maintenance_date, '%d/%m/%Y') AS formatted_next_maintenance_date,DATE_FORMAT(v.next_passing_date, '%d/%m/%Y') AS formatted_next_passing_date, t.chassis_number, t.image_json, t.other_details_json
                         FROM view_vehicle_details v
                         LEFT JOIN tbl_vehicles t ON v.ids = t.ids 
                         WHERE v.ids = :vehicle_ids",
                        [':vehicle_ids' => $this->vehicleid]
                    );
                    $vehicle = $result_vehicle->fetch(PDO::FETCH_ASSOC);
                    $result_log = $this->varPDOModelObj->selectexecuteQuery(
                        "SELECT odometer FROM tbl_vehicle_log_movement WHERE vehicle_ids = :vid AND odometer IS NOT NULL AND odometer != '' ORDER BY log_datetime DESC, ids DESC LIMIT 1",
                        [':vid' => $this->vehicleid]
                    );
                    $log = $result_log->fetch(PDO::FETCH_ASSOC);
                    
                    $other = json_decode($vehicle['other_details_json'] ?? '{}', true);
                    $vehicle['odo_meter'] = $log ? $log['odometer'] : ($other['current_km'] ?? ($other['odo_meter'] ?? ($other['km'] ?? 0)));
                  $result_model = $this->varPDOModelObj->selectexecuteQuery(
                    "SELECT price_json FROM  tbl_vehicle_model WHERE ids = :model_ids",
                    [':model_ids' => $this->model_ids]
                );
                       $model = $result_model->fetch(PDO::FETCH_ASSOC);
                        $price_list = [];
                        if (!empty($model['price_json'])) {
                            $price_list = json_decode($model['price_json'], true);
                        }
                    // 3. Check Rentout First
                    if (!empty($this->contract_ids)) {
                        file_put_contents('scratch/debug_payload.log', print_r([
                            'contract_ids' => $this->contract_ids,
                            'vehicle_accessories' => $this->vehicle_accessories,
                            'vehicle_images' => $this->vehicle_accessories['vehicle_images'] ?? 'MISSING'
                        ], true), FILE_APPEND);
                        $result_rentout = $this->varPDOModelObj->selectexecuteQuery(
                            "SELECT ids,service_type, service_start_date_time, service_end_date_time,agreement_date,
                                    km_in, km_out, km_used, vehicle_rentout_images, quotation_number,
                                    vehicle_accessories_details, remarks1, terms_condition,
                                    driver_status, driver_details, hier_signature_status,
                                    received_by, delivered_by,contract_details_json as book_details_json,driver_ids,driver_details,customer_driver_name,customer_driver_contact_number,customer_driver_attachments
                             FROM tbl_vehicle_rentout_contracts 
                             WHERE ids = :contract_id",
                            [':contract_id' => $this->contract_ids]
                        );
                    } else {
                        $result_rentout = $this->varPDOModelObj->selectexecuteQuery(
                            "SELECT ids,service_type, service_start_date_time, service_end_date_time,agreement_date,
                                    km_in, km_out, km_used, vehicle_rentout_images, quotation_number,
                                    vehicle_accessories_details, remarks1, terms_condition,
                                    driver_status, driver_details, hier_signature_status,
                                    received_by, delivered_by,contract_details_json as book_details_json,driver_ids,driver_details,customer_driver_name,customer_driver_contact_number,customer_driver_attachments
                             FROM tbl_vehicle_rentout_contracts 
                             WHERE booking_ids = :booking_id",
                            [':booking_id' => $this->bookingid]
                        );
                    }
                
                    $contract = $result_rentout->fetch(PDO::FETCH_ASSOC);
                
                    if ($contract) {
                        $source = "rentout";
                    } else {
                        // 4. Fallback to Booking
                        $result_booking = $this->varPDOModelObj->selectexecuteQuery(
                            "SELECT book_from_date AS service_start_date_time,
                                    book_to_date AS service_end_date_time,
                                    quotation_number,book_details_json 
                             FROM tbl_vehicle_bookings 
                             WHERE ids = :booking_id",
                            [':booking_id' => $this->bookingid]
                        );
                
                        $contract = $result_booking->fetch(PDO::FETCH_ASSOC);
                        $source = "booking";
                    }
                
                    // 5. Final Response
                    $response = [
                        'customer' => $customer ?: [],
                        'vehicle'  => $vehicle ?: [],
                        'contract' => $contract ?: [],
                        'price_list' => $price_list,
                        'source'   => $source ?? 'none'
                    ];
                
                    echo json_encode($response);
                    break;
                    case 'contractGeneration':
                        $log_details = [
                                    "user_id" => $this->user_id,
                                    "datetime" => date('Y-m-d H:i:s')
                                ];
                        
                        $json_log = json_encode($log_details);
                        // Fetch company_id from the booking if it exists
                        $bookingCompanyId = $this->company_id;
                        if (!empty($this->booking_ids)) {
                            $stmtBook = $this->varPDOModelObj->selectexecuteQuery(
                                "SELECT company_id FROM tbl_vehicle_bookings WHERE ids = :booking_id",
                                [':booking_id' => $this->booking_ids]
                            );
                            $bookRow = $stmtBook->fetch(PDO::FETCH_ASSOC);
                            if ($bookRow && !empty($bookRow['company_id'])) {
                                $bookingCompanyId = $bookRow['company_id'];
                            }
                        }

                        // Check if a contract already exists for this booking_id to prevent duplicates
                        if (!empty($this->booking_ids)) {
                            $stmtExistContract = $this->varPDOModelObj->selectexecuteQuery(
                                "SELECT ids FROM tbl_vehicle_rentout_contracts WHERE booking_ids = :booking_id",
                                [':booking_id' => $this->booking_ids]
                            );
                            $existContractRow = $stmtExistContract->fetch(PDO::FETCH_ASSOC);
                            if ($existContractRow) {
                                $this->contract_ids = $existContractRow['ids'];
                                $this->data_source_val = 'rentout';
                            }
                        }

                        if ($this->data_source_val == 'rentout' && !empty($this->contract_ids))
                        {
                            $this->ReturnData = $this->varPDOModelObj->executeQuery($var[2],
                                            [
                                        
                                                ':booking_ids' => $this->booking_ids,
                                                ':company_id' => $bookingCompanyId,
                                        
                                                ':agreement_no' => $this->generateAgreementNo($this->varPDOModelObj, $bookingCompanyId, $this->contract_ids),
                                        
                                                ':booking_ref_no' => $this->booking_ref_no,
                                                ':agreement_date' => $this->agreement_date,
                                        
                                                ':customer_code' =>
                                                    $this->customer_data['customer_code'] ?? '',
                                        
                                                ':customer_name' =>
                                                    $this->customer_data['customer_name'] ?? '',
                                        
                                                ':customer_details' =>
                                                    json_encode($this->customer_data ?? []),
                                        
                                                ':quotation_number' =>
                                                    $this->contract_details['qtn_ref_no'] ?? '',
                                        
                                                ':vehicle_category_id' =>
                                                    $this->vehicle_data['category_id'] ?? 0,
                                        
                                                ':vehicle_model_id' =>
                                                    $this->vehicle_data['model_id'] ?? 0,
                                        
                                                ':vehicle_id' =>
                                                    $this->vehicle_data['vehicle_id'] ?? 0,
                                        
                                                ':vehicle_no' =>
                                                    $this->vehicle_data['veh_no'] ?? '',
                                        
                                                ':vechile_details' =>
                                                    json_encode($this->vehicle_data ?? []),
                                        
                                                ':service_type' =>
                                                    $this->contract_details['service_name'] ?? '',
                                        
                                                ':service_start' =>
                                                    $this->contract_details['period_from'] ?? null,
                                        
                                                ':service_end' =>
                                                    $this->contract_details['period_to'] ?? null,
                                        
                                                ':contract_details' =>
                                                    json_encode($this->contract_details ?? []),
                                        
                                                ':km_out' =>
                                                    $this->vehicle_accessories['vehicle_km_out'] ?? 0,
                                        
                                                ':vehicle_accessories' =>
                                                    json_encode($this->vehicle_accessories ?? []),
                                        
                                                ':vehicle_images' =>
                                                    json_encode(
                                                        $this->vehicle_accessories['vehicle_images'] ?? []
                                                    ),
                                        
                                                ':driver_ids' =>
                                                    $this->company_driver_details['driver_id'] ?? 0,
                                        
                                                ':driver_details' =>
                                                    json_encode($this->company_driver_details ?? []),
                                        
                                                ':cust_driver_name' =>
                                                    $this->vehicle_accessories['cust_driver_name'] ?? '',
                                        
                                                ':cust_driver_mobile' =>
                                                    $this->vehicle_accessories['cust_driver_contact_no'] ?? '',
                                        
                                                ':cust_driver_docs' =>
                                                    json_encode(
                                                        $this->vehicle_accessories['cust_driver_documents'] ?? []
                                                    ),
                                        
                                                ':otp_details' =>
                                                    json_encode(
                                                        $this->contract_details['otp_details'] ?? []
                                                    ),
                                        
                                                ':log_details' => $json_log,
                                        
                                                ':terms_condition' =>
                                                    $this->termsContent,
                                        
                                                // ✅ for WHERE condition
                                                ':contract_id' => $this->contract_ids,
                                                ':agreement_status' => ($this->is_rentout == 1) ? 'Rentout' : 'Generated'
                                            ]
                                        );
                                        
                                if ($this->ReturnData) {
                                    $updateBookingQuery = "
                                        UPDATE tbl_vehicle_bookings
                                        SET book_status = " . ($this->is_rentout == 1 ? "'Rentout'" : "'Confirmed'") . "
                                        WHERE ids = :booking_id
                                    ";
                                
                                    $updateBookingParams = [
                                        ':booking_id' => $this->booking_ids
                                    ];
                                
                                    $this->varPDOModelObj->executeQuery(
                                        $updateBookingQuery,
                                        $updateBookingParams
                                    );
                                }

                                if ($this->is_rentout == 1) {
                                    $actual_vehicle_id = !empty($this->vehicleid) ? $this->vehicleid : ($this->vehicle_data['vehicle_id'] ?? 0);
                                    $this->varPDOModelObj->executeQuery("UPDATE tbl_vehicles SET vehicle_status = 'Rentout' WHERE ids = " . intval($actual_vehicle_id));
                                    
                                    $existing_agreement_no = $this->generateAgreementNo($this->varPDOModelObj, $this->company_id, $this->contract_ids);

                                    $this->varPDOModelObj->executeQuery("
                                        INSERT INTO tbl_vehicle_log_movement 
                                        (vehicle_ids, vehicle_no, log_datetime, action_type, reference_type, reference_id, reference_no, odometer, fuel_level, customer_id, created_by, created_name, created_on)
                                        VALUES 
                                        (:vehicle_id, :vehicle_no, NOW(), 'Rentout', 'Direct Contract', :reference_id, :reference_no, :odometer, :fuel_level, :customer_code, :user_id, :created_name, NOW())
                                    ", [
                                        ':vehicle_id' => $actual_vehicle_id,
                                        ':vehicle_no' => $this->vehicle_data['veh_no'] ?? '',
                                        ':reference_id' => $this->contract_ids,
                                        ':reference_no' => $existing_agreement_no,
                                        ':odometer' => $this->vehicle_accessories['vehicle_km_out'] ?? 0,
                                        ':fuel_level' => $this->vehicle_accessories['fuel_level'] ?? '',
                                        ':customer_code' => $this->customer_data['customer_code'] ?? '',
                                        ':user_id' => $this->user_id,
                                        ':created_name' => $_SESSION['full_name'] ?? 'System'
                                    ]);

                                    $b_unit_price = $this->contract_details['unit_price'] ?? 0;
                                    $duration = $this->contract_details['duration'] ?? 1;
                                    $b_vat_perc = $this->contract_details['vat'] ?? 0;
                                    $debit = number_format(($b_unit_price * (float)$duration) + (($b_unit_price * (float)$duration) * ((float)$b_vat_perc / 100)), 3, '.', '');
                                    
                                    $this->varPDOModelObj->executeQuery("
                                        INSERT INTO tbl_customer_ledger
                                        (customer_code, quotation_no, booking_no, trans_date, trans_type, payment_method, debit, credit, ref_no, description, user_id, company_id, created_at, booking_ids, contract_ids, agreement_no)
                                        VALUES
                                        (:customer_code, '', '', :trans_date, 'Direct Contract Rentout', 'N/A', :debit, 0, :ref_no, :description, :user_id, :company_id, :created_at, :booking_ids, :contract_ids, :agreement_no)
                                    ", [
                                        ':customer_code' => $this->customer_data['customer_code'] ?? '',
                                        ':trans_date'    => date('Y-m-d'),
                                        ':debit'         => $debit,
                                        ':ref_no'        => $existing_agreement_no,
                                        ':description'   => 'Rentout from Direct Contract (Agreement No: ' . $existing_agreement_no . ')',
                                        ':user_id'       => $this->user_id,
                                        ':company_id'    => $this->company_id,
                                        ':created_at'    => date('Y-m-d H:i:s'),
                                        ':booking_ids'   => $this->booking_ids,
                                        ':contract_ids'  => $this->contract_ids,
                                        ':agreement_no'  => $existing_agreement_no
                                    ]);
                                }

                                echo json_encode([
                                    "status" => true,
                                    "message" => "Saved successfully",
                                    "data" => $this->ReturnData
                                ]);
                        
                                Logger::ActivityLog(
                                    'VehiclesContractController',
                                    "default",
                                    [$this->ReturnData]
                                );
                        }
                        
                        else
                        {
                            try {
                        
                        
                                $this->ReturnData = $this->varPDOModelObj->executeQuery(
                                    $var[1],
                                    [
                        
                                        ':booking_ids' => $this->booking_ids,
                                        ':company_id' => $bookingCompanyId,
                        
                                        ':agreement_no' => $this->generateAgreementNo($this->varPDOModelObj, $bookingCompanyId),
                        
                                        ':booking_ref_no' => $this->booking_ref_no,
                                        ':agreement_date' => $this->agreement_date,
                        
                                        ':customer_code' =>
                                            $this->customer_data['customer_code'] ?? '',
                        
                                        ':customer_name' =>
                                            $this->customer_data['customer_name'] ?? '',
                        
                                        ':customer_details' =>
                                            json_encode($this->customer_data ?? []),
                        
                                        ':quotation_number' =>
                                            $this->contract_details['qtn_ref_no'] ?? '',
                        
                                        ':vehicle_category_id' =>
                                            $this->vehicle_data['category_id'] ?? 0,
                        
                                        ':vehicle_model_id' =>
                                            $this->vehicle_data['model_id'] ?? 0,
                        
                                        ':vehicle_id' =>
                                            $this->vehicle_data['vehicle_id'] ?? 0,
                        
                                        ':vehicle_no' =>
                                            $this->vehicle_data['veh_no'] ?? '',
                        
                                        ':vechile_details' =>
                                            json_encode($this->vehicle_data ?? []),
                        
                                        ':service_type' =>
                                            $this->contract_details['service_name'] ?? '',
                        
                                        ':service_start' =>
                                            $this->contract_details['period_from'] ?? null,
                        
                                        ':service_end' =>
                                            $this->contract_details['period_to'] ?? null,
                        
                                        ':contract_details' =>
                                            json_encode($this->contract_details ?? []),
                        
                                        ':km_out' =>
                                            $this->vehicle_accessories['vehicle_km_out'] ?? 0,
                        
                                        ':vehicle_accessories' =>
                                            json_encode($this->vehicle_accessories ?? []),
                        
                                        ':vehicle_images' =>
                                            json_encode(
                                                $this->vehicle_accessories['vehicle_images'] ?? []
                                            ),
                        
                                        ':driver_ids' =>
                                            $this->company_driver_details['driver_id'] ?? 0,
                        
                                        ':driver_details' =>
                                            json_encode($this->company_driver_details ?? []),
                        
                                        ':cust_driver_name' =>
                                            $this->vehicle_accessories['cust_driver_name'] ?? '',
                        
                                        ':cust_driver_mobile' =>
                                            $this->vehicle_accessories['cust_driver_contact_no'] ?? '',
                        
                                        ':cust_driver_docs' =>
                                            json_encode(
                                                $this->vehicle_accessories['cust_driver_documents'] ?? []
                                            ),
                        
                                        ':otp_details' =>
                                            json_encode(
                                                $this->contract_details['otp_details'] ?? []
                                            ),
                        
                                        ':log_details' => $json_log,
                        
                                        ':terms_condition' =>
                                            $this->termsContent,
                                            
                                        ':agreement_status' => ($this->is_rentout == 1) ? 'Rentout' : 'Generated'
                                    ]
                                );
                             if ($this->ReturnData) {

                                    $updateBookingQuery = "
                                        UPDATE tbl_vehicle_bookings
                                        SET book_status = " . ($this->is_rentout == 1 ? "'Rentout'" : "'Confirmed'") . "
                                        WHERE ids = :booking_id
                                    ";
                                
                                    $updateBookingParams = [
                                
                                        ':booking_id' => $this->booking_ids
                                
                                    ];
                                
                                    $this->varPDOModelObj->executeQuery(
                                        $updateBookingQuery,
                                        $updateBookingParams
                                    );
                                
                                    if ($this->is_rentout == 1) {
                                        $this->varPDOModelObj->executeQuery("UPDATE tbl_vehicles SET vehicle_status = 'Rentout' WHERE ids = " . intval($this->vehicleid));
                                        
                                        $inserted_contract_id = $this->varPDOModelObj->varDBPDO->lastInsertId();
                                        $inserted_agreement_no = $this->generateAgreementNo($this->varPDOModelObj, $bookingCompanyId, $inserted_contract_id);
                                        
                                        $this->varPDOModelObj->executeQuery("
                                            INSERT INTO tbl_vehicle_log_movement 
                                            (vehicle_ids, vehicle_no, log_datetime, action_type, reference_type, reference_id, reference_no, odometer, fuel_level, customer_id, created_by, created_name, created_on)
                                            VALUES 
                                            (:vehicle_id, :vehicle_no, NOW(), 'Rentout', 'Direct Contract', :reference_id, :reference_no, :odometer, :fuel_level, :customer_code, :user_id, :created_name, NOW())
                                        ", [
                                            ':vehicle_id' => $this->vehicleid,
                                            ':vehicle_no' => $this->vehicle_data['veh_no'] ?? '',
                                            ':reference_id' => $inserted_contract_id,
                                            ':reference_no' => $inserted_agreement_no,
                                            ':odometer' => $this->vehicle_accessories['vehicle_km_out'] ?? 0,
                                            ':fuel_level' => $this->vehicle_accessories['fuel_level'] ?? '',
                                            ':customer_code' => $this->customer_data['customer_code'] ?? '',
                                            ':user_id' => $this->user_id,
                                            ':created_name' => $_SESSION['full_name'] ?? 'System'
                                        ]);
    
                                        $b_unit_price = $this->contract_details['unit_price'] ?? 0;
                                        $duration = $this->contract_details['duration'] ?? 1;
                                        $b_vat_perc = $this->contract_details['vat'] ?? 0;
                                        $debit = number_format(($b_unit_price * (float)$duration) + (($b_unit_price * (float)$duration) * ((float)$b_vat_perc / 100)), 3, '.', '');
                                        
                                        $this->varPDOModelObj->executeQuery("
                                            INSERT INTO tbl_customer_ledger
                                            (customer_code, quotation_no, booking_no, trans_date, trans_type, payment_method, debit, credit, ref_no, description, user_id, company_id, created_at, booking_ids, contract_ids, agreement_no)
                                            VALUES
                                            (:customer_code, '', '', :trans_date, 'Direct Contract Rentout', 'N/A', :debit, 0, :ref_no, :description, :user_id, :company_id, :created_at, :booking_ids, :contract_ids, :agreement_no)
                                        ", [
                                            ':customer_code' => $this->customer_data['customer_code'] ?? '',
                                            ':trans_date'    => date('Y-m-d'),
                                            ':debit'         => $debit,
                                            ':ref_no'        => $inserted_agreement_no,
                                            ':description'   => 'Rentout from Direct Contract (Agreement No: ' . $inserted_agreement_no . ')',
                                            ':user_id'       => $this->user_id,
                                            ':company_id'    => $this->company_id,
                                            ':created_at'    => date('Y-m-d H:i:s'),
                                            ':booking_ids'   => $this->booking_ids,
                                            ':contract_ids'  => $inserted_contract_id,
                                            ':agreement_no'  => $inserted_agreement_no
                                        ]);
                                    }
                                }
                                echo json_encode([
                                    "status" => true,
                                    "message" => "Saved successfully",
                                    "data" => $this->ReturnData
                                ]);
                        
                                Logger::ActivityLog(
                                    'VehiclesContractController',
                                    "default",
                                    [$this->ReturnData]
                                );
                        
                            } catch (Exception $e) {
                        
                                echo json_encode([
                                    "status" => false,
                                    "message" => $e->getMessage()
                                ]);
                            }
                        }

                            
                        
                        break;
           
            case 'LoadTermsCondition':

                $defaultHtml = '<div dir="rtl" style="text-align:right; line-height:1.6;"><p>1 - لا يحق للمستأجر تسليم السيارة لشخص آخر لاستعمالها دون موافقة الشركة.<br>2 - لا يسمح بالتدخين بداخل السيارة وإذا خالف المستأجر هذا الشرط يتحمل مبلغ وقدره 15 دينار.<br>3 - يتوجب على المستأجر فحص السيارة قبل استلامها والتأكد من وجود جميع الأجهزة واللوازم الخاصة بالمركبة وفي حال ضياعها أو تلفها يلتزم المستأجر بدفع قيمتها.<br>4 - يتعهد المستأجر بإشعار إدارة المرور في حال وقوع حادث للمركبة.<br>5 - يتحمل المستأجر مبلغ 9 دينار لكل يوم طيلة توقف المركبة عن العمل بسبب حادث تسبب فيه أو تلف للسيارة.<br>6 - في حال تخلف المستأجر عن دفع الأجار لمدة 7 أيام من التاريخ المتفق عليه للدفع أو مخالفة أحد شروط هذا العقد يحق للشركة سحب السيارة أينما كانت وبدون إخطار مسبق للمستأجر ولا تتحمل الشركة فقدان المقتنيات الشخصية والأموال المتعلقة بالمستأجر.</p></div><hr><div dir="ltr" style="text-align:left; line-height:1.6;"><p>1 The renter shall not deliver the car to someone else to use without the company approval.<br>2 SMOKING is not permitted inside the car and if the renter violates this condition shall bear an amount of 15 BD.<br>3 The renter should check the car before the receipt and make sure all the equipment and supplies it is in the car and in case of loss or damage to the equipment or supplies the renter shall pay for the loss.<br>4 The renter undertakes to notify the traffic management in the event of an accident.<br>5 The renter shall bear the amount of 9 BD per day throughout the vehicle stopped working because of an accident or damage to the car.<br>6 In the event that the renter fails to pay the agreed rent within 7 days, or violate the terms and conditions of the agreement the leasing company may withdraw the vehicle without notice to the renter, and the company are not liable for any collectibles or money inside the vehicle.</p></div>';

                $result_tc = $this->varPDOModelObj->selectexecuteQuery(
                    "SELECT * FROM tbl_terms_and_condition_contract WHERE company_id = :company_id ORDER BY ids DESC",
                    [':company_id' => $this->company_id]
                );
                $terms = $result_tc->fetchAll(PDO::FETCH_ASSOC);

                $hasCorruptedArabic = false;
                foreach ($terms as $tRow) {
                    if (strpos((string)($tRow['terms_condition'] ?? ''), '????') !== false) {
                        $hasCorruptedArabic = true;
                        break;
                    }
                }

                if (empty($terms) || $hasCorruptedArabic) {
                    try {
                        $this->varPDOModelObj->executeQuery("ALTER TABLE tbl_terms_and_condition_contract CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci", []);
                        $this->varPDOModelObj->executeQuery("ALTER TABLE tbl_vehicle_rentout_contracts MODIFY terms_condition LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci", []);
                    } catch (Exception $eAlt) {}

                    try {
                        if (empty($terms)) {
                            $this->varPDOModelObj->executeQuery(
                                "INSERT INTO tbl_terms_and_condition_contract (t_c_name, terms_condition, company_id, user_id, is_default, created_at) VALUES (:t_c_name, :terms_condition, :company_id, :user_id, 1, NOW())",
                                [
                                    ':t_c_name' => 'Standard Car Hire Terms & Conditions (AR/EN)',
                                    ':terms_condition' => $defaultHtml,
                                    ':company_id' => $this->company_id,
                                    ':user_id' => $this->user_id ?? 1
                                ]
                            );
                        } else {
                            $this->varPDOModelObj->executeQuery(
                                "UPDATE tbl_terms_and_condition_contract SET terms_condition = :terms_condition WHERE company_id = :company_id AND terms_condition LIKE '%????%'",
                                [
                                    ':terms_condition' => $defaultHtml,
                                    ':company_id' => $this->company_id
                                ]
                            );
                        }
                        $result_tc = $this->varPDOModelObj->selectexecuteQuery(
                            "SELECT * FROM tbl_terms_and_condition_contract WHERE company_id = :company_id ORDER BY ids DESC",
                            [':company_id' => $this->company_id]
                        );
                        $terms = $result_tc->fetchAll(PDO::FETCH_ASSOC);
                    } catch (Exception $eTc) {}
                }
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
                $title = $result['data'][0]['t_c_name'] ?? '';
            
                echo json_encode([
                    'status' => true,
                    'html'   => $htmlContent,
                    'title'  => $title
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

                if (!empty($this->tc_ids)) {
                    // Update existing term
                    $this->ReturnData = $this->varPDOModelObj->UpdateTable(
                        "UPDATE tbl_terms_and_condition_contract 
                         SET t_c_name = :t_c_name, 
                             terms_condition = :terms_condition,
                             user_id = :user_id,
                             created_at = :created_at
                         WHERE ids = :ids AND company_id = :company_id",
                        [
                            ':t_c_name' => $this->t_c_name,
                            ':terms_condition' => $this->terms_condition,
                            ':user_id' => $this->user_id,
                            ':created_at' => date('Y-m-d H:i:s'),
                            ':ids' => $this->tc_ids,
                            ':company_id' => $this->company_id
                        ]
                    );
                    $msg = "Updated successfully";
                } else {
                    // Insert new term
                    $this->ReturnData = $this->varPDOModelObj->AddToTable(
                        "INSERT INTO tbl_terms_and_condition_contract (t_c_name, terms_condition, company_id, user_id, created_at) VALUES (:t_c_name, :terms_condition, :company_id, :user_id, :created_at)",
                        [
                            ':t_c_name' => $this->t_c_name,
                            ':terms_condition' => $this->terms_condition,
                            ':company_id' => $this->company_id,
                            ':user_id' => $this->user_id,
                            ':created_at' => date('Y-m-d H:i:s')
                        ]
                    );
                    $msg = "Saved successfully";
                }
            
                echo json_encode([
                    "status" => true,
                    "message" => $msg,
                    "data" => $this->ReturnData
                ]);
            
            break;
            
            case 'SetDefaultTerm':
                // Reset all for company
                $this->varPDOModelObj->UpdateTable(
                    "UPDATE tbl_terms_and_condition_contract SET is_default = 0 WHERE company_id = :company_id",
                    [':company_id' => $this->company_id]
                );
                
                // Set default for specific ID
                if (!empty($this->tc_ids)) {
                    $this->ReturnData = $this->varPDOModelObj->UpdateTable(
                        "UPDATE tbl_terms_and_condition_contract SET is_default = 1 WHERE ids = :ids AND company_id = :company_id",
                        [':ids' => $this->tc_ids, ':company_id' => $this->company_id]
                    );
                }
                
                echo json_encode([
                    "status" => true,
                    "message" => "Default term set successfully"
                ]);
            break;
            
            case 'checkcontarctgenerate':

                $result = $this->varPDOModelObj->selectexecuteQuery(
                    "SELECT ids,agreement_no
                     FROM tbl_vehicle_rentout_contracts 
                     WHERE booking_ids = :book_ids",
                    [':book_ids' => $this->bookingid]
                );
            
                if ($result->rowCount() >= 1) {
                    $row = $result->fetch(PDO::FETCH_ASSOC);

                        $response = [
                            'status'         => true,
                            'message'        => 'Contract exists',
                            'ids'            => $row['ids'],
                            'agreement_no'   => $row['agreement_no']
                        ];
                    // $response = [
                    //     'status'  => true,
                    //     'message' => 'Contract exists'
                    // ];
            
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
            case 'GenerateDirectContracts':
                try {
                    $data = json_decode($this->json, true);
                    
                    $customer_code = $data['customer_code'] ?? '';
                    $customer_name = $data['customer_name'] ?? '';
                    $company_id = $data['company_id'] ?? ($_SESSION['company_id'] ?? 1);
                    $user_id = $this->user_id ?? ($_SESSION['user_id'] ?? 1);
                    $is_rentout = isset($data['is_rentout']) ? (int)$data['is_rentout'] : 0;
                    
                    $vehicles = $data['vehicles'] ?? [];
                    $booking_details = $data['booking_details'] ?? [];
                    $signatures = $data['signatures'] ?? [];
                    
                    $service_id = $booking_details['service'] ?? '1';
                    $service_text = $booking_details['serviceText'] ?? 'Rental Without Driver';
                    $rate_type_id = $booking_details['rateType'] ?? 'hour';
                    $rate_type_text = $booking_details['rateTypeText'] ?? 'Hourly';
                    $duration = $booking_details['duration'] ?? '0';
                    $b_unit_price = $booking_details['unitPrice'] ?? '0';
                    $b_min_price = $booking_details['minPrice'] ?? '0';
                    $b_vat_perc = $booking_details['vatPerc'] ?? '0';
                    $b_notes = $booking_details['notes'] ?? '';
                    
                    $raw_from_date = $booking_details['fromDate'] ?? date('Y-m-d H:i:s');
                    $raw_to_date = $booking_details['toDate'] ?? date('Y-m-d H:i:s');
                    
                    $from_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $raw_from_date)));
                    $to_date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $raw_to_date)));
                    
                    $contract_ids = [];
                    
                    $this->varPDOModelObj->varDBPDO->beginTransaction();

                    // Fetch Company Code
                    $companyCode = 'AA'; // Default fallback
                    if (!empty($company_id) && $company_id !== 'all') {
                        $stmtComp = $this->varPDOModelObj->selectexecuteQuery(
                            "SELECT company_code FROM tbl_company WHERE ids = :company_id",
                            [':company_id' => $company_id]
                        );
                        $compRow = $stmtComp->fetch(PDO::FETCH_ASSOC);
                        if ($compRow && !empty($compRow['company_code'])) {
                            $companyCode = $compRow['company_code'];
                        }
                    }

                    // Generate Sequence for this company
                    $year = date('Y');
                    $prefix = "$companyCode/AGR/$year/";
                    $sql = "SELECT agreement_no FROM tbl_vehicle_rentout_contracts WHERE agreement_no LIKE :prefix ORDER BY ids DESC LIMIT 1";
                    $stmt = $this->varPDOModelObj->selectexecuteQuery($sql, [':prefix' => "$prefix%"]);
                    $last = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($last && isset($last['agreement_no'])) {
                        $nextNo = (int) substr($last['agreement_no'], -4) + 1;
                    } else {
                        $nextNo = 1;
                    }
                    
                    // Fetch Customer
                    $stmtCust = $this->varPDOModelObj->varDBPDO->prepare("SELECT * FROM customer_details WHERE customer_id = ? LIMIT 1");
                    $stmtCust->execute([$customer_code]);
                    $cData = $stmtCust->fetch(PDO::FETCH_ASSOC) ?: [];
                    $customer_details_json = json_encode([
                        'customer_name' => $cData['customer_name'] ?? $customer_name,
                        'customer_code' => $customer_code,
                        'customer_mobile' => $cData['customer_mobile'] ?? ($cData['mobile'] ?? ''),
                        'customer_email' => $cData['customer_email'] ?? ($cData['email'] ?? ''),
                        'customer_attention' => $cData['customer_attn'] ?? ($cData['attention'] ?? ''),
                        'customer_address' => $cData['customer_addr'] ?? ($cData['address'] ?? '')
                    ]);

                    $terms_condition = $data['terms_and_conditions'] ?? '';
                    
                    foreach ($vehicles as $v) {
                        $vehicle_id = $v['vehicle_id'];
                        
                        $agreement_no = $prefix . str_pad($nextNo, 4, '0', STR_PAD_LEFT);
                        $nextNo++; // increment for next vehicle

                        // Fetch Vehicle
                        $stmtVeh = $this->varPDOModelObj->varDBPDO->prepare("
                            SELECT v.ids as vehicle_id, v.category_id, v.model_id, v.vehicle_number as veh_no, v.vehicle_color, v.vehicle_year,
                                   c.category_name, v.model_names as model_name 
                            FROM tbl_vehicles v 
                            LEFT JOIN tbl_vehicle_category c ON v.category_id = c.ids 
                            WHERE v.ids = ?
                        ");
                        $stmtVeh->execute([$vehicle_id]);
                        $vData = $stmtVeh->fetch(PDO::FETCH_ASSOC) ?: [];

                        $vechile_details_json = json_encode([
                            'vehicle_id' => $vehicle_id,
                            'category_id' => $vData['category_id'] ?? '',
                            'model_id' => $vData['model_id'] ?? '',
                            'veh_no' => $vData['veh_no'] ?? '',
                            'category_name' => $vData['category_name'] ?? '',
                            'model_name' => $vData['model_name'] ?? '',
                            'vehicle_color' => $vData['vehicle_color'] ?? '',
                            'vehicle_year' => $vData['vehicle_year'] ?? ''
                        ]);
                        
                        $chk = $v['checklist'] ?? [];
                        $fuel_out = $v['handover']['fuel_out'] ?? '8';
                        $odo_out = $v['handover']['odo_out'] ?? '0';
                        $salik_out = $v['handover']['salik_out'] ?? '0';
                        $date_out = $v['handover']['dt_out'] ?? date('Y-m-d\TH:i');
                        
                        $contract_details = json_encode([
                            'period_from' => $from_date,
                            'period_to' => $to_date,
                            'rate_type_id' => $rate_type_id,
                            'rate_type' => $rate_type_text,
                            'service_id' => $service_id,
                            'service_name' => $service_text,
                            'duration' => $duration,
                            'unit_price' => $b_unit_price,
                            'min_price' => $b_min_price,
                            'vat' => $b_vat_perc,
                            'total_amt' => number_format(($b_unit_price * (float)$duration) + (($b_unit_price * (float)$duration) * ((float)$b_vat_perc / 100)), 3, '.', ''),
                            'qtn_ref_no' => '',
                            'booking_notes' => $b_notes,
                            'otp_details' => ''
                        ]);

                        $vehicle_accessories_details = json_encode([
                            'chk_tools' => (!empty($chk['tools']) ? 'Yes' : 'No'),
                            'chk_spare' => (!empty($chk['tyre']) ? 'Yes' : 'No'),
                            'chk_wcup' => (!empty($chk['w_cup']) ? 'Yes' : 'No'),
                            'chk_radio' => (!empty($chk['radio']) ? 'Yes' : 'No'),
                            'chk_scratches' => (!empty($chk['scratches']) ? 'Yes' : 'No'),
                            'chk_seats' => (!empty($chk['seats_cleanness']) ? 'Yes' : 'No'),
                            'date_out' => $date_out,
                            'vehicle_km_out' => $odo_out,
                            'fuel_level' => $fuel_out,
                            'cust_driver_cpr' => $v['handover']['cust_driver_cpr'] ?? '',
                            'cust_driver_name' => $v['handover']['cust_driver'] ?? ($v['cust_driver'] ?? ''),
                            'cust_driver_contact_no' => $v['handover']['cust_driver_contact_no'] ?? ($v['cust_driver_contact_no'] ?? ''),
                            'cust_driver_phone' => $v['handover']['cust_driver_phone'] ?? '',
                            'cust_driver_documents' => ['vehicles' => []],
                            'vehicle_images' => [],
                            'car_survey_out' => $v['handover']['car_survey_out'] ?? []
                        ]);

                        $driver_ids = $v['handover']['company_driver_id'] ?? '';
                        $driver_details_json = '[]';
                        if ($driver_ids) {
                            $stmtDriver = $this->varPDOModelObj->varDBPDO->prepare("SELECT * FROM tbl_drivers WHERE ids = ?");
                            $stmtDriver->execute([$driver_ids]);
                            $dData = $stmtDriver->fetch(PDO::FETCH_ASSOC);
                            if ($dData) {
                                $driver_details_json = json_encode([
                                    'driver_id' => $dData['ids'],
                                    'driver_name' => $dData['driver_name'],
                                    'driver_mobile' => $dData['driver_contact_no'],
                                    'driver_license_no' => $dData['license_no'],
                                    'driver_license_issplace' => $dData['license_issue_place'],
                                    'driver_license_issdate' => $dData['license_issue_date'],
                                    'driver_license_expdate' => $dData['license_expiry_date']
                                ]);
                            }
                        }
                        
                        $hirer_base64 = $signatures['hirer_base64'] ?? '';
                        $delivery_base64 = $signatures['delivery_base64'] ?? '';
                        $hirer_name = $signatures['hirer_name'] ?? '';
                        $delivery_name = $signatures['delivery_name'] ?? '';
                        
                        // Upload Base64 images
                        $hirer_sign_path = '';
                        if (strpos($hirer_base64, 'data:image') === 0) {
                            list($type, $hirer_base64) = explode(';', $hirer_base64);
                            list(, $hirer_base64)      = explode(',', $hirer_base64);
                            $hirer_base64 = base64_decode($hirer_base64);
                            $hirer_sign_path = 'uploads/signatures/hirer_' . time() . '_' . $vehicle_id . '.png';
                            file_put_contents($hirer_sign_path, $hirer_base64);
                        }
                        
                        $delivery_sign_path = '';
                        if (strpos($delivery_base64, 'data:image') === 0) {
                            list($type, $delivery_base64) = explode(';', $delivery_base64);
                            list(, $delivery_base64)      = explode(',', $delivery_base64);
                            $delivery_base64 = base64_decode($delivery_base64);
                            $delivery_sign_path = 'uploads/signatures/delivery_' . time() . '_' . $vehicle_id . '.png';
                            file_put_contents($delivery_sign_path, $delivery_base64);
                        }
                        
                        $scratch_path = '';
                        $scratch_base64 = $v['scratch_base64'] ?? '';
                        if (strpos($scratch_base64, 'data:image') === 0) {
                            list($type, $scratch_base64) = explode(';', $scratch_base64);
                            list(, $scratch_base64)      = explode(',', $scratch_base64);
                            $scratch_base64 = base64_decode($scratch_base64);
                            $scratch_path = 'uploads/contract_images/scratch_' . time() . '_' . $vehicle_id . '.png';
                            file_put_contents($scratch_path, $scratch_base64);
                        }
                        
                        $cust_driver_name = $v['handover']['cust_driver'] ?? '';
                        $cust_driver_contact_no = $v['handover']['cust_driver_contact_no'] ?? '';
                        $cust_driver_docs = $v['handover']['cust_driver_documents'] ?? [];
                        
                        $cust_driver_attachments = ['vehicles' => []];
                        foreach ($cust_driver_docs as $doc) {
                            $cust_driver_attachments['vehicles'][] = [
                                'documentName' => $doc['name'] ?? '',
                                'files' => [$doc['file'] ?? '']
                            ];
                        }
                        $cust_driver_attachments_json = empty($cust_driver_attachments['vehicles']) ? '[]' : json_encode($cust_driver_attachments);

                        $rentout_images = $v['handover']['rentout_images'] ?? [];
                        if (!is_array($rentout_images)) {
                            $rentout_images = [];
                        }
                        if ($scratch_path) {
                            $rentout_images[] = $scratch_path;
                        }
                        $images_json = empty($rentout_images) ? '[]' : json_encode(array_values($rentout_images));

                        // Save Contract
                        $query = "INSERT INTO tbl_vehicle_rentout_contracts 
                            (booking_ids, company_id, vehicle_id, customer_code, 
                             agreement_date, service_start_date_time, service_end_date_time, 
                             km_out, contract_details_json,
                             vehicle_accessories_details, vehicle_rentout_images,
                             hirer_signature, hirer_name, hirer_signature_date, hier_signature_status, hirer_signed_ip, hirer_signed_device,
                             delivered_signature, delivered_signatory, delivered_signature_date, delivered_signature_status, delivered_signed_ip, delivered_signed_device,
                             agreement_no, agreement_status,
                             customer_name, customer_details, quotation_number, vehicle_category_id, vehicle_model_id, vehicle_no, vechile_details, service_type, terms_condition, driver_ids, driver_details,
                             customer_driver_name, customer_driver_contact_number, customer_driver_attachments, log_json)
                            VALUES 
                            (0, :company_id, :vehicle_id, :customer_code, 
                             :agreement_date, :rent_from, :rent_to,
                             :odo_out, :contract_details,
                             :accessories, :images,
                             :hirer_sign, :hirer_name, NOW(), :hirer_sign_status, :hirer_ip, :hirer_device,
                             :delivery_sign, :delivery_name, NOW(), :delivery_sign_status, :delivery_ip, :delivery_device,
                             :agreement_no, :agreement_status,
                             :customer_name, :customer_details, :quotation_number, :category_id, :model_id, :veh_no, :vechile_details, :service_type, :terms_condition, :driver_ids, :driver_details,
                             :cust_driver_name, :cust_driver_contact, :cust_driver_attachments, :log_json)";
                             
                        $params = [
                            ':company_id' => $company_id,
                            ':vehicle_id' => $vehicle_id,
                            ':customer_code' => $customer_code,
                            ':agreement_date' => date('Y-m-d'),
                            ':rent_from' => $from_date,
                            ':rent_to' => $to_date,
                            ':odo_out' => $odo_out,
                            ':contract_details' => $contract_details,
                            ':accessories' => $vehicle_accessories_details,
                            ':images' => $images_json,
                            ':hirer_sign' => $hirer_sign_path,
                            ':hirer_name' => $hirer_name,
                            ':hirer_sign_status' => $hirer_sign_path ? 'Yes' : 'No',
                            ':hirer_ip' => $_SERVER['REMOTE_ADDR'] ?? '',
                            ':hirer_device' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                            ':delivery_sign' => $delivery_sign_path,
                            ':delivery_name' => $delivery_name,
                            ':delivery_sign_status' => $delivery_sign_path ? 'Yes' : 'No',
                            ':delivery_ip' => $_SERVER['REMOTE_ADDR'] ?? '',
                            ':delivery_device' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                            ':agreement_no' => $agreement_no,
                            ':agreement_status' => ($is_rentout == 1) ? 'Rentout' : 'Generated',
                            ':customer_name' => $customer_name,
                            ':customer_details' => $customer_details_json,
                            ':quotation_number' => '',
                            ':category_id' => !empty($vData['category_id']) ? $vData['category_id'] : 0,
                            ':model_id' => !empty($vData['model_id']) ? $vData['model_id'] : 0,
                            ':veh_no' => $vData['veh_no'] ?? '',
                            ':vechile_details' => $vechile_details_json,
                            ':service_type' => $service_text,
                            ':terms_condition' => $terms_condition,
                            ':driver_ids' => !empty($driver_ids) ? $driver_ids : 0,
                            ':driver_details' => $driver_details_json,
                            ':cust_driver_name' => $cust_driver_name,
                            ':cust_driver_contact' => $cust_driver_contact_no,
                            ':cust_driver_attachments' => $cust_driver_attachments_json,
                            ':log_json' => json_encode(['user_id' => (int)($this->user_id ?? ($_SESSION['user_id'] ?? 1)), 'datetime' => date('Y-m-d H:i:s')])
                        ];
                        
                        if (!$this->varPDOModelObj->executeQuery($query, $params)) {
                            $err = $this->varPDOModelObj->varDBPDO->errorInfo();
                            throw new Exception("Insert failed: " . json_encode($err));
                        }
                        $new_contract_id = $this->varPDOModelObj->varDBPDO->lastInsertId();
                        
                        if ($new_contract_id) {
                            $contract_ids[] = $new_contract_id;
                            
                            // Update vehicle status to Rentout if requested
                            if ($is_rentout == 1) {
                                // 1. Update Vehicle Status
                                $this->varPDOModelObj->executequery("UPDATE tbl_vehicles SET vehicle_status = 'Rentout' WHERE ids = " . intval($vehicle_id));
                                
                                // 2. Add log to movement
                                $this->varPDOModelObj->executeQuery("
                                    INSERT INTO tbl_vehicle_log_movement 
                                    (vehicle_ids, vehicle_no, log_datetime, action_type, reference_type, reference_id, reference_no, odometer, fuel_level, customer_id, created_by, created_name, created_on)
                                    VALUES 
                                    (:vehicle_id, :vehicle_no, NOW(), 'Rentout', 'Direct Contract', :reference_id, :reference_no, :odometer, :fuel_level, :customer_code, :user_id, :created_name, NOW())
                                ", [
                                    ':vehicle_id' => $vehicle_id,
                                    ':vehicle_no' => $vData['veh_no'] ?? '',
                                    ':reference_id' => $new_contract_id,
                                    ':reference_no' => $agreement_no,
                                    ':odometer' => $odo_out,
                                    ':fuel_level' => $fuel_out,
                                    ':customer_code' => $customer_code,
                                    ':user_id' => $user_id,
                                    ':created_name' => $_SESSION['full_name'] ?? 'System'
                                ]);

                                // 3. Customer Ledger
                                $transTypeStr = 'Direct Contract Rentout';
                                $vDesc = 'Rentout from Direct Contract (Agreement No: ' . $agreement_no . ')';
                                $debit = number_format(($b_unit_price * (float)$duration) + (($b_unit_price * (float)$duration) * ((float)$b_vat_perc / 100)), 3, '.', '');

                                try {
                                    $this->varPDOModelObj->executeQuery("
                                        INSERT INTO tbl_customer_ledger
                                        (customer_code, quotation_no, booking_no, trans_date, trans_type, payment_method, debit, credit, ref_no, description, user_id, company_id, created_at, booking_ids, contract_ids, agreement_no)
                                        VALUES
                                        (:customer_code, '', '', :trans_date, :trans_type, 'N/A', :debit, 0, :ref_no, :description, :user_id, :company_id, :created_at, 0, :contract_ids, :agreement_no)
                                    ", [
                                        ':customer_code' => $customer_code,
                                        ':trans_date'    => date('Y-m-d'),
                                        ':trans_type'    => $transTypeStr,
                                        ':debit'         => $debit,
                                        ':ref_no'        => $agreement_no,
                                        ':description'   => $vDesc,
                                        ':user_id'       => $user_id,
                                        ':company_id'    => $company_id,
                                        ':created_at'    => date('Y-m-d H:i:s'),
                                        ':contract_ids'  => $new_contract_id,
                                        ':agreement_no'  => $agreement_no
                                    ]);
                                } catch (\Exception $exLedger) {}
                            }
                        }
                    }
                    
                    $this->varPDOModelObj->varDBPDO->commit();
                    
                    echo json_encode([
                        'status' => true,
                        'message' => 'Contracts generated successfully',
                        'contract_ids' => $contract_ids,
                        'contracts' => [
                            [
                                'contract_id' => $contract_ids[0] ?? '',
                                'agreement_no' => $agreement_no ?? '',
                                'customer_code' => $customer_code ?? ''
                            ]
                        ]
                    ]);
                    
                } catch (Exception $e) {
                    if ($this->varPDOModelObj->varDBPDO->inTransaction()) {
                        $this->varPDOModelObj->varDBPDO->rollBack();
                    }
                    echo json_encode(['status' => false, 'message' => 'Error: ' . $e->getMessage()]);
                }
                break;
			default:
        	      $noAction= json_encode([
                    'status'  => false,
                    'message' => "No Action Found..!"
                 ]);
                 echo $noAction;
                 Logger::ActivityLog('VehiclesContractController',"default",[json_decode($noAction)]);
			break;
			
		}
	 }
	
}

$obj = new VehiclesContractController();
$obj->DataRequest($obj->actionevents);

?>
