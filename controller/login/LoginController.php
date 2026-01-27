<?PHP 

class LoginController
{
	  var $varPDOModelObj;
      public $actionevents;
	
	function __construct()
	{
	    $this->varPDOModelObj = new CommonPDOModel();
	    
		$this->actionevents = $_POST['action'] ?? null;
	}

	function SQLArray()
    {
		$array =  array();
        
        $array[0] = "SELECT * FROM meetings WHERE id = ?";

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
		
			default:
			    $this->login_result = $this->varPDOModelObj->ListFromTable($var[0],[1]);
			    Logger::ActivityLog('NoAction',"No Action Found..!",['LoginController: default',json_decode($this->login_result)]);
			    echo json_encode([
                    'status'  => false,
                    'message' => "No Action Found..!"
                ]);
			break;
			
		}
	 }
	
}

$obj = new LoginController();
$obj->DataRequest($obj->actionevents);

?>
