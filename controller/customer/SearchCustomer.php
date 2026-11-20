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
        
        
            $array[0] = "SELECT cd.customer_id AS id, cd.customer_id AS customer_code, cd.customer_name, cd.customer_mobile, cd.phone_1, cd.customer_type, cd.customer_address, cd.customer_email, cd.customer_addr, cd.customer_attn, cd.customer_cr_cpr, cd.nationality, cd.license_no, cd.license_issue_place, cd.license_expiry_date, cd.customer_account_id, ca.account_name, cd.status, cd.is_blacklisted, cd.blacklist_description
                        FROM customer_details cd
                        LEFT JOIN tbl_customer_accounts ca ON ca.ids = cd.customer_account_id
                        WHERE
                            cd.customer_name LIKE ?
                            OR cd.customer_mobile LIKE ?
                            OR cd.customer_cr_cpr LIKE ?
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
