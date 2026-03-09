<?PHP 
header('Content-Type: application/json');

class GetCustomerDetailsController
{
	  var $varPDOModelObj;
      public $actionevents,$json;
      public $customer_id, $params =  array();
	
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
        
        $this->customer_id   = $data['customer_id'];
        $this->actionevents = $data['action'] ?? null;
        
	}
	

	function SQLArray()
    {
		$array =  array();
        
        
        $array[0] = "SELECT 
                        customer_id,
                        customer_name,
                        customer_type,
                        customer_mobile,
                        customer_address
                    FROM customer_details
                    WHERE customer_id = ?
                    LIMIT 1";
            
            $this->params[0] = [
                $this->customer_id
            ];

		return $array;
	}
	function DataRequest($action)
	{
	 	$var =  $this->SQLArray();
		switch($action)
		{
			case 'getCustomerDetails':
			    if (count($this->params[0]) !== 1) {
                    throw new Exception("Parameter count mismatch: " . count($this->params[0]));
                }
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[0], $this->params[0]);
			    //echo $this->ReturnData;
                $responseData = json_decode($this->ReturnData, true); // first decode

                if (isset($responseData['data'][0]['customer_address'])) {
                    $responseData['data'][0]['customer_address'] =
                        json_decode($responseData['data'][0]['customer_address'], true);
                }
                
                
			    $customerResponse = json_encode([
                    'status'  => true,
                    'message' => "Search Customer",
                    'data' => $responseData['data'][0]
                ]);
                Logger::ActivityLog('Action',"getCustomerDetails",['GetCustomerDetailsController - 88 ',$customerResponse]);
                echo $customerResponse;
               
			    
          
		    break;
			default:
			        
			       $val = json_encode([
                            'status'  => false,
                            'message' => "No Action Found..! in GetCustomerDetailsController"
                        ]);
                  Logger::ActivityLog('Action'," GetCustomerDetailsController Default - 98",[$val]);
        	      echo $val; 
                 
			    
			break;
			
		}
	 }
	
}

$obj = new GetCustomerDetailsController();
$obj->DataRequest($obj->actionevents);

?>
