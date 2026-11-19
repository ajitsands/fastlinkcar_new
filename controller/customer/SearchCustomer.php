<?PHP 
header('Content-Type: application/json');

class CustomerController
{
	  var $varPDOModelObj;
      public $actionevents,$json,$search;
	
	function __construct()
	{
	    $this->varPDOModelObj = new CommonPDOModel();
	    
        
        $this->search = $_GET['q'] ?? null;
       
        $this->actionevents = $_GET['action'] ?? null;
        
	}
	

	function SQLArray()
    {
		$array =  array();
        
        
            $array[0] = "SELECT customer_id AS id,customer_id AS customer_code, customer_name, customer_mobile, customer_type,customer_address,customer_email,customer_addr,customer_attn,customer_cr_cpr,status,is_blacklisted,blacklist_description
                        FROM customer_details
                        WHERE
                            customer_name LIKE ?
                            OR customer_mobile LIKE ?
                            OR customer_cr_cpr LIKE ?
                        LIMIT 20";
            $search = '%' . $this->search . '%';
            $this->params[0] = 
                [
                    $search,
                    $search,
                    $search
                ];




    

		return $array;
	}
	function DataRequest($action)
	{
	 	$var =  $this->SQLArray();
		switch($action)
		{
			case 'SearchCustomer':
			   
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[0],$this->params[0]);
			   
                Logger::ActivityLog('Action',"AddNewCustomer",['CustomerController: SearchCustomer',"Customer ID : ".$this->ReturnData]);
			    $response = json_decode($this->ReturnData, true);
                echo json_encode($response['data']);
		
          
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
