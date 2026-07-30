<?php
session_start();
header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class VehicleInsightController
{
    var $varPDOModelObj;
    public $json, $actionevents, $ReturnData;
    public $params = array();

    public $brandId, $categoryId, $modelId, $company_id, $user_id, $createdDate, $vehicleNumber, $vehicleId, $vehicle_id, $from,$to,$bookingid,$bookingstatus,$status,$selectedVehicles,$notes,$filter_from_date,$filter_to_date;
    public $vehicles = [];
    public $returnvehicles = [];
    public $returnVehicleIds = [];
     
        function __construct()
    {
        $this->varPDOModelObj = new CommonPDOModel();

        
        // User fields
        $this->categoryId = $_POST['categoryId'] ?? null;
        $this->brandId = $_POST['brandId'] ?? null;
        $this->modelId = $_POST['modelId'] ?? null;
        $this->vehicleNumber = $_POST['vehicleNumber'] ?? null;
        $this->vehicleId = $_POST['vehicleId'] ?? null;
       
        $this->filter_from_date = date('Y-m-d 00:00:00', strtotime($_POST['filter_from_date']))?? null;;
        $this->filter_to_date   = date('Y-m-d 23:59:59', strtotime($_POST['filter_to_date']))?? null;;
        $this->company_id = $_SESSION['company_id'] ?? 1;
        $this->user_id = $_SESSION['user_id'] ?? 1;
        $this->actionevents = $_POST['action'] ?? null;
        date_default_timezone_set('Asia/Bahrain');
        $this->createdDate = date('Y-m-d H:i:s');
        $this->vehicle_id = $_POST['vehicle_id']?? null;
        $this->from = $_POST['fromDate']?? null;
        $this->to = $_POST['toDate']?? null;
        $this->bookingid = $_POST['bookingid']?? null;
        $this->bookingstatus = $_POST['bookingstatus']?? null;
        $this->status = $_POST['status']?? 'All';
         $this->selectedVehicles = $_POST['selectedVehicles']?? '[]';
         $this->notes = $_POST['notes']?? '';
        
        $this->staffDetails = null;
        $this->bookingDetails = null;
        
        // Staff Details
        if (isset($_POST['staff_details']) && trim($_POST['staff_details']) != '') {
            $this->staffDetails = json_decode($_POST['staff_details'], true);
        
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->staffDetails = null;
            }
        }
        
        // Booking Details
        if (isset($_POST['booking_details']) && trim($_POST['booking_details']) != '') {
            $this->bookingDetails = json_decode($_POST['booking_details'], true);
        
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->bookingDetails = null;
            }
        }
        if (isset($_POST['vehicles'])) {
            $this->vehicles = json_decode($_POST['vehicles'], true);
            if (empty($this->vehicles)) {
                echo json_encode([
                    "status" => false,
                    "message" => "No vehicles received"
                ]);
                exit;
            }
        
        }
        
        $this->returnvehicles = [];

        if (!empty($_POST['returnvehicles'])) {
            $this->returnvehicles = is_array($_POST['returnvehicles'])
                ? $_POST['returnvehicles']
                : json_decode($_POST['returnvehicles'], true);
        }
         
        $this->returnVehicleIds = [];

        if (!empty($_POST['vehicle_ids'])) {
            $this->returnVehicleIds = is_array($_POST['vehicle_ids'])
                ? $_POST['vehicle_ids']
                : json_decode($_POST['vehicle_ids'], true);
        }
        
        $this->returnDate = $_POST['return_date'] ?? null;
        $this->vehicleStatus = $_POST['vehicle_status'] ?? null;
        $this->returnNotes = $_POST['return_notes'] ?? null;
       
       
    }

    function SQLArray()
    {
        $array = array();

       
 $array[13] = "SELECT 
    v.*,
COALESCE(rc.staff_name, '') AS staff_name,
COALESCE(rc.booking_no, '') AS booking_no,
COALESCE(rc.book_from_date, '') AS book_from_date,
COALESCE(rc.book_to_date, '') AS book_to_date,
COALESCE(rc.book_ids, '') AS book_ids,

     COUNT(v.ids) AS  has_unconfirmed_overlap,
      IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per hour rental without driver' 
        THEN jt.amount END), 0) AS price_hour_without_driver,

    IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per hour rental with driver' 
        THEN jt.amount END), 0) AS price_hour_with_driver,

    IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per day rental without driver' 
        THEN jt.amount END), 0) AS price_day_without_driver,
      IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per day rental with driver' 
        THEN jt.amount END), 0) AS price_day_with_driver,
        
        IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per week rental with driver' 
        THEN jt.amount END), 0) AS price_week_with_driver,
        
        IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per week rental without driver' 
        THEN jt.amount END), 0) AS price_week_without_driver,
        
        IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per month rental without driver' 
        THEN jt.amount END), 0) AS price_month_without_driver,
        
        IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per month rental with driver' 
        THEN jt.amount END), 0) AS price_month_with_driver,    

    (
        SELECT JSON_OBJECTAGG(t.model_names, t.model_count)
        FROM (
            SELECT 
                v2.model_names,
                COUNT(*) AS model_count
            FROM tbl_vehicles v2
            WHERE 
              
                 v2.company_id = ? AND v2.vehicle_status in ('Parking','Available')
               
            GROUP BY v2.model_names
        ) t
    ) AS model_summary_json

