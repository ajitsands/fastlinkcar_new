<?PHP 

class LoginController
{
	  var $varPDOModelObj, $SQLHelperObject;
      public $actionevents,$user_id, $status,  $userID, $password,$JWTkey,$JWT, $formData;
	
	function __construct()
	{
  
       
	    $this->varPDOModelObj = new CommonPDOModel();
	    $this->SQLHelperObject = new SQLHelperClass();
	    
	    $this->key = $_ENV['ENCRIPTION_KEY'];
	   
        $this->encryption = new EncryptionHelper($this->key);
       
        //$this->formData = json_decode($_POST['formData'], true) ?? null;
        
	                $this->actionevents = $_POST['action'] ?? null;
            		$this->user_name = $_POST['userName'] ?? null;
            		//$this->JWTkey = $_POST['jwt_token'] ?? null;
            		$this->userID = 1 ?? null;
            		$pass = $_POST['passWord'] ?? null;
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
			     $EncPassword = $this->encryption->encrypt($_POST['passWord']);
			     if($authentication = 'success')
			     {
			            $this->JWT = new JWTClass($_ENV['JWTKEY'],$_ENV['MAINSERVER'],$this->user_name); 
        			    $JWToken=  $this->JWT->CreateJWToken($_POST['companyId'], $_POST['userName'], $this->userID, $EncPassword, $this->status, (60 * 60 * 24 * 7)); // Token for 7 Days
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

                        // $options = array(
                        //     "where"=>array(
                        //         "conditions"=>array(
                        //             array(
                        //                 "column"=>"id",
                        //                 "operator"=>"=",
                        //                 "value"=>10
                        //             ),
                        //             array(
                        //                 "column"=>"quotation_date",
                        //                 "operator"=>"BETWEEN",
                        //                 "value"=>array("2026-03-01","2026-03-31")
                        //             )
                        //         )
                        //     )
                        // );
                        
                        // $data = SQLHelperClass::select("quotations",$options);
                        // $res= $this->varPDOModelObj->ListFromTable($data['sql'],$data['values']);
                        // echo $res;
                        
                         $data = SQLHelperClass::insert("tbl_users",$this->formData);
                         $res= $this->varPDOModelObj->AddToTable($data['sql'],$data['values']);
                         
                         
                         
                        //  $options = array(
                        //     "where"=>array(
                        //         "conditions"=>array(
                        //             array(
                        //                 "column"=>"user_id",
                        //                 "operator"=>"=",
                        //                 "value"=>50
                        //             )
                        //         )
                        //     )
                        // );
                        //  $data = SQLHelperClass::update("tbl_users",$this->formData,$options);
                        //  $res= $this->varPDOModelObj->UpdateTable($data['sql'],$data['values']);
                        //  echo $res;
                        
                        // $data = SQLHelperClass::delete("tbl_users",$this->formData,$options);
                        // $res= $this->varPDOModelObj->DeleteFromTable($data['sql'],$data['values']);
                         echo $res;
                        
                        //echo $data['sql'].'--'.var_dump($data['values']);
    
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
                    
?>


