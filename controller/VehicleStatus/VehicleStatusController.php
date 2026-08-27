<?php
session_start();
header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class VehicleStatusController
{
    var $varPDOModelObj;
    public $json, $actionevents, $ReturnData;
    public $params = array();

    public $brandId, $categoryId, $modelId, $company_id, $user_id, $createdDate, $vehicleNumber, $vehicleId, $vehicle_id, $from,$to,$bookingid,$bookingstatus ;
    public $vehicles = [];
        function __construct()
    {
        $this->varPDOModelObj = new CommonPDOModel();

        
        // User fields
        $this->categoryId = $_POST['categoryId'] ?? null;
        $this->brandId = $_POST['brandId'] ?? null;
        $this->modelId = $_POST['modelId'] ?? null;
        $this->vehicleNumber = $_POST['vehicleNumber'] ?? null;
        $this->vehicleId = $_POST['vehicleId'] ?? null;
        
        
        $this->company_id = $_POST['company_id'] ?? $_SESSION['company_id'] ?? 1;
        $this->user_id = $_SESSION['user_id'] ?? 1;
        $this->profile_name = $_SESSION['profile_name'] ?? 'Administrator';
        $this->actionevents = $_POST['action'] ?? null;
        date_default_timezone_set('Asia/Bahrain');
        $this->createdDate = date('Y-m-d H:i:s');
        $this->vehicle_id = $_POST['vehicle_id']?? null;
        $fromDate = $_POST['fromDate'] ?? null;
        if ($fromDate) {
            $fromDate = str_replace('T', ' ', $fromDate);
            // If it contains a slash or dash, format it
            if (strpos($fromDate, '/') !== false || (strpos($fromDate, '-') !== false && preg_match('/^\d{2}-\d{2}-\d{4}/', $fromDate))) {
                $this->from = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $fromDate)));
            } else {
                $this->from = $fromDate;
            }
        } else {
            $this->from = null;
        }

        $toDate = $_POST['toDate'] ?? null;
        if ($toDate) {
            $toDate = str_replace('T', ' ', $toDate);
            if (strpos($toDate, '/') !== false || (strpos($toDate, '-') !== false && preg_match('/^\d{2}-\d{2}-\d{4}/', $toDate))) {
                $this->to = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $toDate)));
            } else {
                $this->to = $toDate;
            }
        } else {
            $this->to = null;
        }
        $this->bookingid = $_POST['bookingid']?? null;
        $this->bookingstatus = $_POST['bookingstatus']?? null;
        
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
        
        
        
       
       
    }

    function SQLArray()
    {
        $array = array();

       
        $array[1] = "SELECT model_ids,model_name,vehicle_modal_pic,category_name,brand_name FROM view_vehicle_model WHERE category_id = ? and brand_id = ?  ORDER BY model_ids ASC";
        
        $this->params[1] = [
            $this->categoryId,
            $this->brandId
        ];
        
        $array[10] = "SELECT price_json FROM tbl_vehicle_model WHERE ids = ?";
        
        $this->params[10] = [
            $this->modelId
        ];
      $array[2] = "SELECT * FROM  tbl_vehicles WHERE model_id = ? and company_id = ?  ORDER BY ids DESC";
        
        $this->params[2] = [
            $this->modelId,
            $this->company_id
        ];
        
        $array[3] = "SELECT * FROM  tbl_vehicles WHERE vehicle_number = ? and company_id = ?  ORDER BY ids DESC";
        
        $this->params[3] = [
            $this->vehicleNumber,
            $this->company_id
        ];
        
         $array[4] = "SELECT * FROM  view_vehicle_details  WHERE ids = ? ";
        
        $this->params[4] = [
            $this->vehicleId
        ];

         $array[5] = "
                    SELECT 
                        v.*,
                        0 AS has_unconfirmed_overlap,
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
                                    v2.model_id = ?
                                    AND v2.company_id = ?
                                    AND v2.vehicle_status = 'Available'
                                GROUP BY v2.model_names
                            ) t
                        ) AS model_summary_json
                    
                    FROM tbl_vehicles v
                     LEFT JOIN tbl_vehicle_model vm 
                        ON vm.ids = v.model_id
                    
                    -- ✅ Convert JSON → rows
                    LEFT JOIN JSON_TABLE(
                        vm.price_json,
                        '$[*]' COLUMNS (
                            item VARCHAR(255) PATH '$.item',
                            amount DECIMAL(10,3) PATH '$.amount'
                        )
                    ) jt ON TRUE
                    WHERE 
                        v.model_id = ? 
                        AND v.company_id = ? 
                        AND v.vehicle_status = 'Available'
                        GROUP BY v.ids
                    ORDER BY v.ids DESC
                    ";
                    
                    $this->params[5] = [
                        $this->modelId,   // for subquery
                        $this->company_id,
                        $this->modelId,   // for main query
                        $this->company_id
                    ];
        
       $array[6] = "SELECT 
    v.*,

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
                v2.vehicle_number = ?
                AND v2.company_id = ?
                AND v2.vehicle_status = 'Available'
            GROUP BY v2.model_names
        ) t
    ) AS model_summary_json

FROM tbl_vehicles v
LEFT JOIN tbl_vehicle_model vm 
    ON vm.ids = v.model_id

-- ✅ Convert JSON → rows
LEFT JOIN JSON_TABLE(
    vm.price_json,
    '$[*]' COLUMNS (
        item VARCHAR(255) PATH '$.item',
        amount DECIMAL(10,3) PATH '$.amount'
    )
) jt ON TRUE
WHERE 
    v.vehicle_number = ? 
    AND v.company_id = ? 
    AND v.vehicle_status = 'Available'
    GROUP BY v.ids
ORDER BY v.ids DESC
";

