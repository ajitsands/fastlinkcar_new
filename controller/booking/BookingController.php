<?PHP 
header('Content-Type: application/json');

class BookingController
{
	  var $varPDOModelObj;
      public $actionevents,$json;
      public $booking, $payments, $drivers, $vehicles, $clients, $params =  array();
	
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
        
        $this->booking  = $data['bookingInfo'] ?? [];
        $this->payments = $data['payments'] ?? [];
        
        $this->drivers  = json_encode($data['drivers'] ?? []);
        $this->vehicles = json_encode($data['vehicles'] ?? []);
        $this->clients  = json_encode($data['clients'] ?? []);
        
        $this->actionevents = $data['action'] ?? null;
        
	}
	function onOff($val) {
        return ($val === 'on') ? 1 : 0;
    }

	function SQLArray()
    {
		$array =  array();
        
        $array[0] = "SELECT * FROM meetings WHERE id = ?";
        
        $array[1] = "INSERT INTO booking_info (
                reg_number, car_id, company_id, company_name, customer_id, customer_name,vehicles_image,
                rent_start_date, rent_end_date, total_days_taken, rent_per_day,
                rent_total_cost, rent_discount_if_any, rent_after_discount,
                rent_tax_any, rent_grand_total,
                jack_and_tools, spare_tyre, radio_yes_no, cd_recorder,
                drivers, vehicles, clients
            ) VALUES (?,?,?,?,?,?,?,
                      ?,?,?,?,?,?,?,?,?,
                      ?,?,?,?,
                      ?,?,?)";
            
            $this->params[0] = [
                $this->booking['regNumber'] ?? null,
                $this->booking['carId'] ?? null,
                $this->booking['companyId'] ?? null,
                $this->booking['companyName'] ?? null,
                $this->booking['customerId'] ?? null,
                $this->booking['customerName'] ?? null,
                $this->booking['carImage'] ?? null,
            
                $this->payments['rent_start_date'] ?? null,
                $this->payments['rent_end_date'] ?? null,
                $this->payments['total_days_taken'] ?? 0,
                $this->payments['rent_per_day'] ?? 0,
                $this->payments['rent_total_cost'] ?? 0,
                $this->payments['rent_discount_if_any'] ?? 0,
                $this->payments['rent_after_discount'] ?? 0,
                $this->payments['rent_tax_any'] ?? 0,
                $this->payments['rent_grand_total'] ?? 0,
            
                $this->onOff($this->payments['jack_and_tools'] ?? null),
                $this->onOff($this->payments['spare_tyre'] ?? null),
                $this->onOff($this->payments['radio_yes_no'] ?? null),
                $this->onOff($this->payments['cd_recorder'] ?? null),
            
                $this->drivers,
                $this->vehicles,
                $this->clients
            ];
            
            $array[2] = "update customer_details set client_docs =JSON_ARRAY_APPEND(COALESCE(client_docs, JSON_ARRAY()),'$',CAST(? AS JSON)),
                        driver_docs =JSON_ARRAY_APPEND(COALESCE(driver_docs, JSON_ARRAY()),'$',CAST(? AS JSON)) WHERE customer_id = ?";
            $this->params[2] = [
                    $this->clients,
                    $this->drivers,
                    $this->booking['customerId'] ?? null,
                ];

		return $array;
	}
	function DataRequest($action)
	{
	 	$var =  $this->SQLArray();
		switch($action)
		{
			case 'login':
			    $this->login_result = $this->varPDOModelObj->ListFromTable($var[0],[1]);
			break;
			case 'confirmBooking':
			    if (count($this->params[0]) !== 23) {
                    throw new Exception("Parameter count mismatch: " . count($this->params[0]));
                }
			    $this->ReturnData = $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn($var[1],'booking_id','booking_info', $this->params[0]);
			    $booking_id = json_decode(
                    json_decode($this->ReturnData, true)['data']['return_booking_id_value'],
                    true
                )['data'][0]['booking_id'] ?? null;
                
                Logger::ActivityLog('confirmBooking',"Booking Confirmed ",['BookingController: conformBooking',"Booking ID : ".$booking_id]);
			   
			    $returnAfterUpdate = $this->varPDOModelObj->UpdateTable($var[2], $this->params[2]);
			    
			    Logger::ActivityLog('confirmBooking',"Return After Booking Updated to Customer Table ".$returnAfterUpdate,['BookingController: conformBooking',$this->params[2],$var[2]]);
			    
			    $outSend = json_encode([
                    'status'  => true,
                    'message' => "Booking Id",
                    'bookingId' => $booking_id
                ]);
                Logger::ActivityLog('confirmBooking',"Send to Client ",[json_decode($outSend)]);
			    echo $outSend;
			break;
		
			default:
			    
        	      $noAction= json_encode([
                    'status'  => false,
                    'message' => "No Action Found..!"
                 ]);
                 echo $noAction;
                 Logger::ActivityLog('confirmBooking',"default",[json_decode($noAction)]);
			break;
			
		}
	 }
	
}

$obj = new BookingController();
$obj->DataRequest($obj->actionevents);

?>