FROM tbl_vehicles v
LEFT JOIN tbl_vehicle_model vm 
    ON vm.ids = v.model_id
LEFT JOIN (
    SELECT r1.vehicle_id,
           r1.staff_name as staff_name,
           r1.booking_no as booking_no,
           r1.book_to_date as book_to_date,
           r1.book_from_date as book_from_date,
           r1.ids as book_ids
    FROM tbl_vehicle_non_revenue_ticket r1
    INNER JOIN (
        SELECT vehicle_id, MAX(ids) AS max_id
        FROM tbl_vehicle_non_revenue_ticket 
        WHERE book_status = 'Rentout'
        GROUP BY vehicle_id
    ) r2 ON r1.ids = r2.max_id
) rc ON rc.vehicle_id = v.ids

-- ✅ Convert JSON → rows
LEFT JOIN JSON_TABLE(
    vm.price_json,
    '$[*]' COLUMNS (
        item VARCHAR(255) PATH '$.item',
        amount DECIMAL(10,3) PATH '$.amount'
    )
) jt ON TRUE
WHERE  v.company_id = ? AND v.vehicle_status in ('Parking','Available')
   
    GROUP BY v.ids
ORDER BY v.ids DESC
";

$this->params[13] = [
    $this->company_id,
    $this->company_id
];

$array[2] = "SELECT 
    v.*,
COALESCE(rc.staff_name, '') AS staff_name,
COALESCE(rc.booking_no, '') AS booking_no,
COALESCE(rc.book_from_date, '') AS book_from_date,
COALESCE(rc.book_to_date, '') AS book_to_date,
COALESCE(rc.book_ids, '') AS book_ids,
     COUNT(v.ids) AS  has_unconfirmed_overlap,
      IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per hour rental without driver' 
        THEN jt.amount END), 0) AS price_hour_without_driver,

    IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per hour rental with driver' 
        THEN jt.amount END), 0) AS price_hour_with_driver,

    IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per day rental without driver' 
        THEN jt.amount END), 0) AS price_day_without_driver,
      IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per day rental with driver' 
        THEN jt.amount END), 0) AS price_day_with_driver,
        
        IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per week rental with driver' 
        THEN jt.amount END), 0) AS price_week_with_driver,
        
        IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per week rental without driver' 
        THEN jt.amount END), 0) AS price_week_without_driver,
        
        IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per month rental without driver' 
        THEN jt.amount END), 0) AS price_month_without_driver,
        
        IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per month rental with driver' 
        THEN jt.amount END), 0) AS price_month_with_driver,    

    (
        SELECT JSON_OBJECTAGG(t.model_names, t.model_count)
        FROM (
            SELECT 
                v2.model_names,
                COUNT(*) AS model_count
            FROM tbl_vehicles v2
            WHERE 
              
                 v2.company_id = ? AND v2.vehicle_status in ('Staff Use')
               
            GROUP BY v2.model_names
        ) t
    ) AS model_summary_json