$this->params[6] = [
    $this->vehicleNumber,
    $this->company_id,
    $this->vehicleNumber, 
    $this->company_id
];
 
    $array[7] = "SELECT 
    v.*,

    COALESCE(
        JSON_ARRAYAGG(
            CASE 
                WHEN b.vehicle_id IS NOT NULL THEN JSON_OBJECT(
                    'from', b.book_from_date,
                    'to', b.book_to_date,
                    'status', b.book_status
                )
            END
        ),
        JSON_ARRAY()
    ) AS booking_json,

    COUNT(b.vehicle_id) AS has_unconfirmed_overlap,
IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per hour rental without driver' 
        THEN jt.amount END), 0) AS price_hour_without_driver,

    IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per hour rental with driver' 
        THEN jt.amount END), 0) AS price_hour_with_driver,

    IFNULL(MAX(CASE 
        WHEN jt.item = 'Price per day rental without driver' 
        THEN jt.amount END), 0) AS price_day_without_driver,
    mc.model_count,
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

            LEFT JOIN tbl_vehicle_bookings bc2 
                ON bc2.vehicle_id = v2.ids
                AND bc2.book_status = 'Confirmed'
                AND NOT (
                    bc2.book_to_date <= ? 
                    OR bc2.book_from_date >= ?
                )

            WHERE 
                v2.company_id = ?
               AND v2.model_id = ?
                AND v2.vehicle_status = 'Available'
                AND bc2.vehicle_id IS NULL

            GROUP BY v2.model_names
        ) t
    ) AS model_summary_json

FROM tbl_vehicles v
LEFT JOIN tbl_vehicle_model vm 
        ON vm.ids = v.model_id
    
    -- ✅ Convert JSON → rows
    LEFT JOIN JSON_TABLE(
        vm.price_json,
        '$[*]' COLUMNS (
            item VARCHAR(255) PATH '$.item',
            amount DECIMAL(10,3) PATH '$.amount'
        )
    ) jt ON TRUE

LEFT JOIN tbl_vehicle_bookings bc 
    ON bc.vehicle_id = v.ids
    AND bc.book_status = 'Confirmed'
    AND NOT (
        bc.book_to_date <= ? 
        OR bc.book_from_date >= ?
    )

LEFT JOIN tbl_vehicle_bookings b 
    ON b.vehicle_id = v.ids
    AND b.book_status != 'Confirmed'
    AND NOT (
        b.book_to_date <= ? 
        OR b.book_from_date >= ?
    )

LEFT JOIN (
    SELECT 
        v3.model_names,
        COUNT(*) AS model_count
    FROM tbl_vehicles v3

    LEFT JOIN tbl_vehicle_bookings bc3 
        ON bc3.vehicle_id = v3.ids
        AND bc3.book_status = 'Confirmed'
        AND NOT (
            bc3.book_to_date <= ? 
            OR bc3.book_from_date >= ?
        )

    WHERE 
        v3.company_id = ?
        AND v3.model_id = ?
        AND v3.vehicle_status = 'Available'
        AND bc3.vehicle_id IS NULL

    GROUP BY v3.model_names
) mc 
    ON mc.model_names = v.model_names

WHERE 
    v.company_id = ?
    AND v.model_id = ?
    AND v.vehicle_status = 'Available'
    AND bc.vehicle_id IS NULL

GROUP BY v.ids

ORDER BY v.model_names";
$this->params[7] = [
    
    $this->from,
    $this->to,
    $this->company_id,
    $this->modelId,

    $this->from,
    $this->to,

    $this->from,
    $this->to,

    $this->from,
    $this->to,
    $this->company_id,
    $this->modelId,

    $this->company_id,
    $this->modelId
];
    $array[8] = "SELECT 
    v.*,

    COALESCE(
        JSON_ARRAYAGG(
            CASE 
                WHEN b.vehicle_id IS NOT NULL THEN JSON_OBJECT(
                    'from', DATE_FORMAT(b.book_from_date, '%d-%m-%y %H:%i'),
                    'to', DATE_FORMAT(b.book_to_date, '%d-%m-%y %H:%i'),
                    'status', b.book_status
                )
            END
        ),
        JSON_ARRAY()
    ) AS booking_json,

    COUNT(b.vehicle_id) AS has_unconfirmed_overlap,
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
    mc.model_count,

    (
        SELECT JSON_OBJECTAGG(t.model_names, t.model_count)
        FROM (
            SELECT 
                v2.model_names,
                COUNT(*) AS model_count
            FROM tbl_vehicles v2

            LEFT JOIN tbl_vehicle_bookings bc2 
                ON bc2.vehicle_id = v2.ids
                AND bc2.book_status = 'Confirmed'
                AND bc2.book_status = 'Confirmed'
                AND NOT (
                    bc2.book_to_date <= ? 
                    OR bc2.book_from_date >= ?
                )

            WHERE 
                v2.company_id = ?
                AND v2.vehicle_status = 'Available'
                AND bc2.vehicle_id IS NULL

            GROUP BY v2.model_names
        ) t
    ) AS model_summary_json

FROM tbl_vehicles v
LEFT JOIN tbl_vehicle_model vm 
        ON vm.ids = v.model_id
    
    -- ✅ Convert JSON → rows
    LEFT JOIN JSON_TABLE(
        vm.price_json,
        '$[*]' COLUMNS (
            item VARCHAR(255) PATH '$.item',
            amount DECIMAL(10,3) PATH '$.amount'
        )
    ) jt ON TRUE

LEFT JOIN tbl_vehicle_bookings bc 
    ON bc.vehicle_id = v.ids
    AND bc.book_status = 'Confirmed'
    AND NOT (
        bc.book_to_date <= ? 
        OR bc.book_from_date >= ?
    )

LEFT JOIN tbl_vehicle_bookings b 
    ON b.vehicle_id = v.ids
    AND b.book_status != 'Confirmed'
    AND NOT (
        b.book_to_date <= ? 
        OR b.book_from_date >= ?
    )

