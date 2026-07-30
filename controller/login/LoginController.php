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
			     $userName = $_POST['userName'] ?? '';
			     $passWord = $_POST['passWord'] ?? '';
			     $companyId = $_POST['companyId'] ?? 1;
			     
			     // Authenticate against database (Plain Text as requested)
			     $sql = "SELECT user_id, user_name, user_role_name,profile_image,profile_name FROM tbl_users WHERE user_name = ? AND user_passkey = ? AND user_status = 'Active'";
			     $res = json_decode($this->varPDOModelObj->ListFromTable($sql, [$userName, $passWord]), true);
			     
			     if($res['status'] && !empty($res['data']))
			     {
			            $user = $res['data'][0];
			            
			            // Populate Session
			             $_SESSION['profile_name'] = $user['profile_name'];
			            $_SESSION['user_id'] = $user['user_id'];
			            $_SESSION['user_name'] = $user['user_name'];
			            $_SESSION['user_role_name'] = $user['user_role_name'];
			             $_SESSION['user_image'] = $user['profile_image'];
			            $_SESSION['company_id'] = $companyId;
			           
			            $this->JWT = new JWTClass($_ENV['JWTKEY'], $_ENV['MAINSERVER'], $userName); 
        			    $JWToken = $this->JWT->CreateJWToken($companyId, $userName, $user['user_id'], $passWord, 'Active', (60 * 60 * 24 * 7)); // Token for 7 Days
        			     $sql_company = "SELECT ids,company_code,company_name,company_logo FROM tbl_company WHERE ids = ? ";
			     $res_company = json_decode($this->varPDOModelObj->ListFromTable($sql_company, [$companyId]), true);
			     {
			          $company_details = $res_company['data'][0];
			          $_SESSION['company_name'] = $company_details['company_name'];
			          $_SESSION['company_code'] = $company_details['company_code'];
			     }
        			    echo json_encode([
                            'status'  => true,
                            'data' => $JWToken,
                            'message' => 'Login Successful'
                        ]);
			     }
			     else
			     {
			         echo json_encode([
                            'status'  => false,
                            'message' => 'Authentication Failed. Please check your username or password.'
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