FROM tbl_vehicles v
LEFT JOIN tbl_vehicle_model vm 
    ON vm.ids = v.model_id
LEFT JOIN (
    SELECT r1.vehicle_id,
           r1.staff_name as staff_name,
           r1.booking_no as booking_no,
           r1.book_to_date as book_to_date,
          r1.book_from_date as book_from_date,
           r1.ids as book_ids
    FROM tbl_vehicle_non_revenue_ticket r1
    INNER JOIN (
        SELECT vehicle_id, MAX(ids) AS max_id
        FROM tbl_vehicle_non_revenue_ticket 
        WHERE book_status = 'Rentout'
        GROUP BY vehicle_id
    ) r2 ON r1.ids = r2.max_id
) rc ON rc.vehicle_id = v.ids

-- ✅ Convert JSON → rows
LEFT JOIN JSON_TABLE(
    vm.price_json,
    '$[*]' COLUMNS (
        item VARCHAR(255) PATH '$.item',
        amount DECIMAL(10,3) PATH '$.amount'
    )
) jt ON TRUE
WHERE  v.company_id = ? AND v.vehicle_status in ('Staff Use')
   
    GROUP BY v.ids
ORDER BY v.ids DESC
";

$this->params[2] = [
    $this->company_id,
    $this->company_id
];
 
 

  
        return $array;
    }
    
    function getStatusClass($status) {
        switch(strtolower($status)) {
            case 'available':
                return 'bg-success text-white';     // Green
            case 'rentout':
                return 'bg-warning text-white';      // Red
            case 'parking':
                return 'bg-info text-white';        // Blue
            case 'maintenance':
                return 'bg-danger text-white';      // Yellow
            case 'blocked':
                return 'bg-secondary text-white';  // Grey
            case 'staff use':
                return 'bg-warning text-white';  // Grey
            default:
                return 'bg-light text-white';        // Default
        }
    }

    function DataRequest($action)
    {
        $var = $this->SQLArray();

        switch ($action) {

     
          case 'non_revenue_ticket_book':
                  $this->varPDOModelObj->Begin();
                  $year = date("Y");
                $prefix = "AA/$year/NRT/";
                $book_from = !empty($this->bookingDetails['from_datetime'])
                ? date('Y-m-d H:i:s', strtotime($this->bookingDetails['from_datetime']))
                : null;
            
              $book_to = !empty($this->bookingDetails['to_datetime'])
                ? date('Y-m-d H:i:s', strtotime($this->bookingDetails['to_datetime']))
                : null;
                $sql = "SELECT booking_no 
                        FROM  tbl_vehicle_non_revenue_ticket 
                        WHERE booking_no LIKE :prefix 
                        ORDER BY ids DESC 
                        LIMIT 1";
                
                $res = json_decode(
                    $this->varPDOModelObj->ListFromTable($sql, [
                        ':prefix' => $prefix . '%'
                    ]),
                    true
                );
                
                if ($res['status'] && !empty($res['data'])) {
                    $last = $res['data'][0]['booking_no'];
                    $parts = explode('/', $last);
                    $num = intval(end($parts)) + 1;
                    $newNumber = str_pad($num, 4, '0', STR_PAD_LEFT);
                } else {
                    $newNumber = "0001";
                }
                
                $booking_no = $prefix . $newNumber;
                
                try {

                        foreach ($this->vehicles as $v) {
                    
                            $vehicle_id = $v['id'];
                    
                            // Get vehicle details
                            $vehRes = json_decode(
                                $this->varPDOModelObj->ListFromTable(
                                    "SELECT * FROM view_vehicle_details WHERE ids = :id",
                                    [':id' => $vehicle_id]
                                ),
                                true
                            );
                    
                            if (!$vehRes['status'] || empty($vehRes['data'])) {
                                continue;
                            }
                    
                            $veh = $vehRes['data'][0];
                    
                            $category_id = $veh['category_id'];
                            $category_name = $veh['category_name'];
                            $brand_id = $veh['brand_id'];
                            $brand_name = $veh['brand_name'];
                            $model_id = $veh['model_id'];
                            $model_name = $veh['model_name'];
                            $vehicle_no = $veh['vehicle_number'];
                           
                            $staff_details = json_encode([
                                "staff_id" => $this->staffDetails['staff_id'] ?? null,
                                "staff_name" => $this->staffDetails['staff_name'] ?? null,
                                "mobile" => $this->staffDetails['mobile'] ?? null,
                                "email" => $this->staffDetails['email'] ?? null,
                                "licence_no" => $this->staffDetails['licence_no'] ?? null,
                                "licence_issue_place" => $this->staffDetails['licence_issue_place'] ?? null,
                                "licence_issue_date" => $this->staffDetails['licence_issue_date'] ?? null,
                                "licence_expiry_date" => $this->staffDetails['licence_expiry_date'] ?? null,
                                "cpr_no" => $this->staffDetails['cpr_no'] ?? null,
                                "cpr_expiry" => $this->staffDetails['cpr_expiry'] ?? null
                            ]);
                            
                            $book_details = json_encode([
                                "from_datetime" => $book_from,
                                "to_datetime" => $book_to,
                                "notes" => $this->bookingDetails['notes'] ?? null
                            ]);
                                    $sqlInsert = "
                            INSERT INTO tbl_vehicle_non_revenue_ticket
                            (
                                booking_no,
                                category_id,
                                category_name,
                                brand_id,
                                brand_name,
                                model_id,
                                model_name,
                                vehicle_id,
                                vehicle_no,
                                staff_ids,
                                staff_name,
                                staff_details_json,
                                book_from_date,
                                book_to_date,
                                notes,
                                book_details_json,
                                book_status,
                                company_id,
                                user_id,
                                created_date,
                                modified_date
                            )
                            VALUES
                            (
                                :booking_no,
                                :category_id,
                                :category_name,
                                :brand_id,
                                :brand_name,
                                :model_id,
                                :model_name,
                                :vehicle_id,
                                :vehicle_no,
                                :staff_id,
                                :staff_name,
                                :staff_details_json,
                                :book_from_date,
                                :book_to_date,
                                :notes,
                                :book_details_json,
                                :book_status,
                                :company_id,
                                :user_id,
                                :created_date,
                                :modified_date
                            )";

                            $result =$this->varPDOModelObj->executeQuery($sqlInsert, [
                                ':booking_no' => $booking_no,
                                ':category_id' => $category_id,
                                ':category_name' => $category_name,
                                ':brand_id' => $brand_id,
                                ':brand_name' => $brand_name,
                                ':model_id' => $model_id,
                                ':model_name' => $model_name,
                                ':vehicle_id' => $vehicle_id,
                                ':vehicle_no' => $vehicle_no,
                                ':staff_id' =>  $this->staffDetails['staff_id'] ?? null,
                                ':staff_name' =>  $this->staffDetails['staff_name'] ?? null,
                                ':staff_details_json' => $staff_details,
                                ':book_from_date' => $book_from,
                                ':book_to_date' => $book_to,
                                ':notes' => $this->bookingDetails['notes'] ?? null,
                                ':book_details_json' => $book_details,
                                ':book_status' => 'Rentout',
                                ':company_id' => $this->company_id,
                                ':user_id' => $this->user_id,
                                ':created_date' => date("Y-m-d H:i:s"),
                                ':modified_date' => date("Y-m-d H:i:s")
                            ]);
                             if (!$result) {
                            throw new Exception("Failed to create Non-Revenue Ticket.");
                        }
                        
                             $updateResult = $this->varPDOModelObj->executeQuery(
                            "UPDATE  tbl_vehicles
                             SET vehicle_status = :status
                             WHERE ids = :vehicle_id",
                            [
                                ':status' => 'Staff Use', 
                                ':vehicle_id' => $vehicle_id
                            ]
                        );
                        
                        if (!$updateResult) {
                            throw new Exception("Failed to update vehicle status.");
                        }
                        }
                                       
                        // Update vehicle status
                       
                        // ✅ Commit if all good
                        $this->varPDOModelObj->Commit();
                    
                        echo json_encode([
                            "status" => true,
                             "message" => "Non-Revenue Ticket booked successfully.",
                            "booking_no" => $booking_no
                        ]);
                    
                    } catch (Exception $e) {
                    
                        // ❌ Rollback on error
                        $this->varPDOModelObj->Rollback();
                    
                        echo json_encode([
                            "status" => false,
                            "message" => $e->getMessage()
                        ]);
                    }
                            break;
               case 'get_vehicle_details_insight':

                switch($this->status)
                {
                    case 'List':
                        $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[2],$this->params[2]);
                    break;
                    case 'Available':
                         $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[13],$this->params[13]);
                    break;
                    
                    default:
                        $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[13],$this->params[13]);
                    break;
                   
                }

                
                
               
                $resultvehicle = json_decode($this->ReturnData, true);


            if (!isset($resultvehicle['data']) || !is_array($resultvehicle['data'])) {
                echo json_encode([
                    'status' => false,
                    'message' => 'No data found',
                    'html' => '',
                    'summary' => null
                ]);
                exit;
            }
            $html = '';
        foreach ($resultvehicle['data'] as $item) {
        
            $images = [];

            if (!empty($item['image_json'])) {
                $decoded = json_decode($item['image_json'], true);
            
                if (is_array($decoded)) {
                    $images = $decoded;
                }
            }
            
            $lastImage = count($images) > 0 ? end($images) : "default.jpg";
        
            $data_other_details = json_decode($item['other_details_json'], true);
            $vehicleFuelType = $data_other_details['vehicleFuelType'];
            $vehicleGearType = $data_other_details['vehicleGearType'];
        
            $nextPassing = !empty($item['next_passing_date']) ? date('d/m/Y', strtotime($item['next_passing_date'])) : 'NA';
            $nextInsurance = !empty($item['next_insurance_date']) ? date('d/m/Y', strtotime($item['next_insurance_date'])) : 'NA';
            $nextMaintenance = !empty($item['next_maintenance_date']) ? date('d/m/Y', strtotime($item['next_maintenance_date'])) : 'NA';
            
             $price_hour_with_driver = !empty($item['next_maintenance_date']) ? date('d/m/Y', strtotime($item['next_maintenance_date'])) : 'NA';
           
         $service = !empty($item['book_to_date']) ? new DateTime($item['book_to_date']) : null;
      
        
       if ($service) {
            $return_date = $service;
        } else {
            $return_date = null;
        }
        
        $exp_return_date = $return_date
            ? $return_date->format('d M Y, h:i A')
            : '';
            
            
            ob_start();
        ?>
        
            <div class="col-12 col-sm-6 col-md-6 col-lg-12 col-xl-4">
                <div class="vehicle-card d-flex flex-column p-2 border rounded shadow-sm position-relative">
  

        <div class="d-flex align-items-center">

           <div class="me-2 vehicle-image"
             data-images='<?= htmlspecialchars(json_encode($images), ENT_QUOTES, "UTF-8") ?>'>
             
            <img src="uploads/vehicleImages/<?= $lastImage ?>" 
                 
                 style="width:80px;height:80px;object-fit:cover;">
        </div>

            <div class="flex-grow-1">
                <h5 class="card-title mb-0 veh_no"><?=$item['vehicle_number']?></h5>

                <div class="text-muted small fw-bold text-dark"><?=$item['model_names']?></div>

                <div class="d-flex align-items-center gap-2 mt-1 small text-muted">
                    <span><i class="icon-base ri ri-calendar-check-line me-1"></i><?=$item['vehicle_year']?></span>
                    <span><i class="icon-base ri ri-palette-line me-1"></i><?=$item['vehicle_color']?></span>
                    <span><i class="icon-base ri ri-gas-station-line me-1"></i><?=$vehicleFuelType?></span>
                </div>

                <div class="mt-1">
                    <span><i class="icon-base ri ri-car-line me-1"></i><?=$vehicleGearType?></span>
                    <span class="badge rounded-pill <?=$this->getStatusClass($item['vehicle_status'])?>">
                        <?=$item['vehicle_status']?>
                    </span>
                </div>

            </div>

            <!-- BUTTONS -->
           <div class="d-flex flex-column gap-2 ms-2">

    <div class="d-flex align-items-center gap-2">

        <!-- View Button -->
        <button class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center gap-1 action-btn btn_vehicle_view flex-shrink-0"
            style="width: fit-content;"
            data-bs-toggle="tooltip"
            data-bs-trigger="hover"
            data-bs-placement="top"
            title="View Details"
            data-id="<?= $item['ids'] ?>">
            <i class="ri ri-information-2-line icon-18px"></i>
        </button>


        <?php if ($item['vehicle_status'] == 'Staff Use') { ?>

            <!-- Select Button in same row -->
            <button class="btn btn-sm btn-primary d-flex align-items-center gap-1 action-btn btn_vehicle_select"
                data-bs-toggle="tooltip"
                data-bs-trigger="hover"
                data-bs-placement="top"
                title="Select"
                data-status="Staff Use"
                data-insurance="<?= $item['next_insurance_date'] ?>"
                data-passing="<?= $item['next_passing_date'] ?>"
                data-maintenance="<?= $item['next_maintenance_date'] ?>"
                data-modelName="<?= $item['model_names'] ?>"
                data-model="<?= $item['model_id'] ?>"
                data-veh_no="<?= $item['vehicle_number'] ?>"
                data-id="<?= $item['ids'] ?>">
                <i class="ri ri-check-line icon-18px"></i>
            </button>

        <?php } else { ?>

            <button class="btn btn-sm btn-primary d-flex align-items-center gap-1 action-btn btn_vehicle_select"
                data-bs-toggle="tooltip"
                data-bs-trigger="hover"
                title="Select"
                data-status="Available"
                data-insurance="<?= $item['next_insurance_date'] ?>"
                data-passing="<?= $item['next_passing_date'] ?>"
                data-maintenance="<?= $item['next_maintenance_date'] ?>"
                data-modelName="<?= $item['model_names'] ?>"
                data-model="<?= $item['model_id'] ?>"
                data-veh_no="<?= $item['vehicle_number'] ?>"
                data-id="<?= $item['ids'] ?>">
                <i class="ri ri-check-line icon-18px"></i>
            </button>

        <?php } ?>

    </div>


    <?php if ($item['vehicle_status'] == 'Staff Use') { ?>

        <div class="small">
            <strong>Staff Use:</strong> <?= $item['staff_name'] ?? '' ?><br>

            <strong class="text-danger">Ref No:</strong>
            <?= $item['booking_no'] ?? '' ?><br>

            <strong class="text-danger">Exp Return:</strong><br>
            <?= !empty($exp_return_date) 
                ? $exp_return_date
                : '' ?>
        </div>

    <?php } ?>

</div>

        </div>

        <!-- BOTTOM SECTION -->
        <div class="mt-3 small text-muted border-top pt-2">

            <div class="d-flex justify-content-between">
                <span><i class="ri-calendar-check-line text-success me-1"></i>Passing</span>
                <span><?= $nextPassing ?></span>
            </div>

            <div class="d-flex justify-content-between">
                <span><i class="ri-shield-check-line text-info me-1"></i>Insurance</span>
                <span><?=$nextInsurance?></span>
            </div>

            <div class="d-flex justify-content-between">
                <span><i class="ri-tools-line text-danger me-1"></i>Maintenance</span>
                <span><?=$nextMaintenance?></span>
            </div>

        </div>

        </div>
    </div> 
    <?php
        $html .= ob_get_clean();
    } 
        // ✅ Extract summary from FIRST ROW
    $summary = null;
    if (!empty($resultvehicle['data'][0]['model_summary_json'])) {
        $summary = $resultvehicle['data'][0]['model_summary_json'];
    }

    echo json_encode([
        'status' => true,
        'html' => $html,
        'summary' => $summary
    ]);

    exit;  
            break;
            
        case 'list_non_revenue_bookings':
    
        if (empty($this->returnvehicles)) {
            echo json_encode([
                "status" => true,
                "data" => []
            ]);
            break;
        }
    
        $placeholders = [];
        $params = [];
    
        foreach ($this->returnvehicles as $i => $vehicleId) {
            $key = ":vehicle$i";
            $placeholders[] = $key;
            $params[$key] = $vehicleId;
        }
    
        $sql = "
            SELECT
                booking_no,
                vehicle_id,
                vehicle_no,
                model_name,
                CONCAT(brand_name, ' ', model_name) AS models,
                DATE_FORMAT(book_from_date,'%d-%m-%Y %H:%i') AS book_from_date,
                DATE_FORMAT(book_to_date,'%d-%m-%Y %H:%i') AS book_to_date,
                staff_name,
                CONCAT(
                    staff_name,
                    ' (',
                    JSON_UNQUOTE(JSON_EXTRACT(staff_details_json, '$.mobile')),
                    ')'
                ) AS staff_details,
                JSON_UNQUOTE(JSON_EXTRACT(staff_details_json,'$.mobile')) AS staff_mobile,
                notes
            FROM tbl_vehicle_non_revenue_ticket
            WHERE vehicle_id IN (" . implode(',', $placeholders) . ")
              AND book_status = 'Rentout'
            ORDER BY book_from_date DESC
        ";
    
        echo $this->varPDOModelObj->ListFromTable($sql, $params);
    
        break;
      
       case 'non_revenue_ticket_return':

    try {

        $this->varPDOModelObj->Begin();

        if (empty($this->returnVehicleIds)) {
            throw new Exception("No vehicles selected.");
        }

        if (empty($this->returnDate)) {
            throw new Exception("Return date is required.");
        }

        if (empty($this->vehicleStatus)) {
            throw new Exception("Vehicle status is required.");
        }

        $return_date = date('Y-m-d H:i:s', strtotime($this->returnDate));


        foreach ($this->returnVehicleIds as $vehicle_id) {


            // Update Non Revenue Ticket
            $sqlUpdate = "
                UPDATE tbl_vehicle_non_revenue_ticket
                SET 
                    book_to_date = :return_date,
                    book_status = 'Returned',
                    return_notes = :return_notes,
                    modified_date = :modified_date,
                    modified_id = :modified_id
                WHERE vehicle_id = :vehicle_id
                AND book_status = 'Rentout'
            ";


            $this->varPDOModelObj->executeQuery($sqlUpdate, [
                ':return_date' => $return_date,
                ':return_notes' => $this->returnNotes ?? null,
                ':modified_date' => date('Y-m-d H:i:s'),
                ':modified_id' => $this->user_id,
                ':vehicle_id' => $vehicle_id
            ]);


            // Update Vehicle Status
            $sqlVehicle = "
                UPDATE tbl_vehicles 
                SET 
                    vehicle_status = :vehicle_status
                WHERE ids = :vehicle_id
            ";


            $this->varPDOModelObj->executeQuery($sqlVehicle, [
                ':vehicle_status' => $this->vehicleStatus,
                ':vehicle_id' => $vehicle_id
            ]);

        }


        $this->varPDOModelObj->Commit();


        echo json_encode([
            "status" => true,
            "message" => "Vehicle return completed successfully."
        ]);


    } catch (Exception $e) {

        $this->varPDOModelObj->Rollback();

        echo json_encode([
            "status" => false,
            "message" => $e->getMessage()
        ]);
    }


break;
          default:
                                $noAction = json_encode([
                                    'status' => false,
                                    'message' => "No Action Found"
                                ]);
                
                                echo $noAction;
                
                                Logger::ActivityLog(
                                    'VehicleStatusController',
                                    "default",
                                    [json_decode($noAction)]
                                );

           break;
        }
    }
}

$obj = new VehicleInsightController();
$obj->DataRequest($obj->actionevents);