LEFT JOIN (
    SELECT 
        v3.model_names,
        COUNT(*) AS model_count
    FROM tbl_vehicles v3

    LEFT JOIN tbl_vehicle_bookings bc3 
        ON bc3.vehicle_id = v3.ids
        AND bc3.book_status = 'Confirmed'
        AND NOT (
            bc3.book_to_date <= ? 
            OR bc3.book_from_date >= ?
        )

    WHERE 
        v3.company_id = ?
        AND v3.vehicle_status = 'Available'
        AND bc3.vehicle_id IS NULL

    GROUP BY v3.model_names
) mc 
    ON mc.model_names = v.model_names

WHERE 
    v.company_id = ?
    AND v.vehicle_status = 'Available'
    AND bc.vehicle_id IS NULL

GROUP BY v.ids

ORDER BY v.model_names";
$this->params[8] = [
    $this->from,
    $this->to,
    $this->company_id,
    $this->from,
    $this->to,
    $this->from,
    $this->to,
    $this->from,
    $this->to,
    $this->company_id,
    $this->company_id
];
    
    $array[9] = "SELECT 
    v.*,

    COALESCE(
        JSON_ARRAYAGG(
            CASE 
                WHEN b.vehicle_id IS NOT NULL THEN JSON_OBJECT(
                    'from', b.book_from_date,
                    'to', b.book_to_date,
                    'status', b.book_status
                )
            END
        ),
        JSON_ARRAY()
    ) AS booking_json,

    COUNT(b.vehicle_id) AS has_unconfirmed_overlap,
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

            LEFT JOIN tbl_vehicle_bookings bc2 
                ON bc2.vehicle_id = v2.ids
                AND bc2.book_status = 'Confirmed'
                AND NOT (
                    bc2.book_to_date <= ? 
                    OR bc2.book_from_date >= ?
                )

            WHERE 
                v2.company_id = ?
                AND v2.vehicle_number = ?
                AND v2.vehicle_status = 'Available'
                AND bc2.vehicle_id IS NULL

            GROUP BY v2.model_names
        ) t
    ) AS model_summary_json

FROM tbl_vehicles v
LEFT JOIN tbl_vehicle_model vm 
        ON vm.ids = v.model_id
    
    -- ✅ Convert JSON → rows
    LEFT JOIN JSON_TABLE(
        vm.price_json,
        '$[*]' COLUMNS (
            item VARCHAR(255) PATH '$.item',
            amount DECIMAL(10,3) PATH '$.amount'
        )
    ) jt ON TRUE

LEFT JOIN tbl_vehicle_bookings bc 
    ON bc.vehicle_id = v.ids
    AND bc.book_status = 'Confirmed'
    AND NOT (
        bc.book_to_date <= ? 
        OR bc.book_from_date >= ?
    )

LEFT JOIN tbl_vehicle_bookings b 
    ON b.vehicle_id = v.ids
    AND b.book_status != 'Confirmed'
    AND NOT (
        b.book_to_date <= ? 
        OR b.book_from_date >= ?
    )

WHERE 
    v.company_id = ?
    AND v.vehicle_status = 'Available'
    AND v.vehicle_number = ?
    AND bc.vehicle_id IS NULL

GROUP BY v.ids

