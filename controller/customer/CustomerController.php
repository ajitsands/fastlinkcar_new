<?PHP 
header('Content-Type: application/json');

class CustomerController
{
	  var $varPDOModelObj;
      public $actionevents,$json,$client_json;
      public $customer_name, $customer_type, $customer_mobile, $address, $address_json, $params =  array();
	
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
        
        $this->customer_name   = $data['customer_name'];
        $this->customer_type   = $data['customer_type'];
        $this->customer_mobile = $data['customer_mobile'];
        
        $this->address = $data['address'];
        $this->address['customer_mobile'] = $this->customer_mobile; // keep mobile also in JSON
        
        $this->address_json = json_encode($this->address);
        $this->client_json = json_encode($data['clientsDoc']);
        
        $this->actionevents = $data['action'] ?? null;
        
	}
	

	function SQLArray()
    {
		$array =  array();
        
        
        $array[0] = "INSERT INTO customer_details 
                    (customer_name, customer_type, customer_address,customer_mobile,client_docs)
                    VALUES (?, ?, ?, ?, ?)";
            
            $this->params[0] = [
                $this->customer_name,
                $this->customer_type,
                $this->address_json,
                $this->customer_mobile,
                $this->client_json
            ];




    

		return $array;
	}
	function DataRequest($action)
	{
	 	$var =  $this->SQLArray();
		switch($action)
		{
			case 'AddNewCustomer':
			    if (count($this->params[0]) !== 5) {
                    throw new Exception("Parameter count mismatch: " . count($this->params[0]));
                }
			    $this->ReturnData = $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn($var[0],'customer_id','customer_details', $this->params[0]);
			    $customer_id = json_decode(
                    json_decode($this->ReturnData, true)['data']['return_customer_id_value'],
                    true
                )['data'][0]['customer_id'] ?? null;
                
                Logger::ActivityLog('Action',"AddNewCustomer",['CustomerController: AddNewCustomer',"Customer ID : ".$customer_id]);
			    
			    echo json_encode([
                    'status'  => true,
                    'message' => "Customer Added Successfully",
                    'customerId' => $customer_id
                ]);
          
		    break;
			default:
			        
			       $val = json_encode([
                            'status'  => false,
                            'message' => "No Action Found..! in CustomerController"
                        ]);
                  Logger::ActivityLog('Action',"AddNewCustomer",['CustomerController: default',$val]);
        	      echo $val; 
                 
			    
			break;
			
		}
	 }
	
}

$obj = new CustomerController();
$obj->DataRequest($obj->actionevents);

?>
