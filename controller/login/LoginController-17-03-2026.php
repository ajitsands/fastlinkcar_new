<?PHP 

class LoginController
{
	  var $varPDOModelObj, $SQLHelperObject;
      public $actionevents,$user_id, $status,  $userID, $password,$key,$JWT;
	
	function __construct()
	{
	   // $json = file_get_contents('php://input');
    //     $data = json_decode($json, true);
        
        $formData = json_decode($_POST['formData'], true);;
	    //echo $formData;
	    
	    
	    $this->varPDOModelObj = new CommonPDOModel();
	    $this->SQLHelperObject = new SQLHelperClass();
	    
	    $this->key = $_ENV['ENCRIPTION_KEY'];
        $this->encryption = new EncryptionHelper($this->key);
       
		$this->actionevents = $_POST['action'] ?? null;
		$this->user_name = $_POST['userName'] ?? null;
		$this->userID = 1 ?? null;
		
		
		
		$pass = $formData['current-password'] ?? null;
		if($pass != null)
		{
		    $this->password= $this->encryption->encrypt($pass) ?? null;
		}
		$this->status = 'Active' ?? null;
		
		        // Below code is for Check the Event User has the privilage to do the process
		       //$JWTokenFromClient = $_POST['jwt_token'];
		      // $retval=$this->varPDOModelObj->UserStatus($_POST['jwt_token']);
		      // $data = json_decode($retval, true);
		      // if($data['status']==false)
		      // {
		      //     echo $retval;
		      //     exit;
		      // }
		      
		        if(!($data = json_decode($retval = $this->varPDOModelObj->UserStatus($_POST['jwt_token']), true))['status']){
                            echo $retval;
                            exit;
                }
        
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
			 //   echo json_encode([
    //                     'status'  => true,
    //                     'message' => $_POST['formDatas']
    //                 ]);
                
                        // $options = array(
                        //     'joins' => array(
                        //         array('type'=>'LEFT','table'=>'orders','on'=>'users.id = orders.user_id')
                        //     ),
                        //     'where' => array(
                        //         'logic'=>'AND',
                        //         'conditions'=>array(
                        //             array('column'=>'users.id','operator'=>'IN','value'=>array(1,2,3)),
                        //             array('column'=>'users.date','operator'=>'BETWEEN','value'=>array('2026-01-01','2026-01-31')),
                        //             array('logic'=>'OR','conditions'=>array(
                        //                 array('column'=>'users.status','operator'=>'=','value'=>'active'),
                        //                 array('column'=>'users.status','operator'=>'=','value'=>'pending')
                        //             ))
                        //         )
                        //     ),
                        //     'order_by' => array('users.name'=>'ASC','users.id'=>'DESC'),
                        //     'limit' => 10,
                        //     'offset' => 5
                        // );
                    
                        $options = array(
                            "where"=>array(
                                "conditions"=>array(
                                    array(
                                    "column"=>"id",
                                    "operator"=>"=",
                                    "value"=>10
                                    ),
                                    array(
                                    "column"=>"quotation_date",
                                    "operator"=>"BETWEEN",
                                    "value"=>array("2026-03-01","2026-03-31")
                                    )
                                )
                            )
                        );
                        
                        $data = SQLHelperClass::select("quotations",$options);
                        $res= $this->varPDOModelObj->ListFromTable($data['sql'],$data['values']);
                        echo $res;
    
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


