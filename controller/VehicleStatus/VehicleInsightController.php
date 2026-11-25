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
        function __construct()
    {
        $this->varPDOModelObj = new CommonPDOModel();

        
        // User fields
        $this->categoryId = $_POST['categoryId'] ?? null;
        $this->brandId = $_POST['brandId'] ?? null;
        $this->modelId = $_POST['modelId'] ?? null;
        $this->vehicleNumber = $_POST['vehicleNumber'] ?? null;
        $this->vehicleId = $_POST['vehicleId'] ?? null;
       
        $this->filter_from_date = !empty($_POST['filter_from_date']) ? date('Y-m-d 00:00:00', strtotime($_POST['filter_from_date'])) : null;
        $this->filter_to_date   = !empty($_POST['filter_to_date']) ? date('Y-m-d 23:59:59', strtotime($_POST['filter_to_date'])) : null;
        $this->filter_company_id = $_POST['filter_company_id'] ?? 'All';

        $allowedCompanyIds = [];
        if (!empty($_SESSION['company_json'])) {
            $cData = json_decode($_SESSION['company_json'], true);
            if (is_array($cData)) {
                foreach ($cData as $c) {
                    $allowedCompanyIds[] = $c['ids'];
                }
            }
        }
        
        // If the user selected a specific company and they have access to it, use it.
        // Otherwise, use all their allowed companies as a comma-separated string.
        if ($this->filter_company_id !== 'All' && in_array($this->filter_company_id, $allowedCompanyIds)) {
            $this->company_id = $this->filter_company_id;
        } else {
            $this->company_id = implode(',', $allowedCompanyIds);
        }
        
        // If still empty (no allowed companies), fallback to -1 or similar so we don't break queries
        if (empty($this->company_id)) {
            $this->company_id = '-1';
        }

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
     
        $array[11] = "SELECT * FROM  tbl_vehicles WHERE  FIND_IN_SET(company_id, ?) > 0  ORDER BY vehicle_number ASC";
        
        $this->params[11] = [
            $this->company_id
        ];
         $array[4] = "SELECT * FROM  view_vehicle_details  WHERE ids = ? ";
        
        $this->params[4] = [
            $this->vehicleId
        ];

       $array[2] = "
                    SELECT 
                        v.*,
                        COALESCE(rc.customer_name, '') AS customer_name,
COALESCE(rc.agreement_no, '') AS agreement_no,
COALESCE(rc.service_end_date_time, '') AS service_end_date_time,
COALESCE(ext.extend_end_date, '') AS extend_end_date,
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
                                    AND FIND_IN_SET(v2.company_id, ?) > 0
                                GROUP BY v2.model_names
                            ) t
                        ) AS model_summary_json
                    
                    FROM tbl_vehicles v
                     LEFT JOIN tbl_vehicle_model vm 
                        ON vm.ids = v.model_id
                    LEFT JOIN (
                        SELECT r1.vehicle_id,
                               r1.customer_name,
                               r1.agreement_no,
                               r1.service_end_date_time
                        FROM tbl_vehicle_rentout_contracts r1
                        INNER JOIN (
                            SELECT vehicle_id, MAX(ids) AS max_id
                            FROM tbl_vehicle_rentout_contracts
                            WHERE agreement_status = 'Rentout'
                            GROUP BY vehicle_id
                        ) r2 ON r1.ids = r2.max_id
                    ) rc ON rc.vehicle_id = v.ids
                    LEFT JOIN tbl_vehicle_contract_extensions ext
                        ON ext.ids = (
                            SELECT MAX(ext2.ids)
                            FROM tbl_vehicle_contract_extensions ext2
                            WHERE ext2.agreement_no = rc.agreement_no
                              AND ext2.vehicle_ids = v.ids
                        )
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
                        AND FIND_IN_SET(v.company_id, ?) > 0 
                        GROUP BY v.ids
                    ORDER BY v.ids DESC
                    ";
                    
        $this->params[2] = [
            $this->modelId,   // for subquery
            $this->company_id,
            $this->modelId,   // for main query
            $this->company_id
        ];
     $array[3] = "SELECT 
    v.*,
COALESCE(rc.customer_name, '') AS customer_name,
COALESCE(rc.agreement_no, '') AS agreement_no,
COALESCE(rc.service_end_date_time, '') AS service_end_date_time,
COALESCE(ext.extend_end_date, '') AS extend_end_date,
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
                AND FIND_IN_SET(v2.company_id, ?) > 0
               
            GROUP BY v2.model_names
        ) t
    ) AS model_summary_json

FROM tbl_vehicles v
LEFT JOIN tbl_vehicle_model vm 
    ON vm.ids = v.model_id
LEFT JOIN (
    SELECT r1.vehicle_id,
           r1.customer_name,
           r1.agreement_no,
           r1.service_end_date_time
    FROM tbl_vehicle_rentout_contracts r1
    INNER JOIN (
        SELECT vehicle_id, MAX(ids) AS max_id
        FROM tbl_vehicle_rentout_contracts
        WHERE agreement_status = 'Rentout'
        GROUP BY vehicle_id
    ) r2 ON r1.ids = r2.max_id
) rc ON rc.vehicle_id = v.ids
LEFT JOIN tbl_vehicle_contract_extensions ext
    ON ext.ids = (
        SELECT MAX(ext2.ids)
        FROM tbl_vehicle_contract_extensions ext2
        WHERE ext2.agreement_no = rc.agreement_no
          AND ext2.vehicle_ids = v.ids
    )
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
    AND FIND_IN_SET(v.company_id, ?) > 0 
   
    GROUP BY v.ids
ORDER BY v.ids DESC
";

$this->params[3] = [
    $this->vehicleNumber,
    $this->company_id,
    $this->vehicleNumber, 
    $this->company_id
];
       $array[6] = "SELECT 
    v.*,
COALESCE(rc.customer_name, '') AS customer_name,
COALESCE(rc.agreement_no, '') AS agreement_no,
COALESCE(rc.service_end_date_time, '') AS service_end_date_time,
COALESCE(ext.extend_end_date, '') AS extend_end_date,
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
              
                 FIND_IN_SET(v2.company_id, ?) > 0
               
            GROUP BY v2.model_names
        ) t
    ) AS model_summary_json

FROM tbl_vehicles v
LEFT JOIN tbl_vehicle_model vm 
    ON vm.ids = v.model_id
LEFT JOIN (
    SELECT r1.vehicle_id,
           r1.customer_name,
           r1.agreement_no,
           r1.service_end_date_time
    FROM tbl_vehicle_rentout_contracts r1
    INNER JOIN (
        SELECT vehicle_id, MAX(ids) AS max_id
        FROM tbl_vehicle_rentout_contracts
        WHERE agreement_status = 'Rentout'
        GROUP BY vehicle_id
    ) r2 ON r1.ids = r2.max_id
) rc ON rc.vehicle_id = v.ids

    LEFT JOIN tbl_vehicle_contract_extensions ext
    ON ext.ids = (
        SELECT MAX(ext2.ids)
        FROM tbl_vehicle_contract_extensions ext2
        WHERE ext2.agreement_no = rc.agreement_no
          AND ext2.vehicle_ids = v.ids
    )
