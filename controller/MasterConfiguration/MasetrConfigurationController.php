<?PHP 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class MasterConfigurationController
{
	  var $varPDOModelObj;
      public $actionevents,$json;
      public  $params =  array();
      public $CategoryId, $CategoryName, $CategoryDesc, $CategoryStatus, $ReturnData,$category_image,$category_image_tmp;
      public $BrandId, $BrandName, $BrandDesc, $BrandStatus, $brand_image,$brand_image_tmp;
      public $ModelId, $ModelName, $ModelDesc, $ModelStatus, $model_image,$model_image_tmp,$category_id;
      public $PriceItemName,$items;
	  public $user_id,$company_id,$insertedDate;
	function __construct()
	{
	    $this->varPDOModelObj = new CommonPDOModel();
	    
	     $this->CategoryId = $_POST['id'] ?? '';
        $this->CategoryName = $_POST['categoryName'] ?? '';
        $this->CategoryDesc   = $_POST['categoryDescription'] ?? '';
        $this->CategoryStatus = $_POST['status'] ?? 'Active';
	    $this->category_image = $_FILES['categoryImage']['name'] ?? null;
        $this->category_image_tmp = $_FILES['categoryImage']['tmp_name'] ?? null;
         $this->BrandId = $_POST['brand_id'] ?? '';
        $this->BrandName = $_POST['brandName'] ?? '';
        $this->BrandDesc   = $_POST['brandDescription'] ?? '';
        $this->BrandStatus = $_POST['brand_status'] ?? 'Active';
	    $this->brand_image = $_FILES['brandImage']['name'] ?? null;
        $this->brand_image_tmp = $_FILES['brandImage']['tmp_name'] ?? null;
        
         $this->ModelId = $_POST['model_id'] ?? '';
        $this->ModelName = $_POST['modelName'] ?? '';
        $this->ModelDesc   = $_POST['modelDescription'] ?? '';
        $this->ModelStatus = $_POST['model_status'] ?? 'Active';
	    $this->model_image = $_FILES['modelImage']['name'] ?? null;
        $this->model_image_tmp = $_FILES['modelImage']['tmp_name'] ?? null;
         $this->category_id = $_POST['category_id'] ?? '';
         
         $this->PriceItemName = $_POST['priceItem'] ?? '';
          $this->items = $_POST['items'] ?? '';
        
        
        date_default_timezone_set('Asia/Bahrain');
        
        
        $this->actionevents = $_POST['action'] ?? null;
       
        $this->company_id = $_SESSION['company_id'] ?? 1;
        $this->user_id = $_SESSION['user_id'] ?? 1;
        $this->insertedDate = date('Y-m-d');
        
        
        

	}
	function onOff($val) {
        return ($val === 'on') ? 1 : 0;
    }
   function uploadMasterImage($folderpath,$temp_image,$real_image)
    {
        if (!empty($temp_image)) {
    
            $imageInfo = getimagesize($temp_image);
    
            if ($imageInfo === false) {
                return [
                    'status' => false,
                    'message' => 'Uploaded file is not a valid image'
                ];
            }
    
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    
            $fileExt = strtolower(pathinfo($real_image, PATHINFO_EXTENSION));
    
            if (!in_array($fileExt, $allowedExtensions)) {
                return [
                    'status' => false,
                    'message' => 'Invalid image extension'
                ];
            }
    
            if (!is_dir($folderpath)) {
                mkdir($folderpath, 0777, true);
            }
    
            // ✅ Generate unique file name
            $fileName = uniqid() . '.' . $fileExt;
    
            $destination = $folderpath.'/' . $fileName;
    
            // ✅ Move file
            if (move_uploaded_file($temp_image, $destination)) {
                return [
                    'status' => true,
                    'file' => $fileName
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Failed to upload image'
                ];
            }
        }
    
        return [
            'status' => true,
            'file' => ''
        ];
    }
   
	function SQLArray()
    {
		$array =  array();
        
       
        $array[3] = "SELECT * FROM tbl_vehicle_category ORDER BY ids DESC";
        $array[4] = "SELECT * FROM tbl_vehicle_brand ORDER BY ids DESC";
        $array[5] = "SELECT * FROM  tbl_vehicle_model ORDER BY ids DESC";
         $array[6] = "SELECT * FROM  tbl_vehicle_model ORDER BY modal_name ASC";
        
		return $array;
	}
	function DataRequest($action)
	{
	 	$var =  $this->SQLArray();
		switch($action)
		{
			
          case 'save_category':

                // ✅ Upload image first
                $upload = $this->uploadMasterImage('httpdocs/images/vehicle_category_images',$this->category_image_tmp,$this->category_image);
            
                if (!$upload['status']) {
                    echo json_encode([
                        'success' => false,
                        'message' => $upload['message']
                    ]);
                    exit;
                }
            
                $imageName = $upload['file'];
            
                if (empty($this->CategoryId)) {
            
                    if (!empty($imageName)) {
                        $imageName=$imageName;
                    }
                    else
                    {
                        $imageName='default.jpg';
                    }
                    $query = "INSERT INTO tbl_vehicle_category 
                    (category_name, category_image, category_description, category_status)
                    VALUES (?, ?, ?, ?)";
            
                    $params = [
                        $this->CategoryName,
                        $imageName,
                        $this->CategoryDesc,
                        $this->CategoryStatus
                    ];
            
                    $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn(
                        $query,
                        'ids',
                        'tbl_vehicle_category',
                        $params
                    );
            
                } else {
            
                    // UPDATE
                    if (!empty($imageName)) {
            
                        $query = "UPDATE tbl_vehicle_category 
                        SET category_name=?, category_image=?, category_description=?, category_status=? 
                        WHERE ids=?";
            
                        $params = [
                            $this->CategoryName,
                            $imageName,
                            $this->CategoryDesc,
                            $this->CategoryStatus,
                            $this->CategoryId
                        ];
            
                    } else {
            
                        $query = "UPDATE tbl_vehicle_category 
                        SET category_name=?, category_description=?, category_status=? 
                        WHERE ids=?";
            
                        $params = [
                            $this->CategoryName,
                            $this->CategoryDesc,
                            $this->CategoryStatus,
                            $this->CategoryId
                        ];
                    }
            
                    $this->varPDOModelObj->UpdateTable($query, $params);
                }
            
                echo json_encode([
                    'success' => true,
                    'message' => 'Saved Successfully'
                ]);
            
            break;
    		case 'get_categories':
    
                $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[3]);
            
                echo json_encode([
                    "status" => "success",
                    "data" => json_decode($this->ReturnData, true)
                ]);
                
                break;
		
           case 'change_status':

                $query = "UPDATE tbl_vehicle_category 
                          SET category_status = 
                          CASE 
                              WHEN category_status = 'Active' THEN 'Deactive'
                              ELSE 'Active'
                          END
                          WHERE ids = ?";
            
                $this->varPDOModelObj->UpdateTable($query, [$this->CategoryId]);
            
                echo json_encode([
                    "success" => true,
                    "message" => "Status Updated"
                ]);
            
            break;
            
            
             case 'save_brand':

                // ✅ Upload image first
                $upload = $this->uploadMasterImage('httpdocs/images/vehicle_brand_images',$this->brand_image_tmp,$this->brand_image);
            
                if (!$upload['status']) {
                    echo json_encode([
                        'success' => false,
                        'message' => $upload['message']
                    ]);
                    exit;
                }
            
                $imageName = $upload['file'];
            
                if (empty($this->BrandId)) {
                     if (!empty($imageName)) {
                        $imageName=$imageName;
                    }
                    else
                    {
                        $imageName='default.jpg';
                    }
                    // INSERT
                    $query = "INSERT INTO tbl_vehicle_brand 
                    (brand_name, brand_image, brand_description, brand_status)
                    VALUES (?, ?, ?, ?)";
            
                    $params = [
                        $this->BrandName,
                        $imageName,
                        $this->BrandDesc,
                        $this->BrandStatus
                    ];
            
                    $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn(
                        $query,
                        'ids',
                        'tbl_vehicle_brand',
                        $params
                    );
            
                } else {
            
                    // UPDATE
                    if (!empty($imageName)) {
            
                        $query = "UPDATE tbl_vehicle_brand 
                        SET brand_name=?, brand_image=?, brand_description=?, brand_status=? 
                        WHERE ids=?";
            
                        $params = [
                            $this->BrandName,
                            $imageName,
                            $this->BrandDesc,
                            $this->BrandStatus,
                            $this->BrandId
                        ];
            
                    } else {
            
                        $query = "UPDATE tbl_vehicle_brand 
                        SET brand_name=?, brand_description=?, brand_status=? 
                        WHERE ids=?";
            
                        $params = [
                            $this->BrandName,
                            $this->BrandDesc,
                            $this->BrandStatus,
                            $this->BrandId
                        ];
                    }
            
                    $this->varPDOModelObj->UpdateTable($query, $params);
                }
            
                echo json_encode([
                    'success' => true,
                    'message' => 'Saved Successfully'
                ]);
            
            break;
    		case 'get_brand':
    
                $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[4]);
            
                echo json_encode([
                    "status" => "success",
                    "data" => json_decode($this->ReturnData, true)
                ]);
                
                break;
                
              case 'save_model':

                // ✅ Upload image first
                $upload = $this->uploadMasterImage('httpdocs/images/vehicle_model_images',$this->model_image_tmp,$this->model_image);
            
                if (!$upload['status']) {
                    echo json_encode([
                        'success' => false,
                        'message' => $upload['message']
                    ]);
                    exit;
                }
            
                $imageName = $upload['file'];
            
                if (empty($this->ModelId)) {
                    if (!empty($imageName)) {
                        $imageName=$imageName;
                    }
                    else
                    {
                        $imageName='default.jpg';
                    }
                    // INSERT
                    $query = "INSERT INTO  tbl_vehicle_model 
                    (modal_name, vehicle_modal_pic, model_description, model_status,category_id,brand_id)
                    VALUES (?, ?, ?, ?, ?, ?)";
            
                    $params = [
                        $this->ModelName,
                        $imageName,
                        $this->ModelDesc,
                        $this->ModelStatus,
                        $this->category_id,
                        $this->BrandId
                    ];
            
                    $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn(
                        $query,
                        'ids',
                        'tbl_vehicle_model',
                        $params
                    );
            
                } else {
            
                    // UPDATE
                    if (!empty($imageName)) {
            
                        $query = "UPDATE  tbl_vehicle_model 
                        SET modal_name=?, vehicle_modal_pic=?, model_description=?, model_status=?,  category_id=?,  brand_id=?
                        WHERE ids=?";
            
                        $params = [
                            $this->ModelName,
                            $imageName,
                            $this->ModelDesc,
                            $this->ModelStatus,
                            $this->category_id,
                            $this->BrandId,
                            $this->ModelId
                        ];
            
                    } else {
            
                        $query = "UPDATE  tbl_vehicle_model 
                        SET modal_name=?, model_description=?, model_status=?,  category_id=?,  brand_id=?
                        WHERE ids=?";
            
                        $params = [
                            $this->ModelName,
                            $this->ModelDesc,
                            $this->ModelStatus,
                            $this->category_id,
                            $this->BrandId,
                            $this->ModelId
                        ];
                    }
            
                    $this->varPDOModelObj->UpdateTable($query, $params);
                }
            
                echo json_encode([
                    'success' => true,
                    'message' => 'Saved Successfully'
                ]);
            
            break;
    		case 'get_model':
    
                $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[5]);
            
                echo json_encode([
                    "status" => "success",
                    "data" => json_decode($this->ReturnData, true)
                ]);
                
                break;
                case 'get_model_price':
    
                $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[6]);
            
                echo json_encode([
                    "status" => "success",
                    "data" => json_decode($this->ReturnData, true)
                ]);
                
                break;
                
                case 'add_price_master':
                    $query = "INSERT INTO  tbl_vehicle_pricing_master 
                    (price_item)
                    VALUES (?)";
            
                    $params = [
                        $this->PriceItemName
                    ];
            
                    $this->varPDOModelObj->AddToTableAndReturnSpecifiedColumn(
                        $query,
                        'ids',
                        'tbl_vehicle_pricing_master',
                        $params
                    );
                    echo json_encode([
                    'success' => true,
                    'message' => 'Added Successfully'
                ]);
                break;
               case 'UpdateModelPricing': 
                   
                   $decoded = json_decode($this->items, true);

                    if (!is_array($decoded)) {
                        echo json_encode(['status' => false, 'message' => 'Invalid JSON']);
                        exit;
                    }
                    
                    // ✅ OPTIONAL: clean data (remove unwanted rows)
                    $cleanData = [];
                    
                    foreach ($decoded as $row) {
                    
                        $id = $row['id'] ?? null;
                        $item = $row['item'] ?? '';
                        $amount = $row['amount'] ?? '';
                    
                        if ($this->ModelId !== null) {
                            $cleanData[] = [
                                'ids' => $id,
                                 'item' => $item,
                                'amount' => $amount
                            ];
                        }
                    }
                    
                    // ✅ encode back
                    $json = json_encode($cleanData);
                    
                    // ✅ update DB
                    $sql = "UPDATE tbl_vehicle_model 
                            SET price_json = ? 
                            WHERE ids = ?";
                    $params = [
                          $json,
                        $this->ModelId
                    ];
                  
                    $this->varPDOModelObj->UpdateTable($sql, $params);
                    echo json_encode(['status' => true]);
             
                break;
                
			default:
        	      $noAction= json_encode([
                    'status'  => false,
                    'message' => "No Action Found..!"
                 ]);
                 echo $noAction;
                 Logger::ActivityLog('MasterConfigurationController',"default",[json_decode($noAction)]);
			break;
			
		}
	 }
	
}

$obj = new MasterConfigurationController();
$obj->DataRequest($obj->actionevents);

?>
