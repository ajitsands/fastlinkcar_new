<?PHP 
header('Content-Type: application/json');

class CustomerController
{
	  var $varPDOModelObj;
      public $actionevents, $json, $client_json;
      public $customer_name, $customer_type, $telephone, $email, $cprcr, $attention, $address, $company_id, $params = [];

	
	function __construct()
	{
	    $this->varPDOModelObj = new CommonPDOModel();
	    
	
        $this->json = file_get_contents("php://input");
        
        
       $this->json = file_get_contents("php://input");

        if (!$this->json) {
            echo json_encode([
                "status" => "error",
                "message" => "No input data received"
            ]);
            exit;
        }

        // Decode JSON
        $data = json_decode($this->json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid JSON"
            ]);
            exit;
        }
        
        $this->customer_name = isset($data['customer_name']) && $data['customer_name'] !== "" ? $data['customer_name'] : null;
        $this->customer_type = isset($data['customer_type']) && $data['customer_type'] !== "" ? $data['customer_type'] : null;
        $this->telephone     = isset($data['telephone']) && $data['telephone'] !== "" ? $data['telephone'] : null;
        $this->email         = isset($data['email']) && $data['email'] !== "" ? $data['email'] : null;
        $this->cprcr         = isset($data['cprcr']) && $data['cprcr'] !== "" ? $data['cprcr'] : null;
        $this->attention     = isset($data['attention']) && $data['attention'] !== "" ? $data['attention'] : null;
        $this->address       = isset($data['address']) && $data['address'] !== "" ? $data['address'] : null;

        $this->client_json = isset($data['clientsDoc']) ? json_encode($data['clientsDoc']) : json_encode([]);

        $this->actionevents = isset($data['action']) ? $data['action'] : null;
        $this->company_id = $_SESSION['company_id'] ?? 1;
        
	}
	

	function SQLArray()
    {
		$array =  array();
        
        
        $array[0] = "INSERT INTO customer_details 
                    (customer_name, customer_type,customer_mobile,customer_email,customer_addr,customer_attn,customer_cr_cpr,client_docs,company_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $this->params[0] = [
                $this->customer_name,
                $this->customer_type,
                $this->telephone,
                $this->email,
                $this->address,
                $this->attention,
                $this->cprcr,
                $this->client_json,
                $this->company_id
                
            ];




    

		return $array;
	}
	function DataRequest($action)
	{
	 	$var =  $this->SQLArray();
		switch($action)
		{
			case 'AddNewCustomer':
			    if (count($this->params[0]) !== 9) {
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