-- ✅ Convert JSON → rows
LEFT JOIN JSON_TABLE(
    vm.price_json,
    '$[*]' COLUMNS (
        item VARCHAR(255) PATH '$.item',
        amount DECIMAL(10,3) PATH '$.amount'
    )
) jt ON TRUE
WHERE  FIND_IN_SET(v.company_id, ?) > 0 
   
    GROUP BY v.ids
ORDER BY v.ids DESC
";

$this->params[6] = [
    $this->company_id,
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
                FIND_IN_SET(v2.company_id, ?) > 0
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
        FIND_IN_SET(v3.company_id, ?) > 0
        AND v3.model_id = ?
        AND v3.vehicle_status = 'Available'
        AND bc3.vehicle_id IS NULL

    GROUP BY v3.model_names
) mc 
    ON mc.model_names = v.model_names

WHERE 
    FIND_IN_SET(v.company_id, ?) > 0
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
                FIND_IN_SET(v2.company_id, ?) > 0
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
        FIND_IN_SET(v3.company_id, ?) > 0
        AND v3.vehicle_status = 'Available'
        AND bc3.vehicle_id IS NULL

    GROUP BY v3.model_names
) mc 
    ON mc.model_names = v.model_names

WHERE 
    FIND_IN_SET(v.company_id, ?) > 0
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
                FIND_IN_SET(v2.company_id, ?) > 0
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
    FIND_IN_SET(v.company_id, ?) > 0
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



 $array[13] = "SELECT 
    v.*,
 COALESCE(rc.customer_name, '') AS customer_name,
COALESCE(rc.agreement_no, '') AS agreement_no,
COALESCE(rc.service_end_date_time, '') AS service_end_date_time,
COALESCE(ext.extend_end_date, '') AS extend_end_date,
COALESCE(mr.garage_name, '') AS garage_name,
COALESCE(mr.request_no, '') AS maintenance_request_no,
COALESCE(mr.request_id, '') AS maintenance_request_id,
COALESCE(mr.status, '') AS maintenance_request_status,
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
              
                 FIND_IN_SET(v2.company_id, ?) > 0 AND v2.vehicle_status = ?
               
            GROUP BY v2.model_names
        ) t
    ) AS model_summary_json

FROM tbl_vehicles v
LEFT JOIN tbl_vehicle_model vm 
    ON vm.ids = v.model_id
LEFT JOIN (
    SELECT r1.vehicle_id,
           r1.customer_name,
           r1.agreement_no,
           r1.service_end_date_time
    FROM tbl_vehicle_rentout_contracts r1
    INNER JOIN (
        SELECT vehicle_id, MAX(ids) AS max_id
        FROM tbl_vehicle_rentout_contracts
        WHERE agreement_status = 'Rentout'
        GROUP BY vehicle_id
    ) r2 ON r1.ids = r2.max_id
) rc ON rc.vehicle_id = v.ids
LEFT JOIN tbl_vehicle_contract_extensions ext
    ON ext.ids = (
        SELECT MAX(ext2.ids)
        FROM tbl_vehicle_contract_extensions ext2
        WHERE ext2.agreement_no = rc.agreement_no
          AND ext2.vehicle_ids = v.ids
    )
LEFT JOIN (
    SELECT req.vehicle_id, g.garage_name, req.request_no, req.status, req.ids AS request_id 
    FROM tbl_maintenance_requests req
    LEFT JOIN tbl_garages g ON g.ids = req.garage_id
    INNER JOIN (
        SELECT vehicle_id, MAX(ids) AS max_id 
        FROM tbl_maintenance_requests 
        GROUP BY vehicle_id
    ) r2 ON req.ids = r2.max_id
) mr ON mr.vehicle_id = v.ids
-- ✅ Convert JSON → rows
LEFT JOIN JSON_TABLE(
    vm.price_json,
    '$[*]' COLUMNS (
        item VARCHAR(255) PATH '$.item',
        amount DECIMAL(10,3) PATH '$.amount'
    )
) jt ON TRUE
WHERE  FIND_IN_SET(v.company_id, ?) > 0 AND v.vehicle_status = ?
   
    GROUP BY v.ids
ORDER BY v.ids DESC
";

$this->params[13] = [
    $this->company_id,
    $this->status,
    $this->company_id,
    $this->status
];

$array[17] = "SELECT 
    v.*,
COALESCE(rc.customer_name, '') AS customer_name,
COALESCE(rc.agreement_no, '') AS agreement_no,
COALESCE(rc.service_start_date_time, '') AS service_start_date_time,
COALESCE(rc.service_end_date_time, '') AS service_end_date_time,
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
              
                 FIND_IN_SET(v2.company_id, ?) > 0 AND v2.vehicle_status in ('Staff Use')
               
            GROUP BY v2.model_names
        ) t
    ) AS model_summary_json

FROM tbl_vehicles v
LEFT JOIN tbl_vehicle_model vm 
    ON vm.ids = v.model_id
