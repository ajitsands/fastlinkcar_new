<?PHP 

class OtherEventController
{
	  var $varPDOModelObj, $SQLHelperObject;
      public $actionevents,$user_id, $status,  $userID, $password,$JWTkey,$JWT, $formData;
	
	function __construct()
	{
  
       
	    $this->varPDOModelObj = new CommonPDOModel();
	    $this->SQLHelperObject = new SQLHelperClass();
	    
	    $this->key = $_ENV['ENCRIPTION_KEY'];
	   
        $this->encryption = new EncryptionHelper($this->key);
       
	            $this->actionevents = $_POST['action'] ?? null;
                $this->formData = json_decode($_POST['formData'], true) ?? null;
    	        
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
                        
                        //  $data = SQLHelperClass::insert("tbl_users",$this->formData);
                        //  $res= $this->varPDOModelObj->AddToTable($data['sql'],$data['values']);
                         
                         
                         
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
                         $options = array(
                            "where"=>array(
                                "conditions"=>array(
                                    array(
                                        "column"=>"user_id",
                                        "operator"=>"=",
                                        "value"=>$this->formData['user_id']
                                    )
                                )
                            )
                        );
                        $data = SQLHelperClass::delete("tbl_users",$options);
                        $res= $this->varPDOModelObj->DeleteFromTable($data['sql'],$data['values']);
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

$obj = new OtherEventController();
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


