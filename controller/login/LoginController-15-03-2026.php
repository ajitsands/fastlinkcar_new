<?PHP 

class LoginController
{
	  var $varPDOModelObj;
      public $actionevents,$user_id, $status,  $userID, $password,$key,$JWT;
	
	function __construct()
	{
	    $this->varPDOModelObj = new CommonPDOModel();
	    
	    $this->key = $_ENV['ENCRIPTION_KEY'];
        $this->encryption = new EncryptionHelper($this->key);
       
		$this->actionevents = $_POST['action'] ?? null;
		$this->user_name = $_POST['userName'] ?? null;
		$this->userID = 1 ?? null;
		$pass = $_POST['passWord'] ?? null;
		if($pass != null)
		{
		    $this->password= $this->encryption->encrypt($_POST['passWord']) ?? null;
		}
		$this->status = 'Active' ?? null;
		
		
        
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
			case 'Authenticate':
			     // Please Write Authentication Code here with DB 
			     //if Success Below Code Has to Execute, Belocode G=Generate a JWT Token to Client to Store in Local Storage
			     
			     $authentication ='success';
			     if($authentication = 'success')
			     {
			            $this->JWT = new JWTClass($_ENV['JWTKEY'],$_ENV['MAINSERVER'],$this->user_name); 
        			    $JWToken=  $this->JWT->CreateJWToken($_POST['companyId'], $_POST['userName'], $this->userID, $this->password, $this->status, (60 * 60 * 24 * 7)); // Token for 7 Days
        			    //$this->login_result = $this->varPDOModelObj->ListFromTable($var[0],[1]);
        			    echo json_encode([
                            'status'  => true,
                            'data' => $JWToken
                        ]);
			     }
			     else
			     {
			         echo json_encode([
                            'status'  => false,
                            'message' => 'User Authentication Failed Please check your username or password / contact your administrator'
                        ]);
			     }
			   
			break;
			case 'Validate':
			    $JWTokenFromClient = $_POST['jwt_token'];
			    echo $this->varPDOModelObj->JWTokenToRealJSON($JWTokenFromClient,'user');
               
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