LEFT JOIN (
    SELECT r1.vehicle_id,
           r1.staff_name as customer_name,
           r1.booking_no as agreement_no,
           r1.book_to_date as service_end_date_time,
          r1.book_from_date as service_start_date_time,
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
WHERE  FIND_IN_SET(v.company_id, ?) > 0 AND v.vehicle_status in ('Staff Use')
   
    GROUP BY v.ids
ORDER BY v.ids DESC
";

$this->params[17] = [
    $this->company_id,
    $this->company_id
];
 
       $array[16] = "SELECT
    v.*,

    COALESCE(rc.customer_name, '') AS customer_name,
    COALESCE(rc.agreement_no, '') AS agreement_no,
    COALESCE(rc.service_end_date_time, '') AS service_end_date_time,
    COALESCE(ext.extend_end_date, '') AS extend_end_date,

    CASE
        WHEN rc.agreement_status = 'Extended'
             AND ext.extend_end_date IS NOT NULL
        THEN ext.extend_end_date
        ELSE rc.service_end_date_time
    END AS return_date,

    DATE_FORMAT(
        CASE
            WHEN rc.agreement_status = 'Extended'
                 AND ext.extend_end_date IS NOT NULL
            THEN ext.extend_end_date
            ELSE rc.service_end_date_time
        END,
        '%d-%m-%Y %H:%i'
    ) AS return_date_format,

    COUNT(v.ids) AS has_unconfirmed_overlap,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per hour rental without driver'
        THEN jt.amount
    END), 0) AS price_hour_without_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per hour rental with driver'
        THEN jt.amount
    END), 0) AS price_hour_with_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per day rental without driver'
        THEN jt.amount
    END), 0) AS price_day_without_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per day rental with driver'
        THEN jt.amount
    END), 0) AS price_day_with_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per week rental with driver'
        THEN jt.amount
    END), 0) AS price_week_with_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per week rental without driver'
        THEN jt.amount
    END), 0) AS price_week_without_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per month rental without driver'
        THEN jt.amount
    END), 0) AS price_month_without_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per month rental with driver'
        THEN jt.amount
    END), 0) AS price_month_with_driver,

    (
    SELECT JSON_OBJECTAGG(x.model_names, x.model_count)
    FROM
    (
        SELECT
            v2.model_names,
            COUNT(*) AS model_count
        FROM tbl_vehicles v2

        LEFT JOIN (
            SELECT
                r1.vehicle_id,
                r1.agreement_no,
                r1.service_end_date_time,
                r1.agreement_status
            FROM tbl_vehicle_rentout_contracts r1
            INNER JOIN (
                SELECT
                    vehicle_id,
                    MAX(ids) AS max_id
                FROM tbl_vehicle_rentout_contracts
                WHERE agreement_status IN ('Rentout','Extended')
                GROUP BY vehicle_id
            ) r2 ON r1.ids = r2.max_id
        ) rc2
            ON rc2.vehicle_id = v2.ids

        LEFT JOIN tbl_vehicle_contract_extensions ext2
            ON ext2.ids = (
                SELECT MAX(e.ids)
                FROM tbl_vehicle_contract_extensions e
                WHERE e.agreement_no = rc2.agreement_no
                AND e.vehicle_ids = v2.ids
            )

        WHERE  v2.model_id = ? 
                        AND FIND_IN_SET(v2.company_id, ?) > 0

        AND (
            ? = '' OR
            (
                CASE
                    WHEN rc2.agreement_status = 'Extended'
                         AND ext2.extend_end_date IS NOT NULL
                    THEN ext2.extend_end_date
                    ELSE rc2.service_end_date_time
                END
            ) >= ?
        )

        AND (
            ? = '' OR
            (
                CASE
                    WHEN rc2.agreement_status = 'Extended'
                         AND ext2.extend_end_date IS NOT NULL
                    THEN ext2.extend_end_date
                    ELSE rc2.service_end_date_time
                END
            ) <= ?
        )

        GROUP BY v2.model_names
    ) x
) AS model_summary_json

FROM tbl_vehicles v

LEFT JOIN tbl_vehicle_model vm
    ON vm.ids = v.model_id

INNER JOIN (
    SELECT
        r1.vehicle_id,
        r1.customer_name,
        r1.agreement_no,
        r1.service_end_date_time,
        r1.agreement_status
    FROM tbl_vehicle_rentout_contracts r1
    INNER JOIN (
        SELECT
            vehicle_id,
            MAX(ids) AS max_id
        FROM tbl_vehicle_rentout_contracts
        WHERE agreement_status IN ('Rentout', 'Extended')
        GROUP BY vehicle_id
    ) r2
        ON r1.ids = r2.max_id
) rc
    ON rc.vehicle_id = v.ids

LEFT JOIN tbl_vehicle_contract_extensions ext
    ON ext.ids = (
        SELECT MAX(ext2.ids)
        FROM tbl_vehicle_contract_extensions ext2
        WHERE ext2.agreement_no = rc.agreement_no
          AND ext2.vehicle_ids = v.ids
    )

LEFT JOIN JSON_TABLE(
    vm.price_json,
    '$[*]' COLUMNS (
        item VARCHAR(255) PATH '$.item',
        amount DECIMAL(10,3) PATH '$.amount'
    )
) jt ON TRUE

WHERE
   v.model_id = ? AND
    FIND_IN_SET(v.company_id, ?) > 0

    AND (
    ? IS NULL OR
    (
        CASE
            WHEN rc.agreement_status = 'Extended'
                 AND ext.extend_end_date IS NOT NULL
            THEN ext.extend_end_date
            ELSE rc.service_end_date_time
        END
    ) >= ?
)

AND (
    ? IS NULL OR
    (
        CASE
            WHEN rc.agreement_status = 'Extended'
                 AND ext.extend_end_date IS NOT NULL
            THEN ext.extend_end_date
            ELSE rc.service_end_date_time
        END
    ) <= ?
)

GROUP BY v.ids

ORDER BY v.ids DESC
";

$this->params[16] = [
    $this->modelId, 
    $this->company_id,

    $this->filter_from_date,
    $this->filter_from_date,

    $this->filter_to_date,
    $this->filter_to_date,

    // main query
     $this->modelId, 
    $this->company_id,

    $this->filter_from_date,
    $this->filter_from_date,

    $this->filter_to_date,
    $this->filter_to_date
];    
     $array[15] = "SELECT
    v.*,

    COALESCE(rc.customer_name, '') AS customer_name,
    COALESCE(rc.agreement_no, '') AS agreement_no,
    COALESCE(rc.service_end_date_time, '') AS service_end_date_time,
    COALESCE(ext.extend_end_date, '') AS extend_end_date,

    CASE
        WHEN rc.agreement_status = 'Extended'
             AND ext.extend_end_date IS NOT NULL
        THEN ext.extend_end_date
        ELSE rc.service_end_date_time
    END AS return_date,

    DATE_FORMAT(
        CASE
            WHEN rc.agreement_status = 'Extended'
                 AND ext.extend_end_date IS NOT NULL
            THEN ext.extend_end_date
            ELSE rc.service_end_date_time
        END,
        '%d-%m-%Y %H:%i'
    ) AS return_date_format,

    COUNT(v.ids) AS has_unconfirmed_overlap,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per hour rental without driver'
        THEN jt.amount
    END), 0) AS price_hour_without_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per hour rental with driver'
        THEN jt.amount
    END), 0) AS price_hour_with_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per day rental without driver'
        THEN jt.amount
    END), 0) AS price_day_without_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per day rental with driver'
        THEN jt.amount
    END), 0) AS price_day_with_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per week rental with driver'
        THEN jt.amount
    END), 0) AS price_week_with_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per week rental without driver'
        THEN jt.amount
    END), 0) AS price_week_without_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per month rental without driver'
        THEN jt.amount
    END), 0) AS price_month_without_driver,

    IFNULL(MAX(CASE
        WHEN jt.item = 'Price per month rental with driver'
        THEN jt.amount
    END), 0) AS price_month_with_driver,

    (
    SELECT JSON_OBJECTAGG(x.model_names, x.model_count)
    FROM
    (
        SELECT
            v2.model_names,
            COUNT(*) AS model_count
        FROM tbl_vehicles v2

        LEFT JOIN (
            SELECT
                r1.vehicle_id,
                r1.agreement_no,
                r1.service_end_date_time,
                r1.agreement_status
            FROM tbl_vehicle_rentout_contracts r1
            INNER JOIN (
                SELECT
                    vehicle_id,
                    MAX(ids) AS max_id
                FROM tbl_vehicle_rentout_contracts
                WHERE agreement_status IN ('Rentout','Extended')
                GROUP BY vehicle_id
            ) r2 ON r1.ids = r2.max_id
        ) rc2
            ON rc2.vehicle_id = v2.ids

        LEFT JOIN tbl_vehicle_contract_extensions ext2
            ON ext2.ids = (
                SELECT MAX(e.ids)
                FROM tbl_vehicle_contract_extensions e
                WHERE e.agreement_no = rc2.agreement_no
                AND e.vehicle_ids = v2.ids
            )

        WHERE FIND_IN_SET(v2.company_id, ?) > 0

        AND (
            ? = '' OR
            (
                CASE
                    WHEN rc2.agreement_status = 'Extended'
                         AND ext2.extend_end_date IS NOT NULL
                    THEN ext2.extend_end_date
                    ELSE rc2.service_end_date_time
                END
            ) >= ?
        )

        AND (
            ? = '' OR
            (
                CASE
                    WHEN rc2.agreement_status = 'Extended'
                         AND ext2.extend_end_date IS NOT NULL
                    THEN ext2.extend_end_date
                    ELSE rc2.service_end_date_time
                END
            ) <= ?
        )

        GROUP BY v2.model_names
    ) x
) AS model_summary_json

