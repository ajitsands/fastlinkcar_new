<?PHP 
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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
            terms_condition
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
            :terms_condition
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
			
             case 'ListBookings':

                        $baseQuery = "SELECT *,DATE_FORMAT(book_from_date, '%d-%m-%Y %H:%i') AS from_date_format,
    DATE_FORMAT(book_to_date, '%d-%m-%Y %H:%i') AS to_date_format FROM tbl_vehicle_bookings WHERE company_id = :company_id";

                           
                            $params = [
                                ':company_id' => $this->company_id
                            ];
                            
                            if (
                                !($this->customer_code == '' || $this->customer_code == 'All')
                            ) {
                                $baseQuery .= " AND customer_code = :customer_code";
                                $params[':customer_code'] = $this->customer_code;
                            }
                            
                            if ($this->filter_from != '' && $this->filter_to != '') {

                                $baseQuery .= "
                                    AND (
                                        (
                                            DATE(book_from_date) BETWEEN :filter_from1 AND :filter_to1
                                        )
                                        OR
                                        (
                                            DATE(book_to_date) BETWEEN :filter_from2 AND :filter_to2
                                        )
                                        OR
                                        (
                                            DATE(book_from_date) <= :filter_from3
                                            AND DATE(book_to_date) >= :filter_to3
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
                                $baseQuery .= " AND book_status = :booking_status";
                                $params[':booking_status'] = $this->booking_status;
                            }
                            
                            $baseQuery .= " ORDER BY ids DESC";
                            
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
                            "from_date_format"  => $row['from_date_format'],
                            "to_date_format"    => $row['to_date_format']
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
                        "SELECT ids,category_id, model_id, category_name, brand_name, model_names, vehicle_number, vehicle_year, vehicle_color,
                                next_insurance_date, next_maintenance_date,next_passing_date,DATE_FORMAT(next_insurance_date, '%d/%m/%Y') AS formatted_next_insurance_date,DATE_FORMAT(next_maintenance_date, '%d/%m/%Y') AS formatted_next_maintenance_date,DATE_FORMAT(next_passing_date, '%d/%m/%Y') AS formatted_next_passing_date  
                         FROM view_vehicle_details 
                         WHERE ids = :vehicle_ids",
                        [':vehicle_ids' => $this->vehicleid]
                    );
                    $vehicle = $result_vehicle->fetch(PDO::FETCH_ASSOC);
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
                        if ($this->data_source_val == 'rentout' && !empty($this->contract_ids))
                        {
                            $this->ReturnData = $this->varPDOModelObj->executeQuery($var[2],
                                            [
                                        
                                                ':booking_ids' => $this->booking_ids,
                                                ':company_id' => $this->company_id,
                                        
                                                ':agreement_no' => $this->generateAgreementNo($this->varPDOModelObj),
                                        
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
                                                ':contract_id' => $this->contract_ids
                                            ]
                                        );
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
                                        ':company_id' => $this->company_id,
                        
                                        ':agreement_no' => $this->generateAgreementNo($this->varPDOModelObj),
                        
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
                                            $this->termsContent
                                    ]
                                );
                             if ($this->ReturnData) {

                                    $updateBookingQuery = "
                                        UPDATE tbl_vehicle_bookings
                                        SET book_status = 'Confirmed'
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
