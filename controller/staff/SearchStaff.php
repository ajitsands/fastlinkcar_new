<?PHP 
header('Content-Type: application/json');

class StaffController
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
        
        
            $array[0] = "SELECT ids AS id,staff_name AS staff_name, staff_contact_no, staff_email_id,staff_cpr_no,license_no,license_issue_place,license_issue_date,license_expiry_date,staff_cpr_expiry_date FROM  tbl_staff
                        WHERE
                            staff_name LIKE ?
                            OR staff_contact_no LIKE ?
                        LIMIT 20";
            $search = '%' . $this->search . '%';
            $this->params[0] = 
                [
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
			case 'SearchStaff':
			   
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[0],$this->params[0]);
			   
                Logger::ActivityLog('Action',"AddNewStaff",['StaffController: SearchStaff',"Staff ID : ".$this->ReturnData]);
			    $response = json_decode($this->ReturnData, true);
                echo json_encode($response['data']);
		
          
		    break;
			default:
			        
			       $val = json_encode([
                            'status'  => false,
                            'message' => "No Action Found..! in StaffController"
                        ]);
                  Logger::ActivityLog('Action',"AddNewStaff",['StaffController: default',$val]);
        	      echo $val; 
                 
			    
			break;
			
		}
	 }
	
}

$obj = new StaffController();
$obj->DataRequest($obj->actionevents);

?>