FROM tbl_vehicles v

LEFT JOIN tbl_vehicle_model vm
    ON vm.ids = v.model_id

INNER JOIN (
    SELECT
        r1.vehicle_id,
        r1.customer_name,
        r1.agreement_no,
        r1.service_end_date_time,
        r1.agreement_status
    FROM tbl_vehicle_rentout_contracts r1
    INNER JOIN (
        SELECT
            vehicle_id,
            MAX(ids) AS max_id
        FROM tbl_vehicle_rentout_contracts
        WHERE agreement_status IN ('Rentout', 'Extended')
        GROUP BY vehicle_id
    ) r2
        ON r1.ids = r2.max_id
) rc
    ON rc.vehicle_id = v.ids

LEFT JOIN tbl_vehicle_contract_extensions ext
    ON ext.ids = (
        SELECT MAX(ext2.ids)
        FROM tbl_vehicle_contract_extensions ext2
        WHERE ext2.agreement_no = rc.agreement_no
          AND ext2.vehicle_ids = v.ids
    )

LEFT JOIN JSON_TABLE(
    vm.price_json,
    '$[*]' COLUMNS (
        item VARCHAR(255) PATH '$.item',
        amount DECIMAL(10,3) PATH '$.amount'
    )
) jt ON TRUE

WHERE
    FIND_IN_SET(v.company_id, ?) > 0

    AND (
    ? IS NULL OR
    (
        CASE
            WHEN rc.agreement_status = 'Extended'
                 AND ext.extend_end_date IS NOT NULL
            THEN ext.extend_end_date
            ELSE rc.service_end_date_time
        END
    ) >= ?
)

AND (
    ? IS NULL OR
    (
        CASE
            WHEN rc.agreement_status = 'Extended'
                 AND ext.extend_end_date IS NOT NULL
            THEN ext.extend_end_date
            ELSE rc.service_end_date_time
        END
    ) <= ?
)

GROUP BY v.ids

ORDER BY v.ids DESC
";