ORDER BY v.model_names";
$this->params[9] = [
    // subquery
    $this->from,
    $this->to,
    $this->company_id,
    $this->vehicleNumber,

    // main bc condition
    $this->from,
    $this->to,

    // main b condition
    $this->from,
    $this->to,

    // where
    $this->company_id,
    $this->vehicleNumber
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
            default:
                return 'bg-light text-white';        // Default
        }
    }

    function DataRequest($action)
    {
        $var = $this->SQLArray();

        switch ($action) {

           case 'get_model_details':

                $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[1],
                    $this->params[1]
                );
        
                $result = json_decode($this->ReturnData, true);
            
                echo json_encode([
                    "data" => $result['data'] ?? []
                ]);
            
            break;
            case 'get_model_price_details':

                $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[10],
                    $this->params[10]
                );
        
                $result = json_decode($this->ReturnData, true);
            
                echo json_encode([
                    "data" => $result['data'] ?? []
                ]);
            
            break;
             case 'get_vehicle_details':

                
                if($this->modelId=='0')
                {
                    $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[3],$this->params[3]);
                   
                }
                else
                {
                    $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[2],$this->params[2]);
                    
                }
                
               
                $resultvehicle = json_decode($this->ReturnData, true);
                foreach ($resultvehicle['data'] as $item) {
    
                        
            $images = [];

            if (!empty($item['image_json'])) {
                $decoded = json_decode($item['image_json'], true);
            
                if (is_array($decoded)) {
                    $images = $decoded;
                }
            }
            
            $lastImage = count($images) > 0 ? end($images) : "default.jpg";
                   $nextPassing = !empty($item['next_passing_date']) ? date('d/m/Y', strtotime($item['next_passing_date'])) : 'NA';
                  $nextInsurance = !empty($item['next_insurance_date']) ? date('d/m/Y', strtotime($item['next_insurance_date'])) : 'NA';
                 $nextMaintenance = !empty($item['next_maintenance_date']) ? date('d/m/Y', strtotime($item['next_maintenance_date'])) : 'NA';
                    
                    echo '<div class="col-12 col-sm-6 col-md-6 col-lg-12 col-xl-4">
                        <div class="vehicle-card d-flex flex-column p-3 border-0 rounded-4 shadow bg-white">
                    
                            <!-- TOP SECTION -->
                            <div class="d-flex align-items-center">
                    
                                <div class="me-2">
                                    <img src="uploads/vehicleImages/'.$lastImage.'" 
                                         class="rounded-circle border" 
                                         style="width:60px;height:60px;object-fit:cover;">
                                </div>
                    
                                <div class="flex-grow-1">
                    
                                    <div class="fw-bold text-dark veh_no">'.$item['vehicle_number'].'</div>
                                    <div class="text-muted small">'.$item['model_names'].'</div>
                    
                                    <div class="d-flex align-items-center gap-2 mt-1 small text-muted">
                                        <span><i class="ri-calendar-line text-primary me-1"></i>'.$item['vehicle_year'].'</span>
                                        <span>•</span>
                                        <span><i class="ri-palette-line text-warning me-1"></i>'.$item['vehicle_color'].'</span>
                                    </div>
                    
                                    <div class="mt-1">
                                        <span class="badge rounded-pill '.$this->getStatusClass($item['vehicle_status']).'">
                                            '.$item['vehicle_status'].'
                                        </span>
                                    </div>
                    
                                </div>
                    
                                <!-- BUTTONS -->
                                <div class="d-flex flex-column gap-2 ms-2">
                    
                                    <button class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 action-btn btn_vehicle_view"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="View Details"
                                        data-id="'.$item['ids'].'">
                                        <i class="ri ri-information-2-line icon-18px"></i>
                                    </button>
                    
                                    <button class="btn btn-sm btn-primary d-flex align-items-center gap-1 action-btn btn_vehicle_select"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Select"
                                        data-modelName="'.$item['model_names'].'"
                                        data-model="'.$item['model_id'].'"
                                        data-id="'.$item['ids'].'">
                                        <i class="ri ri-check-line icon-18px"></i>
                                    </button>
                    
                                </div>
                    
                            </div>
                    
                            <!-- BOTTOM SECTION (3 ROWS) -->
                            <div class="mt-3 small text-muted border-top pt-2">
                    
                                <div class="d-flex justify-content-between">
                                    <span><i class="ri-calendar-check-line text-success me-1"></i>Passing</span>
                                    <span>'.$nextPassing.'</span>
                                </div>
                    
                                <div class="d-flex justify-content-between">
                                    <span><i class="ri-shield-check-line text-info me-1"></i>Insurance</span>
                                    <span>'.$nextInsurance.'</span>
                                </div>
                    
                                <div class="d-flex justify-content-between">
                                    <span><i class="ri-tools-line text-danger me-1"></i>Maintenance</span>
                                    <span>'.$nextMaintenance.'</span>
                                </div>
                    
                            </div>
                    
                        </div>
                    </div>';
                }
            
               
            
            break;
            case 'get_vehicle_full_details':
                
                
                 $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[4],
                    $this->params[4]
                );
                 $result = json_decode($this->ReturnData, true);
               
                foreach ($result['data'] as $item) {
    
                        $defaultImage = "default.jpg";
                    
                            $lastImage = $defaultImage;
                            
                            if (!empty($item['image_json'])) {
                            
                                $images = json_decode($item['image_json'], true);
                                //$images = json_decode($images, true);
                            
                                if (is_array($images) && count($images) > 0) {
                                    $lastImage = end($images);
                                }
                            }
                }
               
            $vehicleStatushtml= '<span class="badge rounded-pill  '.$this->getStatusClass($item['vehicle_status']).'">'.$item['vehicle_status'].'</span>';
                echo json_encode([
                    "data" => $result['data'] ?? [],
                    "last_image" => $lastImage,
                    "vehicleStatushtml" => $vehicleStatushtml
                ]);

           
        break;
        
         case 'get_vehicle_details_reservation':

                
                if($this->modelId=='0')
                {
                    $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[6],$this->params[6]);
                   
                }
                else
                {
                    $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                    $var[5],$this->params[5]);
                    
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
            $bookingJson = $item['booking_json'] ?? '[]';
        
            ob_start();
            $layoutClass = (isset($_POST['layout']) && $_POST['layout'] === 'fullwidth') 
                ? 'col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3' 
                : 'col-12 col-sm-6 col-md-6 col-lg-12 col-xl-6';
        ?>
        
            <div class="<?= $layoutClass ?>">
                                                                                                                                <div class="card h-100 shadow-sm border-0 vehicle-card rounded-4 overflow-hidden" style="transition: transform 0.2s, box-shadow 0.2s;">
                    <div class="row g-0 h-100">
                                                                                                <!-- Left Side Image -->
                        <div class="col-6 bg-white border-end position-relative vehicle-image p-0" data-images='<?= htmlspecialchars(json_encode($images), ENT_QUOTES, "UTF-8") ?>' style="cursor:pointer;">
                            <img src="uploads/vehicleImages/<?= $lastImage ?>" class="img-fluid w-100 h-100" style="object-fit: cover; object-position: center; padding: 0;" alt="Vehicle Image">
                            <span class="badge rounded-pill <?=$this->getStatusClass($item['vehicle_status'])?> shadow-sm position-absolute top-0 start-0 m-2" style="font-size: 0.65rem;">
                                <?=$item['vehicle_status']?>
                            </span>
                        </div>
                        <!-- Right Side Details -->
                          <div class="col-6">
                            <div class="card-body p-2 d-flex flex-column h-100">
                                <div class="mb-2">
                                    <h5 class="mb-0 fw-bold text-danger text-truncate" title="<?=$item['vehicle_number']?>"><?=$item['vehicle_number']?></h5>
                                    <small class="text-body fw-semibold text-truncate d-block" title="<?=$item['model_names']?>" style="font-size: 1rem;"><?=$item['model_names']?></small>
                                </div>
                                
                                <div class="row g-1 mb-2 mt-auto" style="font-size: 1rem;">
                                    <div class="col-12 d-flex align-items-center text-truncate text-secondary fw-semibold" title="Chassis: <?=$item['chassis_number'] ?? 'N/A'?>">
                                        <i class="ri ri-barcode-line me-1"></i> <?=$item['chassis_number'] ?? 'N/A'?>
                                    </div>
                                    <div class="col-6 d-flex align-items-center text-secondary fw-semibold">
                                        <i class="ri ri-calendar-check-line me-1"></i> <?=$item['vehicle_year']?>
                                    </div>
                                    <div class="col-6 d-flex align-items-center text-secondary fw-semibold">
                                        <i class="ri ri-palette-line me-1"></i> <?=$item['vehicle_color']?>
                                    </div>
                                    <div class="col-6 d-flex align-items-center text-secondary fw-semibold">
                                        <i class="ri ri-gas-station-line me-1"></i> <?=$vehicleFuelType?>
                                    </div>
                                    <div class="col-6 d-flex align-items-center text-secondary fw-semibold">
                                        <i class="ri ri-car-line me-1"></i> <?=$vehicleGearType?>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-1 border-top pt-2 mt-auto">
                                    <button class="btn btn-sm btn-outline-danger flex-fill d-flex justify-content-center align-items-center action-btn btn_vehicle_view px-1" 
                                        data-bs-toggle="tooltip" title="View Details" data-id="<?=$item['ids']?>" style="font-size: 1rem;">
                                        <i class="ri ri-information-2-line me-1"></i> Details
                                    </button>
                                    <button class="btn btn-sm btn-danger flex-fill d-flex justify-content-center align-items-center action-btn btn_vehicle_select px-1" 
                                        data-permission="vehicle_reservation_manage" data-bs-toggle="tooltip" title="Select Vehicle"
                                        data-insurance="<?=$item['next_insurance_date']?>"
                                        data-passing="<?=$item['next_passing_date']?>"
                                        data-maintenance="<?=$item['next_maintenance_date']?>"
                                        data-modelName="<?=$item['model_names']?>"
                                        data-model="<?=$item['model_id']?>"
                                        data-veh_no="<?=$item['vehicle_number']?>"
                                        data-id="<?=$item['ids']?>"
                                        data-priceHWD="<?= number_format($item['price_hour_with_driver'], 3) ?>"
                                        data-priceHWOD="<?= number_format($item['price_hour_without_driver'], 3) ?>"
                                        data-priceDWD="<?= number_format($item['price_day_with_driver'], 3) ?>"
                                        data-priceDWOD="<?= number_format($item['price_day_without_driver'], 3) ?>"
                                        data-priceWWD="<?= number_format($item['price_week_with_driver'], 3) ?>"
                                        data-priceWWOD="<?= number_format($item['price_week_without_driver'], 3) ?>"
                                        data-priceMWD="<?= number_format($item['price_month_with_driver'], 3) ?>"
                                        data-priceMWOD="<?= number_format($item['price_month_without_driver'], 3) ?>" style="font-size: 1rem;">
                                        <i class="ri ri-check-line me-1"></i> Select
                                    </button>
                                </div>
                            </div>
                        </div>
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
            
             case 'get_vehicle_details_reservation_avail':

                if (!empty($this->vehicleNumber) && $this->vehicleNumber != 'NA') {
                    $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[9], $this->params[9]);
                } else {
                    if (empty($this->modelId) || $this->modelId == 'All') {
                        $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[8], $this->params[8]);
                    } else {
                        $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[7], $this->params[7]);
                    }
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
        
            $data_other_details = !empty($item['other_details_json']) ? (json_decode($item['other_details_json'], true) ?? []) : [];
            $vehicleFuelType = $data_other_details['vehicleFuelType'] ?? ($item['fuel_type'] ?? 'NA');
            $vehicleGearType = $data_other_details['vehicleGearType'] ?? ($item['gear_type'] ?? 'NA');
        
            $nextPassing = !empty($item['next_passing_date']) ? date('d/m/Y', strtotime($item['next_passing_date'])) : 'NA';
            $nextInsurance = !empty($item['next_insurance_date']) ? date('d/m/Y', strtotime($item['next_insurance_date'])) : 'NA';
            $nextMaintenance = !empty($item['next_maintenance_date']) ? date('d/m/Y', strtotime($item['next_maintenance_date'])) : 'NA';
            
             $price_hour_with_driver = !empty($item['next_maintenance_date']) ? date('d/m/Y', strtotime($item['next_maintenance_date'])) : 'NA';
            $bookingJson = $item['booking_json'] ?? '[]';
        
            ob_start();
            $layoutClass = (isset($_POST['layout']) && $_POST['layout'] === 'fullwidth') 
                ? 'col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3' 
                : 'col-12 col-sm-6 col-md-6 col-lg-12 col-xl-6';
        ?>
        
            <div class="<?= $layoutClass ?>">
                                                                                                                                <div class="card h-100 shadow-sm border-0 vehicle-card rounded-4 overflow-hidden" style="transition: transform 0.2s, box-shadow 0.2s;">
                    <div class="row g-0 h-100">
                                                                                                <!-- Left Side Image -->
                        <div class="col-6 bg-white border-end position-relative vehicle-image p-0" data-images='<?= htmlspecialchars(json_encode($images), ENT_QUOTES, "UTF-8") ?>' style="cursor:pointer;">
                            <img src="uploads/vehicleImages/<?= $lastImage ?>" class="img-fluid w-100 h-100" style="object-fit: cover; object-position: center; padding: 0;" alt="Vehicle Image">
                            <span class="badge rounded-pill <?=$this->getStatusClass($item['vehicle_status'])?> shadow-sm position-absolute top-0 start-0 m-2" style="font-size: 0.65rem;">
                                <?=$item['vehicle_status']?>
                            </span>
                        </div>
                        <!-- Right Side Details -->
                          <div class="col-6">
                            <div class="card-body p-2 d-flex flex-column h-100">
                                <div class="mb-2">
                                    <h5 class="mb-0 fw-bold text-danger text-truncate" title="<?=$item['vehicle_number']?>"><?=$item['vehicle_number']?></h5>
                                    <small class="text-body fw-semibold text-truncate d-block" title="<?=$item['model_names']?>" style="font-size: 1rem;"><?=$item['model_names']?></small>
                                </div>
                                
                                <div class="row g-1 mb-2 mt-auto" style="font-size: 1rem;">
                                    <div class="col-12 d-flex align-items-center text-truncate text-secondary fw-semibold" title="Chassis: <?=$item['chassis_number'] ?? 'N/A'?>">
                                        <i class="ri ri-barcode-line me-1"></i> <?=$item['chassis_number'] ?? 'N/A'?>
                                    </div>
                                    <div class="col-6 d-flex align-items-center text-secondary fw-semibold">
                                        <i class="ri ri-calendar-check-line me-1"></i> <?=$item['vehicle_year']?>
                                    </div>
                                    <div class="col-6 d-flex align-items-center text-secondary fw-semibold">
                                        <i class="ri ri-palette-line me-1"></i> <?=$item['vehicle_color']?>
                                    </div>
                                    <div class="col-6 d-flex align-items-center text-secondary fw-semibold">
                                        <i class="ri ri-gas-station-line me-1"></i> <?=$vehicleFuelType?>
                                    </div>
                                    <div class="col-6 d-flex align-items-center text-secondary fw-semibold">
                                        <i class="ri ri-car-line me-1"></i> <?=$vehicleGearType?>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-1 border-top pt-2 mt-auto">
                                    <button class="btn btn-sm btn-outline-danger flex-fill d-flex justify-content-center align-items-center action-btn btn_vehicle_view px-1" 
                                        data-bs-toggle="tooltip" title="View Details" data-id="<?=$item['ids']?>" style="font-size: 1rem;">
                                        <i class="ri ri-information-2-line me-1"></i> Details
                                    </button>
                                    <button class="btn btn-sm btn-danger flex-fill d-flex justify-content-center align-items-center action-btn btn_vehicle_select px-1" 
                                        data-permission="vehicle_reservation_manage" data-bs-toggle="tooltip" title="Select Vehicle"
                                        data-insurance="<?=$item['next_insurance_date']?>"
                                        data-passing="<?=$item['next_passing_date']?>"
                                        data-maintenance="<?=$item['next_maintenance_date']?>"
                                        data-modelName="<?=$item['model_names']?>"
                                        data-model="<?=$item['model_id']?>"
                                        data-veh_no="<?=$item['vehicle_number']?>"
                                        data-id="<?=$item['ids']?>"
                                        data-priceHWD="<?= number_format($item['price_hour_with_driver'], 3) ?>"
                                        data-priceHWOD="<?= number_format($item['price_hour_without_driver'], 3) ?>"
                                        data-priceDWD="<?= number_format($item['price_day_with_driver'], 3) ?>"
                                        data-priceDWOD="<?= number_format($item['price_day_without_driver'], 3) ?>"
                                        data-priceWWD="<?= number_format($item['price_week_with_driver'], 3) ?>"
                                        data-priceWWOD="<?= number_format($item['price_week_without_driver'], 3) ?>"
                                        data-priceMWD="<?= number_format($item['price_month_with_driver'], 3) ?>"
                                        data-priceMWOD="<?= number_format($item['price_month_without_driver'], 3) ?>" style="font-size: 1rem;">
                                        <i class="ri ri-check-line me-1"></i> Select
                                    </button>
                                </div>
                            </div>
                        </div>
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
           
            
            case 'reserve_vehicles':
                                      $this->varPDOModelObj->Begin();
                    $year = date("Y");
                    
                    $cSql = "SELECT company_code FROM tbl_company WHERE ids = " . intval($this->company_id);
                    $cRes = json_decode($this->varPDOModelObj->ListFromTable($cSql), true);
                    $company_code = ($cRes['status'] && !empty($cRes['data'])) ? $cRes['data'][0]['company_code'] : 'AA';

                    $prefix = "{$company_code}/$year/RS/";
                
                $sql = "SELECT booking_no 
                        FROM tbl_vehicle_bookings 
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
                            $booking = $v['booking'];
                    
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
                            $customer_details = json_encode([
                                "customer_code" => $booking['customerCode'],
                                "customer_name" => $booking['customerName'],
                                "phone" => $booking['customerPhone'],
                                "email" => $booking['customerEmail'],
                                "address" => $booking['customerAddress'],
                                "attention" => $booking['customerAttention']
                            ]);
                    
                            $book_details = json_encode([
                                "fromDate" => $booking['fromDate'],
                                "toDate" => $booking['toDate'],
                                "rateType" => $booking['rateType'],
                                "service" => $booking['service'],
                                "duration" => $booking['duration'],
                                "price" => $booking['price'],
                                "vat" => $booking['vat'],
                                "total" => $booking['total'],
                                "notes" => $booking['notes'],
                                "quotation_ref" => $booking['quotation_ref']
                            ]);
                                    $sqlInsert = "
                            INSERT INTO tbl_vehicle_bookings
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
                                book_through,
                                quotation_number,
                                customer_code,
                                customer_name,
                                customer_details_json,
                                book_from_date,
                                book_to_date,
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
                                :book_through,
                                :quotation_number,
                                :customer_code,
                                :customer_name,
                                :customer_details_json,
                                :book_from_date,
                                :book_to_date,
                                :book_details_json,
                                :book_status,
                                :company_id,
                                :user_id,
                                :created_date,
                                :modified_date
                            )";
                    
                            $this->varPDOModelObj->executeQuery($sqlInsert, [
                                ':booking_no' => $booking_no,
                                ':category_id' => $category_id,
                                ':category_name' => $category_name,
                                ':brand_id' => $brand_id,
                                ':brand_name' => $brand_name,
                                ':model_id' => $model_id,
                                ':model_name' => $model_name,
                                ':vehicle_id' => $vehicle_id,
                                ':vehicle_no' => $vehicle_no,
                                ':book_through' => $booking['book_through'] ?? 'direct',
                                ':quotation_number' => $booking['quotation_ref'] ?? null,
                                ':customer_code' => $booking['customerCode'],
                                ':customer_name' => $booking['customerName'],
                                ':customer_details_json' => $customer_details,
                                ':book_from_date' => $booking['fromDate'],
                                ':book_to_date' => $booking['toDate'],
                                ':book_details_json' => $book_details,
                                ':book_status' => 'Booked',
                                ':company_id' => $this->company_id,
                                ':user_id' => $this->user_id,
                                ':created_date' => date("Y-m-d H:i:s"),
                                ':modified_date' => date("Y-m-d H:i:s")
                            ]);
                        }
                    
                        // ✅ Commit if all good
                        $this->varPDOModelObj->Commit();
                    
                        echo json_encode([
                            "status" => true,
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
                     case 'check_vehicle_availability':
                                        
                                $sql = "
                                    SELECT ids 
                                    FROM tbl_vehicle_bookings
                                    WHERE book_status in ('Booked','Confirmed') and vehicle_id = :vehicle_id
                                    AND (
                                        (:fromDate <= book_to_date)
                                        AND
                                        (:toDate >= book_from_date)
                                    )
                                    LIMIT 1
                                ";
                            
                                $res = json_decode(
                                    $this->varPDOModelObj->ListFromTable($sql, [
                                        ':vehicle_id' => $this->vehicle_id,
                                        ':fromDate' =>  $this->from,
                                        ':toDate' =>  $this->to
                                    ]),
                                    true
                                );
                            
                                if ($res['status'] && !empty($res['data'])) {
                                    echo json_encode([
                                        "status" => true,
                                        "exists" => true
                                    ]);
                                } else {
                                    echo json_encode([
                                        "status" => true,
                                        "exists" => false
                                    ]);
                                }
                                        
                                          
                            
                            break;
                            case 'get_all_bookings':
                                 $sql = "SELECT * FROM tbl_vehicle_bookings where vehicle_id = :vehicle_id  and book_status in ('Booked','Confirmed','Cancelled') ORDER BY ids DESC";
                                 $res = json_decode(
                                                $this->varPDOModelObj->ListFromTable($sql, [
                                                    ':vehicle_id' => $this->vehicle_id
                                                ]),
                                                true
                                            );
                            
                                echo json_encode([
                                    "status" => true,
                                    "data" => $res['data'] ?? []
                                ]);
                            break;
                             case 'get_all_contracts':
                                 
                                 $sql = "SELECT 
                        c.ids,
                        c.agreement_no,
                        JSON_UNQUOTE(JSON_EXTRACT(c.customer_details, '$.customer_name')) AS customer_name,
                        JSON_UNQUOTE(JSON_EXTRACT(c.customer_details, '$.customer_mobile')) AS customer_mobile,
                        JSON_UNQUOTE(JSON_EXTRACT(c.vechile_details, '$.model_name')) AS model_name,
                        c.service_type,
                        c.agreement_status,
                        c.service_start_date_time,
                        CASE 
                            WHEN c.agreement_status = 'Extended' 
                                 AND ext.extend_end_date IS NOT NULL 
                            THEN ext.extend_end_date
                            ELSE c.service_end_date_time
                        END AS return_date,
                       CASE 
                            WHEN c.agreement_status IN ('Rentout', 'Extended') THEN
                                DATEDIFF(
                                    CASE 
                                        WHEN c.agreement_status = 'Extended' 
                                             AND ext.extend_end_date IS NOT NULL 
                                        THEN ext.extend_end_date
                                        ELSE c.service_end_date_time
                                    END,
                                    :filter_date
                                )
                            ELSE NULL
                        END AS days_left,
                        DATE_FORMAT(service_start_date_time, '%d-%m-%Y %H:%i') AS start_date,
                       DATE_FORMAT(
                                CASE 
                                    WHEN c.agreement_status = 'Extended' 
                                         AND ext.extend_end_date IS NOT NULL 
                                    THEN ext.extend_end_date
                                    ELSE c.service_end_date_time
                                END,
                                '%d-%m-%Y'
                            ) AS return_date_format
                    
                    FROM tbl_vehicle_rentout_contracts c
                    
                    LEFT JOIN (
                        SELECT agreement_ids, MAX(extend_end_date) AS extend_end_date
                        FROM tbl_vehicle_contract_extensions
                        GROUP BY agreement_ids
                    ) ext 
                        ON ext.agreement_ids = c.ids
                    
                    WHERE c.vehicle_id = :vehicle_id order by c.ids desc";
                     $sqlparams = [
                        ':filter_date' => date('Y-m-d'),
                        ':vehicle_id' => $this->vehicle_id
                    ];
                                 $res = json_decode(
                                                $this->varPDOModelObj->ListFromTable($sql, [
                                                    ':filter_date' => $this->filter_date,
                                                    ':vehicle_id' => $this->vehicle_id
                                                ]),
                                                true
                                            );
                            
                                echo json_encode([
                                    "status" => true,
                                    "data" => $res['data'] ?? []
                                ]);
                            break;

                            case 'delete_booking':
                                

                            $sql = "DELETE FROM tbl_vehicle_bookings WHERE ids = :id";
                        
                            $this->varPDOModelObj->executeQuery($sql, [':id' => $this->bookingid]);
                            $sql2 = "DELETE FROM  tbl_vehicle_rentout_contracts WHERE booking_ids = :id";
                        
                            $this->varPDOModelObj->executeQuery($sql2, [':id' => $this->bookingid]);
                        
                            echo json_encode(["status" => true]);
                            break;
                            case 'change_booking_status':
                                
                            
                                $sql = "UPDATE tbl_vehicle_bookings 
                                        SET book_status = :status, modified_date = :modified_date
                                        WHERE ids = :id";
                            
                                $this->varPDOModelObj->executeQuery($sql, [
                                    ':status' => $this->bookingstatus,
                                    ':modified_date' => $this->createdDate,
                                    ':id' => $this->bookingid
                                ]);
                                if($this->bookingstatus==='Rentout')
                                {
                                    $log_details = [
                                    "user_id" => $this->user_id,
                                    "datetime" => date('Y-m-d H:i:s')
                                    ];
                        
                                     $json_log = json_encode($log_details);
                                      $sqlOldStatus = "
                                        SELECT vehicle_status
                                        FROM tbl_vehicles
                                        WHERE ids = :vehicle_id
                                    ";
                                
                                    $stmtOldStatus = $this->varPDOModelObj->selectexecuteQuery($sqlOldStatus, [
                                        ':vehicle_id' => $this->vehicleId
                                    ]);
                                
                                    $vehicleInfo = $stmtOldStatus->fetch(PDO::FETCH_ASSOC);
                                
                                    $oldStatus = $vehicleInfo['vehicle_status'] ?? 'Available';
                                    
                                    
                                    
                                    
                                    $sql_update = "UPDATE tbl_vehicle_rentout_contracts 
                                        SET agreement_status = :status, rentout_log_json = :log_details
                                        WHERE booking_ids = :id";
                            
                                    $this->varPDOModelObj->executeQuery($sql_update, [
                                        ':status' => $this->bookingstatus,
                                        ':log_details' => $json_log,
                                        ':id' => $this->bookingid
                                    ]);
                                     $sql_veh_update = "UPDATE tbl_vehicles 
                                        SET vehicle_status = :status, rentout_log_json = :log_details
                                        WHERE ids  = :id";
                            
                                    $this->varPDOModelObj->executeQuery($sql_veh_update, [
                                        ':status' => $this->bookingstatus,
                                        ':log_details' => $json_log,
                                        ':id' => $this->vehicleId
                                    ]);
                                    $sql_fetch = "
                                            SELECT
                                                ids,vehicle_id,
                                                booking_ids,
                                                agreement_no,
                                                agreement_group_ref_no,
                                                customer_code,
                                                quotation_number,service_type,
                                                contract_details_json,km_out, JSON_UNQUOTE(JSON_EXTRACT(vehicle_accessories_details, '$.fuel_level')) AS fuel_level
                                            FROM tbl_vehicle_rentout_contracts
                                            WHERE booking_ids = :id and vehicle_id= :vehicle_id
                                        ";
                                       $stmt =  $this->varPDOModelObj->selectexecuteQuery($sql_fetch, [
                                        ':id' => $this->bookingid,
                                        ':vehicle_id' => $this->vehicleId
                                    ]);
                                      
                                        $contract = $stmt->fetch(PDO::FETCH_ASSOC);

                                if ($contract) {

                                    $details = json_decode($contract['contract_details_json'], true);
                                    
                                    $duration   = (float)($details['duration'] ?? 0);
                                    $unitPrice  = (float)($details['unit_price'] ?? 0);
                                    $vatPercent = (float)($details['vat'] ?? 0);
                                
                                    $rentalFee = $duration * $unitPrice;
                                    $vatAmount = ($rentalFee * $vatPercent) / 100;
                                
                                    // Insert Rental Fee row
                                    $sqlInsert = "
                                        INSERT INTO  tbl_customer_ledger
                                        (
                                            customer_code,
                                            quotation_no,
                                            booking_no,
                                            trans_date,
                                            trans_type,
                                            debit,
                                            description,
                                            user_id,
                                            company_id,
                                            created_at,
                                            booking_ids,
                                            contract_ids,
                                            agreement_no
                                        )
                                        VALUES
                                        (
                                            :customer_code,
                                            :quotation_number,
                                            :booking_no,
                                            :trans_date,
                                            :ledger_name,
                                            :amount,
                                            :description,
                                            :user_ids,
                                            :company_ids,
                                            :trans_date_time,
                                            :booking_ids,
                                            :contract_ids,
                                            :agreement_no
                                        )
                                    ";
                                
                                    // Rental Fee
                                    $params_rental =[
                                        ':customer_code'          => $contract['customer_code'],
                                        ':quotation_number'       => $contract['quotation_number'],
                                        ':booking_no' => $contract['agreement_group_ref_no'],
                                        ':trans_date'            => date('Y-m-d'),
                                        ':ledger_name'            => $contract['service_type'],
                                        ':amount'            =>  $rentalFee,
                                        ':description'            => 'Auto Post Rental Fee',
                                        ':user_ids'            =>  $this->user_id,
                                        ':company_ids'            =>  $this->company_id,
                                        ':trans_date_time'            => date('Y-m-d H:i:s'),
                                        ':booking_ids'            => $contract['booking_ids'],
                                        ':agreement_no'           => $contract['agreement_no'],
                                        ':contract_ids'           => $contract['ids']
                                        
                                    ];
                                $this->varPDOModelObj->executeQuery($sqlInsert, $params_rental);
                                    // VAT Row
                                    if ($vatAmount > 0) {
                                
                                        $params_vat =[
                                        ':customer_code'          => $contract['customer_code'],
                                        ':quotation_number'       => $contract['quotation_number'],
                                        ':booking_no' => $contract['agreement_group_ref_no'],
                                        ':trans_date'            => date('Y-m-d'),
                                        ':ledger_name'            => 'VAT',
                                        ':amount'            =>  $vatAmount,
                                        ':description'            => 'Auto Post VAT of Rental Fee',
                                        ':user_ids'            =>  $this->user_id,
                                        ':company_ids'            =>  $this->company_id,
                                        ':trans_date_time'            => date('Y-m-d H:i:s'),
                                        ':booking_ids'            => $contract['booking_ids'],
                                        ':agreement_no'           => $contract['agreement_no'],
                                        ':contract_ids'           => $contract['ids']
                                        
                                    ];
                                     $this->varPDOModelObj->executeQuery($sqlInsert, $params_vat);
                                    }
                                      $this->varPDOModelObj->logVehicleMovement([
                                'vehicle_id'     => $this->vehicleId,
                                'action_type'    => 'Rentout',
                                'old_status'     => $oldStatus,
                                'new_status'     => 'Rentout',
                                'reference_type' => 'Agreement',
                                'reference_id'   => $contract['ids'],
                                'reference_no'   => $contract['agreement_no'],
                                'location_from'  => 'Main Parking',
                                'location_to'    => 'Customer',
                                'staff_id'       => null,
                                'customer_id'    => $contract['customer_code'],
                                'garage_id'      => null,
                                'odometer'       => $contract['km_out'],
                                'fuel_level'     => $contract['fuel_level'],
                                'remarks'        => 'Vehicle rented out under Agreement No. ' . $contract['agreement_no']
                            ]);
                                }
                                 
                                }
                                echo json_encode(["status" => true]);
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

$obj = new VehicleStatusController();
$obj->DataRequest($obj->actionevents);



