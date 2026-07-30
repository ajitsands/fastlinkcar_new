<?PHP 
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class VehiclesContractController
{
	  var $varPDOModelObj;
      public $actionevents,$json;
	  public $user_id,$company_id,$insertedDate,$bookingid;
	  public $page, $limit, $offset, $status;
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
          $array[0] = "SELECT * FROM tbl_vehicle_bookings ORDER BY ids DESC";
          
          
        // $array[0] = "INSERT INTO tbl_vehicles
        //                 (category_id,model_id,model_names,brand_id,company_id,vehicle_number,vehicle_year,vehicle_color,image_json,other_details_json,vehicle_attachments,vehicle_status,created_on,created_by,vehicle_purchase_date) VALUES
        //                 (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // $this->params[0] = [
        //         $this->category_id,
        //         $this->vehicleModal,
        //         $this->modelName,
        //         $this->brand_id,
        //         $this->company_id,
        //         $this->vehicleRegNumber,
        //         $this->vehicleYear,
        //         $this->vehicleColor,
        //         $this->vehicleimages,
        //         $this->vehicleDetails,
        //         $this->vehiclesDocObj,
        //         'Available',
        //         $this->insertedDate,
        //         $this->user_id,
        //         $this->vehiclePurchaseDate
        // ];
        
      

		return $array;
	}
	function DataRequest($action)
	{
	 	$var =  $this->SQLArray();
		switch($action)
		{
			
             case 'ListBookings':
			    
			    $result  = $this->varPDOModelObj->selectexecuteQuery($var[0]);
			   
                
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
                                "cancelled_count" => 0    // ✅ initialize
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
                        if (in_array($status, ['return'])) {
                            $data[$bookingNo]["return_count"]++;
                        }
                        if (in_array($status, ['cancelled'])) {
                            $data[$bookingNo]["cancelled_count"]++;
                        }
                    
                        // ✅ Add child entry
                        $data[$bookingNo]["entries"][] = [
                            "id"=> $row['ids'],
                            "ids" => $row['ids'],
                             "booking_ref"     => $bookingNo,
                            "vehicle_no" => $row['vehicle_no'],
                            "brand_name" => $row['brand_name'],
                            "book_status" => $row['book_status'],
                            "model_name" => $row['model_name'],
                            "from_date"  => $row['book_from_date'],
                            "to_date"    => $row['book_to_date']
                        ];
                    }
                    
                    echo json_encode([
                        "data" => array_values($data)
                    ]);
			    
            break;
		   case 'GetContractDetails':
		       $result = $this->varPDOModelObj->selectexecuteQuery(
                    "SELECT * FROM tbl_vehicle_rentout_contracts WHERE booking_ids = :booking_id",
                    [':booking_id' => $this->bookingid]
                );
                
                $contract = $result->fetch(PDO::FETCH_ASSOC); // ✅ single row
                
                if ($contract) {
                    $data = $contract;
                } else {
                    // fallback to booking
                    $result1 = $this->varPDOModelObj->selectexecuteQuery(
                        "SELECT * FROM tbl_vehicle_bookings WHERE ids = :booking_id",
                        [':booking_id' => $this->bookingid]
                    );
                
                    $data = $result1->fetch(PDO::FETCH_ASSOC); // ✅ single row
                }

                echo json_encode($data ?: ['error' => 'No data found']);
		       
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