$this->params[15] = [
  
    $this->company_id,

    $this->filter_from_date,
    $this->filter_from_date,

    $this->filter_to_date,
    $this->filter_to_date,

    // main query
    $this->company_id,

    $this->filter_from_date,
    $this->filter_from_date,

    $this->filter_to_date,
    $this->filter_to_date
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

        $companyMap = [];
        if (!empty($_SESSION['company_json'])) {
            $cData = json_decode($_SESSION['company_json'], true);
            if (is_array($cData)) {
                foreach ($cData as $c) {
                    $companyMap[$c['ids']] = $c['company_name'];
                }
            }
        }

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
        case 'get_vehicle_details_insight_search':

                        
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
        
        
                    if (!isset($resultvehicle['data']) || !is_array($resultvehicle['data'])) {
                        echo json_encode([
                            'status' => false,
                            'message' => 'No data found',
                            'html' => '',
                            'summary' => null
                        ]);
                        exit;
                    }
                    
                    $html = '<div class="row g-3 d-print-none">';
                    $printHtml = '<div class="d-none d-print-block"><table class="table table-bordered table-sm text-start" style="font-size: 12px;"><thead><tr><th>Vehicle Details</th><th>Color</th><th>Type</th><th>Status</th><th>Company</th><th>Remarks / Details</th></tr></thead><tbody>';
                foreach ($resultvehicle['data'] as $item) {

                    
                
                    $images = [];
        
                    if (!empty($item['image_json'])) {
                        $decoded = json_decode($item['image_json'], true);
                    
                        if (is_array($decoded)) {
                            $images = $decoded;
                        }
                    }
                    
                    $lastImage = count($images) > 0 ? end($images) : "default.jpg";
                
                    $data_other_details = json_decode($item['other_details_json'] ?? '', true);
                    $vehicleFuelType = !empty($item['engine_type']) ? $item['engine_type'] : ($data_other_details['vehicleFuelType'] ?? 'N/A');
                    $vehicleGearType = !empty($item['transmission']) ? $item['transmission'] : ($data_other_details['vehicleGearType'] ?? 'N/A');
                
                    $nextPassing = !empty($item['next_passing_date']) ? date('d/m/Y', strtotime($item['next_passing_date'])) : 'NA';
                    $nextInsurance = !empty($item['next_insurance_date']) ? date('d/m/Y', strtotime($item['next_insurance_date'])) : 'NA';
                    $nextMaintenance = !empty($item['next_maintenance_date']) ? date('d/m/Y', strtotime($item['next_maintenance_date'])) : 'NA';
                    
                     $price_hour_with_driver = !empty($item['next_maintenance_date']) ? date('d/m/Y', strtotime($item['next_maintenance_date'])) : 'NA';
                    $bookingJson = $item['booking_json'] ?? '[]';
                
                    $service = !empty($item['service_end_date_time']) ? new DateTime($item['service_end_date_time']) : null;
                    $extend  = !empty($item['extend_end_date']) ? new DateTime($item['extend_end_date']) : null;
                    
                    if ($service && $extend) {
                        $return_date = ($service > $extend) ? $service : $extend;
                    } elseif ($service) {
                        $return_date = $service;
                    } elseif ($extend) {
                        $return_date = $extend;
                    } else {
                        $return_date = null;
                    }
                    
                    $exp_return_date = $return_date
                        ? $return_date->format('d M Y, h:i A')
                        : '';
                    $odo = ($vehicleFuelType ?? 'N/A') . ' / ' . ($vehicleGearType ?? 'N/A');
                    $companyName = $companyMap[$item['company_id']] ?? 'Unknown';
                    $remarksText = '';
                    if ($item['vehicle_status'] == 'Rentout') {
                        $remarksText = 'On Rent: ' . ($item['customer_name'] ?? '') . ' | Agr No: ' . ($item['agreement_no'] ?? '') . ' | Exp Return: ' . (!empty($exp_return_date) ? $exp_return_date : '');
                    } else if ($item['vehicle_status'] == 'Staff Use') {
                        $remarksText = 'Staff: ' . ($item['customer_name'] ?? '') . ' | Ref No: ' . ($item['agreement_no'] ?? '') . ' | Exp Return: ' . (!empty($exp_return_date) ? $exp_return_date : '');
                    } else if ($item['vehicle_status'] == 'Maintenance') {
                        $garageName = !empty($item['garage_name']) ? $item['garage_name'] : 'N/A';
                        $reqNo = !empty($item['maintenance_request_no']) ? $item['maintenance_request_no'] : 'N/A';
                        $reqStatus = !empty($item['maintenance_request_status']) ? $item['maintenance_request_status'] : 'N/A';
                        $remarksText = 'Garage: ' . $garageName . ' | Req No: ' . $reqNo . ' | Status: ' . $reqStatus;
                    } else {
                        $remarksText = !empty($item['vehicle_status_notes']) ? $item['vehicle_status_notes'] : '';
                    }

                    $chassis = htmlspecialchars($item['chassis_number'] ?? 'N/A');
                    $detailsStr = htmlspecialchars(($item['vehicle_number'] ?? '') . ' - ' . ($item['model_names'] ?? '') . ' (' . ($item['vehicle_year'] ?? '') . ')');
                    $vehicleDetails = "<strong>{$detailsStr}</strong><br><span class='badge bg-label-info mt-1 me-1'>Chassis: {$chassis}</span>";

                    $printHtml .= '<tr>';
                    $printHtml .= '<td>' . $vehicleDetails . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($item['vehicle_color'] ?? '') . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($odo) . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($item['vehicle_status'] ?? '') . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($companyName) . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($remarksText) . '</td>';
                    $printHtml .= '</tr>';
                    ob_start();
                ?>
                
                    <div class="col-12 col-sm-6 col-md-6 col-lg-12 col-xl-6">
                <div class="card h-100 shadow-sm border-0 vehicle-card rounded-4 overflow-hidden" style="transition: transform 0.2s, box-shadow 0.2s; min-height: 180px;">
                    <div class="row g-0 h-100">
                        <!-- Left Side Image -->
                        <div class="col-6 bg-white border-end position-relative vehicle-image p-0" data-images='<?= htmlspecialchars(json_encode($images), ENT_QUOTES, "UTF-8") ?>' style="cursor:pointer;">
                            <img src="uploads/vehicleImages/<?= $lastImage ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; object-position: center; padding: 0.5rem;" alt="Vehicle Image">
                            <span class="badge rounded-pill <?=$this->getStatusClass($item['vehicle_status'])?> shadow-sm position-absolute top-0 start-0 m-2" style="font-size: 0.65rem;">
                                <?=$item['vehicle_status']?>
                            </span>
                        </div>
                        <!-- Right Side Details -->
                        <div class="col-6">
                            <div class="card-body p-2 d-flex flex-column h-100">
                                <div class="mb-2">
                                    <h5 class="mb-0 fw-bold text-danger text-truncate veh_no" title="<?=$item['vehicle_number']?>"><?=$item['vehicle_number']?></h5>
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
                                
                                <div class="d-flex gap-1 border-top pt-2 mt-auto flex-wrap">
                                    <button class="btn btn-sm btn-outline-danger flex-fill d-flex justify-content-center align-items-center action-btn btn_vehicle_view px-1" 
                                        data-bs-toggle="tooltip" title="View Details" data-id="<?=$item['ids']?>" style="font-size: 1rem;">
                                        <i class="ri ri-information-2-line me-1"></i> Details
                                    </button>
                                    
                                    <?php if ($item['vehicle_status'] == 'Rentout') { ?>
                                        <div class="small w-100 mt-2 border-top pt-1">
                                            <strong>On Rent:</strong> <?= $item['customer_name'] ?? '' ?><br>
                                            <strong class="text-danger">Agr No:</strong> <?= $item['agreement_no'] ?? '' ?><br>
                                            <strong class="text-danger">Exp Return:</strong><br>
                                            <?= !empty($exp_return_date) ? $exp_return_date : '' ?>
                                        </div>
                                    <?php } else { ?>
                                        <button class="btn btn-sm btn-danger flex-fill d-flex justify-content-center align-items-center action-btn btn_vehicle_select px-1" 
                                            data-bs-toggle="tooltip" title="Select"
                                            data-insurance="<?=$item['next_insurance_date']?>"
                                            data-passing="<?=$item['next_passing_date']?>"
                                            data-maintenance="<?=$item['next_maintenance_date']?>"
                                            data-modelName="<?=$item['model_names']?>"
                                            data-model="<?=$item['model_id']?>"
                                            data-veh_no="<?=$item['vehicle_number']?>"
                                            data-id="<?=$item['ids']?>"
                                            data-priceHWD="<?= number_format($item['price_hour_with_driver'] ?? 0, 3) ?>"
                                            data-priceHWOD="<?= number_format($item['price_hour_without_driver'] ?? 0, 3) ?>"
                                            data-priceDWD="<?= number_format($item['price_day_with_driver'] ?? 0, 3) ?>"
                                            data-priceDWOD="<?= number_format($item['price_day_without_driver'] ?? 0, 3) ?>"
                                            data-priceWWD="<?= number_format($item['price_week_with_driver'] ?? 0, 3) ?>"
                                            data-priceWWOD="<?= number_format($item['price_week_without_driver'] ?? 0, 3) ?>"
                                            data-priceMWD="<?= number_format($item['price_month_with_driver'] ?? 0, 3) ?>"
                                            data-priceMWOD="<?= number_format($item['price_month_without_driver'] ?? 0, 3) ?>" style="font-size: 1rem;">
                                            <i class="ri ri-check-line me-1"></i> Select
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
             
           
            <?php
                $html .= ob_get_clean();
            }
                    $html .= '</div>';
                    $printHtml .= '</tbody></table></div>';
                    $html .= $printHtml;
 
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
        
               case 'get_vehicle_details_insight':

                switch($this->status)
                {
                    case 'All':
                        $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[6],$this->params[6]);
                    break;
                     case 'Staffuse':
                        $this->ReturnData = $this->varPDOModelObj->ListFromTable($var[17],$this->params[17]);
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
            
                    $html = '<div class="row g-3 d-print-none">';
                    $printHtml = '<div class="d-none d-print-block"><table class="table table-bordered table-sm text-start" style="font-size: 12px;"><thead><tr><th>Vehicle Details</th><th>Color</th><th>Type</th><th>Status</th><th>Company</th><th>Remarks / Details</th></tr></thead><tbody>';
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
            
         $service = !empty($item['service_end_date_time']) ? new DateTime($item['service_end_date_time']) : null;
        $extend  = !empty($item['extend_end_date']) ? new DateTime($item['extend_end_date']) : null;
        
        if ($service && $extend) {
            $return_date = ($service > $extend) ? $service : $extend;
        } elseif ($service) {
            $return_date = $service;
        } elseif ($extend) {
            $return_date = $extend;
        } else {
            $return_date = null;
        }
        
        $exp_return_date = $return_date
            ? $return_date->format('d M Y, h:i A')
            : '';
            
            
            $odo = ($vehicleFuelType ?? 'N/A') . ' / ' . ($vehicleGearType ?? 'N/A');
                    $companyName = $companyMap[$item['company_id']] ?? 'Unknown';
                    $remarksText = '';
                    if ($item['vehicle_status'] == 'Rentout') {
                        $remarksText = 'On Rent: ' . ($item['customer_name'] ?? '') . ' | Agr No: ' . ($item['agreement_no'] ?? '') . ' | Exp Return: ' . (!empty($exp_return_date) ? $exp_return_date : '');
                    } else if ($item['vehicle_status'] == 'Staff Use') {
                        $remarksText = 'Staff: ' . ($item['customer_name'] ?? '') . ' | Ref No: ' . ($item['agreement_no'] ?? '') . ' | Exp Return: ' . (!empty($exp_return_date) ? $exp_return_date : '');
                    } else if ($item['vehicle_status'] == 'Maintenance') {
                        $garageName = !empty($item['garage_name']) ? $item['garage_name'] : 'N/A';
                        $reqNo = !empty($item['maintenance_request_no']) ? $item['maintenance_request_no'] : 'N/A';
                        $reqStatus = !empty($item['maintenance_request_status']) ? $item['maintenance_request_status'] : 'N/A';
                        $remarksText = 'Garage: ' . $garageName . ' | Req No: ' . $reqNo . ' | Status: ' . $reqStatus;
                    } else {
                        $remarksText = !empty($item['vehicle_status_notes']) ? $item['vehicle_status_notes'] : '';
                    }

                    $chassis = htmlspecialchars($item['chassis_number'] ?? 'N/A');
                    $detailsStr = htmlspecialchars(($item['vehicle_number'] ?? '') . ' - ' . ($item['model_names'] ?? '') . ' (' . ($item['vehicle_year'] ?? '') . ')');
                    $vehicleDetails = "<strong>{$detailsStr}</strong><br><span class='badge bg-label-info mt-1 me-1'>Chassis: {$chassis}</span>";

                    $printHtml .= '<tr>';
                    $printHtml .= '<td>' . $vehicleDetails . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($item['vehicle_color'] ?? '') . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($odo) . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($item['vehicle_status'] ?? '') . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($companyName) . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($remarksText) . '</td>';
                    $printHtml .= '</tr>';
                    ob_start();
        ?>
        
            <div class="col-12 col-sm-6 col-md-6 col-lg-12 col-xl-4">
                <div class="card h-100 shadow-sm border-0 vehicle-card rounded-4 overflow-hidden" style="transition: transform 0.2s, box-shadow 0.2s; min-height: 180px;">
                    <div class="row g-0 h-100">
                        <!-- Left Side Image -->
                        <div class="col-6 bg-white border-end position-relative vehicle-image p-0" data-images='<?= htmlspecialchars(json_encode($images), ENT_QUOTES, "UTF-8") ?>' style="cursor:pointer;">
                            <img src="uploads/vehicleImages/<?= $lastImage ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; object-position: center; padding: 0.5rem;" alt="Vehicle Image">
                            <span class="badge rounded-pill <?=$this->getStatusClass($item['vehicle_status'])?> shadow-sm position-absolute top-0 start-0 m-2" style="font-size: 0.65rem;">
                                <?=$item['vehicle_status']?>
                            </span>
                        </div>
                        <!-- Right Side Details -->
                        <div class="col-6">
                            <div class="card-body p-2 d-flex flex-column h-100">
                                <div class="mb-2">
                                    <h5 class="mb-0 fw-bold text-danger text-truncate veh_no" title="<?=$item['vehicle_number']?>"><?=$item['vehicle_number']?></h5>
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
                                
                                <div class="d-flex gap-1 border-top pt-2 mt-auto flex-wrap">
                                    <button class="btn btn-sm btn-outline-danger flex-fill d-flex justify-content-center align-items-center action-btn btn_vehicle_view px-1" 
                                        data-bs-toggle="tooltip" title="View Details" data-id="<?=$item['ids']?>" style="font-size: 1rem;">
                                        <i class="ri ri-information-2-line me-1"></i> Details
                                    </button>
                                    
                                    <?php if ($item['vehicle_status'] == 'Rentout') { ?>
                                        <div class="small w-100 mt-2 border-top pt-1">
                                            <strong>On Rent:</strong> <?= $item['customer_name'] ?? '' ?><br>
                                            <strong class="text-danger">Agr No:</strong> <?= $item['agreement_no'] ?? '' ?><br>
                                            <strong class="text-danger">Exp Return:</strong><br>
                                            <?= !empty($exp_return_date) ? $exp_return_date : '' ?>
                                        </div>
                                    <?php } else if($item['vehicle_status'] == 'Staff Use') { ?>
                                        <div class="small w-100 mt-2 border-top pt-1">
                                            <strong>Staff:</strong> <?= $item['customer_name'] ?? '' ?><br>
                                            <strong class="text-danger">Ref No:</strong> <?= $item['agreement_no'] ?? '' ?><br>
                                            <strong class="text-danger">Exp Return:</strong><br>
                                            <?= !empty($exp_return_date) ? $exp_return_date : '' ?>
                                        </div>
                                    <?php } else if($item['vehicle_status'] == 'Maintenance') { 
                                        $garageName = !empty($item['garage_name']) ? $item['garage_name'] : 'N/A';
                                        $reqNo = !empty($item['maintenance_request_no']) ? $item['maintenance_request_no'] : 'N/A';
                                        $reqStatus = !empty($item['maintenance_request_status']) ? $item['maintenance_request_status'] : 'N/A';
                                        $reqId = !empty($item['maintenance_request_id']) ? $item['maintenance_request_id'] : '';
                                        $reqNoHtml = !empty($reqId) ? '<a href="javascript:void(0);" class="view-maintenance-request text-primary fw-bold" data-id="'.$reqId.'">'.htmlspecialchars($reqNo).'</a>' : htmlspecialchars($reqNo);
                                    ?>
                                        <div class="small w-100 mt-2 border-top pt-1">
                                            <strong>Garage:</strong> <?= htmlspecialchars($garageName) ?><br>
                                            <strong>Req No:</strong> <?= $reqNoHtml ?><br>
                                            <strong class="text-danger">Status:</strong> <?= htmlspecialchars($reqStatus) ?><br>
                                            <strong class="text-danger">Next Maintenance:</strong> <?= $nextMaintenance ?>
                                        </div>
                                    <?php } else { ?>
                                        <button class="btn btn-sm btn-danger flex-fill d-flex justify-content-center align-items-center action-btn btn_vehicle_select px-1" 
                                            data-bs-toggle="tooltip" title="Select"
                                            data-insurance="<?=$item['next_insurance_date']?>"
                                            data-passing="<?=$item['next_passing_date']?>"
                                            data-maintenance="<?=$item['next_maintenance_date']?>"
                                            data-modelName="<?=$item['model_names']?>"
                                            data-model="<?=$item['model_id']?>"
                                            data-veh_no="<?=$item['vehicle_number']?>"
                                            data-id="<?=$item['ids']?>"
                                            data-priceHWD="<?= number_format($item['price_hour_with_driver'] ?? 0, 3) ?>"
                                            data-priceHWOD="<?= number_format($item['price_hour_without_driver'] ?? 0, 3) ?>"
                                            data-priceDWD="<?= number_format($item['price_day_with_driver'] ?? 0, 3) ?>"
                                            data-priceDWOD="<?= number_format($item['price_day_without_driver'] ?? 0, 3) ?>"
                                            data-priceWWD="<?= number_format($item['price_week_with_driver'] ?? 0, 3) ?>"
                                            data-priceWWOD="<?= number_format($item['price_week_without_driver'] ?? 0, 3) ?>"
                                            data-priceMWD="<?= number_format($item['price_month_with_driver'] ?? 0, 3) ?>"
                                            data-priceMWOD="<?= number_format($item['price_month_without_driver'] ?? 0, 3) ?>" style="font-size: 1rem;">
                                            <i class="ri ri-check-line me-1"></i> Select
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        $html .= ob_get_clean();
    }
                    $html .= '</div>';
                    $printHtml .= '</tbody></table></div>';
                    $html .= $printHtml;
 
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
           case 'update_vehicle_status':

                $log_details = [
                    "user_id" => $this->user_id,
                    "datetime" => date('Y-m-d H:i:s')
                ];
            
                $log_json = json_encode($log_details);
                $this->selectedVehicles = array_values(array_map('intval', $this->selectedVehicles));

                if (!empty($this->selectedVehicles) && !empty($this->status)) {
                
                    $placeholders = implode(',', array_fill(0, count($this->selectedVehicles), '?'));
                
                    // Fetch existing details for logging
                    $stmt = $this->varPDOModelObj->varDBPDO->prepare("SELECT ids, vehicle_number, vehicle_status FROM tbl_vehicles WHERE ids IN ($placeholders)");
                    $stmt->execute($this->selectedVehicles);
                    $existingVehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $updateQuery = "UPDATE tbl_vehicles 
                                    SET vehicle_status = ?, 
                                        vehicle_status_notes = ?, 
                                        vehicle_status_log_json = ? 
                                    WHERE ids IN ($placeholders)";
                
                    $updateParams = array_merge(
                        [$this->status, $this->notes, $log_json],
                        $this->selectedVehicles
                    );
                
                    $this->ReturnData = $this->varPDOModelObj->executeQuery(
                        $updateQuery,
                        $updateParams
                    );
                    
                    if ($this->ReturnData) {
                        // Log vehicle movement
                        if (!empty($existingVehicles)) {
                            foreach($existingVehicles as $v) {
                                $this->varPDOModelObj->logVehicleMovement([
                                    'vehicle_id' => $v['ids'],
                                    'action_type' => 'Status Changed',
                                    'old_status' => $v['vehicle_status'],
                                    'new_status' => $this->status,
                                    'reference_type' => 'VehicleInsight',
                                    'reference_id' => $v['ids'],
                                    'reference_no' => $v['vehicle_number'],
                                    'remarks' => $this->notes
                                ]);
                            }
                        }

                        echo json_encode([
                            'status' => true,
                            'message' => 'Vehicle status updated successfully'
                        ]);
                    }
                }
                 else {
                    echo json_encode([
                        'status' => false,
                        'message' => 'Invalid input'
                    ]);
                }
            
            break;
               case 'get_vehicle_return_details':

                        
                     if($this->modelId=='0' || $this->modelId=='All')
                        {
                            $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                            $var[15],$this->params[15]);
                           
                        }
                        else
                        {
                            $this->ReturnData = $this->varPDOModelObj->ListFromTable(
                            $var[16],$this->params[16]);
                            
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
                    $printHtml = '<div class="d-none d-print-block"><table class="table table-bordered table-sm text-start" style="font-size: 12px;"><thead><tr><th>Vehicle Details</th><th>Color</th><th>Type</th><th>Status</th><th>Company</th><th>Remarks / Details</th></tr></thead><tbody>';
                foreach ($resultvehicle['data'] as $item) {
                
                    $images = [];
        
                    if (!empty($item['image_json'])) {
                        $decoded = json_decode($item['image_json'], true);
                    
                        if (is_array($decoded)) {
                            $images = $decoded;
                        }
                    }
                    
                    $lastImage = count($images) > 0 ? end($images) : "default.jpg";
                
                    $data_other_details = json_decode($item['other_details_json'] ?? '', true);
                    $vehicleFuelType = !empty($item['engine_type']) ? $item['engine_type'] : ($data_other_details['vehicleFuelType'] ?? 'N/A');
                    $vehicleGearType = !empty($item['transmission']) ? $item['transmission'] : ($data_other_details['vehicleGearType'] ?? 'N/A');
                
                    $nextPassing = !empty($item['next_passing_date']) ? date('d/m/Y', strtotime($item['next_passing_date'])) : 'NA';
                    $nextInsurance = !empty($item['next_insurance_date']) ? date('d/m/Y', strtotime($item['next_insurance_date'])) : 'NA';
                    $nextMaintenance = !empty($item['next_maintenance_date']) ? date('d/m/Y', strtotime($item['next_maintenance_date'])) : 'NA';
                    
                     $price_hour_with_driver = !empty($item['next_maintenance_date']) ? date('d/m/Y', strtotime($item['next_maintenance_date'])) : 'NA';
                    $bookingJson = $item['booking_json'] ?? '[]';
                
                    $service = !empty($item['service_end_date_time']) ? new DateTime($item['service_end_date_time']) : null;
                    $extend  = !empty($item['extend_end_date']) ? new DateTime($item['extend_end_date']) : null;
                    
                    if ($service && $extend) {
                        $return_date = ($service > $extend) ? $service : $extend;
                    } elseif ($service) {
                        $return_date = $service;
                    } elseif ($extend) {
                        $return_date = $extend;
                    } else {
                        $return_date = null;
                    }
                    
                    $exp_return_date = $return_date
                        ? $return_date->format('d M Y, h:i A')
                        : '';
                    $odo = ($vehicleFuelType ?? 'N/A') . ' / ' . ($vehicleGearType ?? 'N/A');
                    $companyName = $companyMap[$item['company_id']] ?? 'Unknown';
                    $remarksText = '';
                    if ($item['vehicle_status'] == 'Rentout') {
                        $remarksText = 'On Rent: ' . ($item['customer_name'] ?? '') . ' | Agr No: ' . ($item['agreement_no'] ?? '') . ' | Exp Return: ' . (!empty($exp_return_date) ? $exp_return_date : '');
                    } else if ($item['vehicle_status'] == 'Staff Use') {
                        $remarksText = 'Staff: ' . ($item['customer_name'] ?? '') . ' | Ref No: ' . ($item['agreement_no'] ?? '') . ' | Exp Return: ' . (!empty($exp_return_date) ? $exp_return_date : '');
                    } else if ($item['vehicle_status'] == 'Maintenance') {
                        $garageName = !empty($item['garage_name']) ? $item['garage_name'] : 'N/A';
                        $reqNo = !empty($item['maintenance_request_no']) ? $item['maintenance_request_no'] : 'N/A';
                        $reqStatus = !empty($item['maintenance_request_status']) ? $item['maintenance_request_status'] : 'N/A';
                        $remarksText = 'Garage: ' . $garageName . ' | Req No: ' . $reqNo . ' | Status: ' . $reqStatus;
                    } else {
                        $remarksText = !empty($item['vehicle_status_notes']) ? $item['vehicle_status_notes'] : '';
                    }

                    $chassis = htmlspecialchars($item['chassis_number'] ?? 'N/A');
                    $detailsStr = htmlspecialchars(($item['vehicle_number'] ?? '') . ' - ' . ($item['model_names'] ?? '') . ' (' . ($item['vehicle_year'] ?? '') . ')');
                    $vehicleDetails = "<strong>{$detailsStr}</strong><br><span class='badge bg-label-info mt-1 me-1'>Chassis: {$chassis}</span>";

                    $printHtml .= '<tr>';
                    $printHtml .= '<td>' . $vehicleDetails . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($item['vehicle_color'] ?? '') . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($odo) . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($item['vehicle_status'] ?? '') . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($companyName) . '</td>';
                    $printHtml .= '<td>' . htmlspecialchars($remarksText) . '</td>';
                    $printHtml .= '</tr>';
                    ob_start();
                ?>
                
                    <div class="col-12 col-sm-6 col-md-6 col-lg-12 col-xl-4">
                <div class="card h-100 shadow-sm border-0 vehicle-card rounded-4 overflow-hidden" style="transition: transform 0.2s, box-shadow 0.2s; min-height: 180px;">
                    <div class="row g-0 h-100">
                        <!-- Left Side Image -->
                        <div class="col-6 bg-white border-end position-relative vehicle-image p-0" data-images='<?= htmlspecialchars(json_encode($images), ENT_QUOTES, "UTF-8") ?>' style="cursor:pointer;">
                            <img src="uploads/vehicleImages/<?= $lastImage ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; object-position: center; padding: 0.5rem;" alt="Vehicle Image">
                            <span class="badge rounded-pill <?=$this->getStatusClass($item['vehicle_status'])?> shadow-sm position-absolute top-0 start-0 m-2" style="font-size: 0.65rem;">
                                <?=$item['vehicle_status']?>
                            </span>
                        </div>
                        <!-- Right Side Details -->
                        <div class="col-6">
                            <div class="card-body p-2 d-flex flex-column h-100">
                                <div class="mb-2">
                                    <h5 class="mb-0 fw-bold text-danger text-truncate veh_no" title="<?=$item['vehicle_number']?>"><?=$item['vehicle_number']?></h5>
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
                                
                                <div class="d-flex gap-1 border-top pt-2 mt-auto flex-wrap">
                                    <button class="btn btn-sm btn-outline-danger flex-fill d-flex justify-content-center align-items-center action-btn btn_vehicle_view px-1" 
                                        data-bs-toggle="tooltip" title="View Details" data-id="<?=$item['ids']?>" style="font-size: 1rem;">
                                        <i class="ri ri-information-2-line me-1"></i> Details
                                    </button>
                                    
                                    <?php if ($item['vehicle_status'] == 'Rentout') { ?>
                                        <div class="small w-100 mt-2 border-top pt-1">
                                            <strong>On Rent:</strong> <?= $item['customer_name'] ?? '' ?><br>
                                            <strong class="text-danger">Agr No:</strong> <?= $item['agreement_no'] ?? '' ?><br>
                                            <strong class="text-danger">Exp Return:</strong><br>
                                            <?= !empty($exp_return_date) ? $exp_return_date : '' ?>
                                        </div>
                                    <?php } else if ($item['vehicle_status'] == 'Staff Use') { ?>
                                        <div class="small w-100 mt-2 border-top pt-1">
                                            <strong>Staff:</strong> <?= $item['customer_name'] ?? '' ?><br>
                                            <strong class="text-danger">Ref No:</strong> <?= $item['agreement_no'] ?? '' ?><br>
                                            <strong class="text-danger">Exp Return:</strong><br>
                                            <?= !empty($exp_return_date) ? $exp_return_date : '' ?>
                                        </div>
                                    <?php } else if ($item['vehicle_status'] == 'Maintenance') {
                                        $garageName = !empty($item['garage_name']) ? $item['garage_name'] : 'N/A';
                                        $reqNo = !empty($item['maintenance_request_no']) ? $item['maintenance_request_no'] : 'N/A';
                                        $reqStatus = !empty($item['maintenance_request_status']) ? $item['maintenance_request_status'] : 'N/A';
                                    ?>
                                        <div class="small w-100 mt-2 border-top pt-1">
                                            <strong>Garage:</strong> <?= htmlspecialchars($garageName) ?><br>
                                            <strong>Req No:</strong> <?= htmlspecialchars($reqNo) ?><br>
                                            <strong class="text-danger">Status:</strong> <?= htmlspecialchars($reqStatus) ?><br>
                                            <strong class="text-danger">Next Maintenance:</strong> <?= $nextMaintenance ?>
                                        </div>
                                    <?php } ?>
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
