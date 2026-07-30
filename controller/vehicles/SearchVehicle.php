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
        
        
            $array[0] = "SELECT ids AS id,model_names,vehicle_number,vehicle_year,vehicle_color FROM   tbl_vehicles
                        WHERE
                            vehicle_number LIKE ?
                            OR model_names LIKE ?
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
			case 'SearchVehicle':
			   
			    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[0],$this->params[0]);
			   
                Logger::ActivityLog('Action',"SearchVehicle",['StaffController: SearchVehicle',"Vehicle ID : ".$this->ReturnData]);
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
