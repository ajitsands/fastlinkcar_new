<?php
session_start();
header('Content-Type: application/json');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
class DailyReportController
{
    var $varPDOModelObj;
    public $json, $actionevents;
    public $params = array();

    public $id, $company_id, $user_id, $createdDate, $customer_code, $vehicle_model,$startDate,$endDate,$staff_id,$vehicle_id;
   
    function __construct()
    {
        $this->varPDOModelObj = new CommonPDOModel();

        
        $this->id = $_POST['id'] ?? null;
        
        $this->company_id = $_SESSION['company_id'] ?? 1;
        $this->user_id = $_SESSION['user_id'] ?? 1;
        $this->actionevents = $_POST['action'] ?? null;
        date_default_timezone_set('Asia/Bahrain');
        $this->createdDate = date('Y-m-d H:i:s');
        
       
        $this->customer_code = $_POST['customer_code'] ?? null;
        $this->vehicle_model = $_POST['vehicle_model'] ?? null;
        
        $this->staff_id = $_POST['staff_id'] ?? null;
        $this->vehicle_id = $_POST['vehicle_id'] ?? null;
       
        $this->startDate = !empty($_POST['startDate']) 
            ? date('Y-m-d', strtotime($_POST['startDate'])) 
            : date('Y-01-01');
        
        $this->endDate = !empty($_POST['endDate']) 
            ? date('Y-m-d', strtotime($_POST['endDate'])) 
            : date('Y-12-31');
        
        
        
       
    }

    function SQLArray()
    {
        $array = array();

       
      
        return $array;
    }

    function DataRequest($action)
    {
        $var = $this->SQLArray();

        switch ($action) {

          
           case 'GetDailyRentalReport':
            $sql = "SELECT
                r.ids,
                r.agreement_date,
                r.agreement_no,
                r.customer_code,
                r.customer_name,
                r.vehicle_id,
                c.customer_type,
                c.customer_mobile,
                c.customer_email,
                c.customer_cr_cpr,
            
                r.vehicle_no,
                JSON_UNQUOTE(JSON_EXTRACT(r.vechile_details,'$.model_name')) AS model_name,
                JSON_UNQUOTE(JSON_EXTRACT(r.vechile_details,'$.vehicle_color')) AS vehicle_color,
                JSON_UNQUOTE(JSON_EXTRACT(r.vechile_details,'$.vehicle_year')) AS vehicle_year,
            
                JSON_UNQUOTE(JSON_EXTRACT(r.contract_details_json,'$.duration')) AS duration,
                JSON_UNQUOTE(JSON_EXTRACT(r.contract_details_json,'$.unit_price')) AS unit_price,
                 JSON_UNQUOTE(JSON_EXTRACT(r.contract_details_json,'$.vat')) AS vat,
                JSON_UNQUOTE(JSON_EXTRACT(r.contract_details_json,'$.rate_type')) AS rate_type,
                JSON_UNQUOTE(JSON_EXTRACT(r.contract_details_json,'$.service_name')) AS service_name,
                JSON_UNQUOTE(JSON_EXTRACT(r.contract_details_json,'$.total_amt')) AS total_amt,
           
                r.service_type,
                r.delivered_signatory,
                r.agreement_status
            
            FROM tbl_vehicle_rentout_contracts r
            LEFT JOIN customer_details c
                   ON c.customer_id = r.customer_code WHERE r.company_id = :company_id AND r.agreement_status IN ('Rentout','Extended')
              AND r.agreement_date BETWEEN :start_date AND :end_date
             ";
            
            $params = [
             ':company_id' => $this->company_id,
             ':start_date'  => $this->startDate,
             ':end_date'    => $this->endDate
            ];
            
           
            if (!empty($this->customer_code) && $this->customer_code != 'All') {
                    $sql .= " AND customer_code = :customer_code";
                    $params[':customer_code'] = trim($this->customer_code);
                }
            if (!empty($this->vehicle_model) && $this->vehicle_model != 'All') {
                    $sql .= " AND vehicle_model_id = :vehicle_model_id";
                    $params[':vehicle_model_id'] = trim($this->vehicle_model);
                }
            $sql .= " ORDER BY ids ASC";
 
            $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql, $params);
           
                
            $result = json_decode($this->ReturnData, true);
        
            $decimals = 3; // adjust if needed
            $data = [];
        
            if (!empty($result['data'])) {
                  $sl = 1;
                foreach ($result['data'] as $row) {
        
                    $date = date("d-m-Y", strtotime($row['agreement_date']));
                    $unit_price = number_format((float)$row['unit_price'], $decimals);
                    $vat = htmlspecialchars($row['vat']);
                    
                    $total_amt = number_format((float)$row['total_amt'], $decimals);
        
                    $id = (int)$row['ids'];
                    $agreement_no = htmlspecialchars($row['agreement_no']);
                    $customer_name = htmlspecialchars($row['customer_name']);
                    $customer_phone = htmlspecialchars($row['customer_mobile']);
                    $customer_cpr_cr = htmlspecialchars($row['customer_cr_cpr']);
                    $vehicle_no = htmlspecialchars($row['vehicle_no']);
                    $vehicle_id = htmlspecialchars($row['vehicle_id']);
                    $model_name = htmlspecialchars($row['model_name']);
                    $vehicle_color = htmlspecialchars($row['vehicle_color']);
                    $vehicle_year = htmlspecialchars($row['vehicle_year']);
                    $model_name = htmlspecialchars($row['model_name']);
                    $duration = htmlspecialchars($row['duration']);
                   
                    $rate_type = htmlspecialchars($row['rate_type']);
                    $service_name = htmlspecialchars($row['service_name']);
                    
                    $service_type = htmlspecialchars($row['service_type']);
                    $customer_type = htmlspecialchars($row['customer_type']);
                     $delivered_signatory = htmlspecialchars($row['delivered_signatory']);
                    
                    $customer_val=$customer_name.' | '.$customer_phone.' | '.$customer_cpr_cr;
                    $agreement_link = "<a href='javascript:void(0);'
                        class='view_contract_table'
                        data-id='{$id}' data-contract='{$agreement_no}'>
                        {$agreement_no}
                   </a>";

                    $vehicle_link = "<a href='javascript:void(0);'
                      class='btn_vehicle_view'
                      data-id='{$vehicle_id}'>
                      {$vehicle_no}
                 </a>";
               
                    $data[] = [
                         $sl++, 
                        $customer_val,
                        $customer_type,
                        $agreement_link,
                        $vehicle_link,
                        $model_name,
                        $date,
                        $service_name,
                        $rate_type,
                        "<div style='text-align:center'>{$duration}</div>",
                        "<div style='text-align:right'>{$unit_price}</div>",
                        "<div style='text-align:center'>{$vat}</div>",
                        "<div style='text-align:right'>{$total_amt}</div>",
                        $delivered_signatory
                    ];
                }
            }
        
            echo json_encode([
                "data" => $data
            ]);
        
            break;
              case 'GetDailyCashReport':
                        $sql = "
            SELECT
                cm.id,
                cm.cashmemo_date AS transaction_date,
                cm.cashmemo_no AS voucher_no,
                cm.customer_code,
                cm.customer_name,
                c.customer_type,
                c.customer_mobile,
                c.customer_email,
                c.customer_cr_cpr,
                cm.cashmemo_payment_type AS payment_type,
                JSON_UNQUOTE(JSON_EXTRACT(cm.items, '$[0].item_name')) AS item_name,
                cm.grand_total AS income,
                0.000 AS expense,
                cm.cashmemo_notes AS remarks,
                cm.vehicle_ids,
                cm.vehicle_no,
                cm.user_name,
                cm.agreement_no,
                cm.model_names,
                'Income' AS transaction_type,
                cm.cashmemo_payment_type AS payment_mode
            FROM cashmemo cm
            LEFT JOIN customer_details c
                ON c.customer_id = cm.customer_code
            WHERE cm.company_id = :company_id1
              AND cm.cashmemo_date BETWEEN :start_date1 AND :end_date1";
            
            if (!empty($this->customer_code) && $this->customer_code != 'All') {
                $sql .= " AND cm.customer_code = :customer_code1";
            }
            
            if (!empty($this->vehicle_model) && $this->vehicle_model != 'All') {
                $sql .= " AND cm.model_ids = :vehicle_model_id1";
            }

    $sql .= "
    
    UNION ALL
    
    SELECT
        ev.id,
        ev.expensevoucher_date AS transaction_date,
        ev.expensevoucher_no AS voucher_no,
        ev.customer_code,
        ev.customer_name,
        c.customer_type,
        c.customer_mobile,
        c.customer_email,
        c.customer_cr_cpr,
        ev.expensevoucher_payment_type AS payment_type,
        JSON_UNQUOTE(JSON_EXTRACT(ev.items, '$[0].item_name')) AS item_name,
        0.000 AS income,
        ev.grand_total AS expense,
        ev.expensevoucher_notes AS remarks,
        ev.vehicle_ids,
        ev.vehicle_no,
        ev.user_name,
        ev.agreement_no,
        ev.model_names,
        'Expense' AS transaction_type,
        ev.expensevoucher_payment_type AS payment_mode
    FROM expensevoucher ev
    LEFT JOIN customer_details c
        ON c.customer_id = ev.customer_code
    WHERE ev.company_id = :company_id2
      AND ev.expensevoucher_date BETWEEN :start_date2 AND :end_date2";
    
    if (!empty($this->customer_code) && $this->customer_code != 'All') {
        $sql .= " AND ev.customer_code = :customer_code2";
    }
    
    if (!empty($this->vehicle_model) && $this->vehicle_model != 'All') {
        $sql .= " AND ev.model_ids = :vehicle_model_id2";
    }
    
    $sql = "SELECT * FROM (".$sql.") x
             ORDER BY transaction_date ASC, voucher_no ASC";
         $params = [
            ':company_id1' => $this->company_id,
            ':start_date1' => $this->startDate,
            ':end_date1'   => $this->endDate,
        
            ':company_id2' => $this->company_id,
            ':start_date2' => $this->startDate,
            ':end_date2'   => $this->endDate,
        ];
        
        if (!empty($this->customer_code) && $this->customer_code != 'All') {
            $params[':customer_code1'] = trim($this->customer_code);
            $params[':customer_code2'] = trim($this->customer_code);
        }
        
        if (!empty($this->vehicle_model) && $this->vehicle_model != 'All') {
            $params[':vehicle_model_id1'] = trim($this->vehicle_model);
            $params[':vehicle_model_id2'] = trim($this->vehicle_model);
        }
 
            $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql, $params);
           
            
            $result = json_decode($this->ReturnData, true);
        
            $decimals = 3; // adjust if needed
            $data = [];
        
            if (!empty($result['data'])) {
                  $sl = 1;
                foreach ($result['data'] as $row) {
        
                    $date = date("d-m-Y", strtotime($row['transaction_date']));
                    $expense = number_format((float)$row['expense'], $decimals);
                    
                    $income = number_format((float)$row['income'], $decimals);
        
                    $id = (int)$row['id'];
                    $voucher_no = htmlspecialchars($row['voucher_no']);
                    $customer_name = htmlspecialchars($row['customer_name']);
                    $customer_phone = htmlspecialchars($row['customer_mobile']);
                    $customer_cpr_cr = htmlspecialchars($row['customer_cr_cpr']);
                    $vehicle_no = htmlspecialchars($row['vehicle_no']);
                    $vehicle_id = htmlspecialchars($row['vehicle_ids']);
                    $model_name = htmlspecialchars($row['model_names']);
                    
                    $item_name = htmlspecialchars($row['item_name']);
                    $payment_mode = htmlspecialchars($row['payment_mode']);
                    $remarks = htmlspecialchars($row['remarks']);
                    $customer_type = htmlspecialchars($row['customer_type']);
                    $customer_val=$customer_name.' | '.$customer_phone.' | '.$customer_cpr_cr;
                    $agreement_link = "<a href='javascript:void(0);'
                        class='view_contract_table'
                        data-id='{$id}' data-contract='{$agreement_no}'>
                        {$agreement_no}
                   </a>";

                    $vehicle_link = "<a href='javascript:void(0);'
                      class='btn_vehicle_view'
                      data-id='{$vehicle_id}'>
                      {$vehicle_no}
                 </a>";
               
                    $data[] = [
                         $sl++, 
                         $date,
                        $voucher_no,
                        $payment_mode,
                        $agreement_link,
                        $customer_name,
                        $item_name,
                        $remarks,
                        "<div style='text-align:right'>{$income}</div>",
                        "<div style='text-align:right'>{$expense}</div>"
                    ];
                }
            }
        
            echo json_encode([
                "data" => $data
            ]);
            break;
            
                
           case 'GetNonRevenueReport':
            $sql = "SELECT
                r.ids,
                r.booking_no,
                r.category_name,
                r.brand_name,
                r.model_name,
                r.vehicle_id,
                r.vehicle_no,
                r.staff_ids,
                r.staff_name,
                r.book_from_date,
                r.book_to_date,
                r.notes,
                r.book_status,
                r.return_notes,
                JSON_UNQUOTE(JSON_EXTRACT(r.staff_details_json,'$.mobile')) AS mobile,
                JSON_UNQUOTE(JSON_EXTRACT(r.staff_details_json,'$.email')) AS email,
                JSON_UNQUOTE(JSON_EXTRACT(r.staff_details_json,'$.licence_no')) AS licence_no,
                JSON_UNQUOTE(JSON_EXTRACT(r.staff_details_json,'$.cpr_no')) AS cpr_no,
                JSON_UNQUOTE(JSON_EXTRACT(r.staff_details_json,'$.licence_expiry_date')) AS licence_expiry_date
            FROM tbl_vehicle_non_revenue_ticket r
            WHERE r.company_id = :company_id
            AND (
                    r.book_from_date <= :end_date
                    AND (
                        r.book_to_date IS NULL
                        OR r.book_to_date >= :start_date
                    )
                )
             ";
            
            $params = [
             ':company_id' => $this->company_id,
             ':end_date'   => $this->endDate . ' 23:59:59',
              ':start_date' => $this->startDate . ' 00:00:00'
            ];
            
           
            if (!empty($this->staff_id) && $this->staff_id != 'All') {
                    $sql .= " AND staff_ids = :staff_id";
                    $params[':staff_id'] = trim($this->staff_id);
                }
            if (!empty($this->vehicle_id) && $this->vehicle_id != 'All') {
                    $sql .= " AND vehicle_id = :vehicle_id";
                    $params[':vehicle_id'] = trim($this->vehicle_id);
                }
            $sql .= " ORDER BY ids DESC";
 
            $this->ReturnData = $this->varPDOModelObj->ListFromTable($sql, $params);
           
                
            $result = json_decode($this->ReturnData, true);
        
            $decimals = 3; // adjust if needed
            $data = [];
        
            if (!empty($result['data'])) {
                  $sl = 1;
                foreach ($result['data'] as $row) {
      
                    $fromdate = date("d-m-Y", strtotime($row['book_from_date']));
                    $todate = date("d-m-Y", strtotime($row['book_to_date']));
                    // $vat = htmlspecialchars($row['vat']);
                    // $total_amt = number_format((float)$row['total_amt'], $decimals);
                    $id = (int)$row['ids'];
                    $booking_no = htmlspecialchars($row['booking_no']);
                    $staff_name = htmlspecialchars($row['staff_name']);
                    $mobile = htmlspecialchars($row['mobile']);
                    $category_name = htmlspecialchars($row['category_name']);
                    $brand_name = htmlspecialchars($row['brand_name']);
                    $model_name = htmlspecialchars($row['model_name']);
                    $vehicle_id = htmlspecialchars($row['vehicle_id']);
                    $vehicle_no = htmlspecialchars($row['vehicle_no']);
                    $staff_ids = htmlspecialchars($row['staff_ids']);
                    $notes = htmlspecialchars($row['notes']);
                    $book_status = htmlspecialchars($row['book_status']);
                    switch ($book_status) {
                        case 'Rentout':
                            $status_badge = '<span class="badge bg-warning ">At Staff</span>';
                            break;
                    
                        case 'Returned':
                            $status_badge = '<span class="badge bg-success">Returned</span>';
                            break;
                    
                        default:
                            $status_badge = '<span class="badge bg-secondary">'.$book_status.'</span>';
                            break;
                    }
                    $return_notes = htmlspecialchars($row['return_notes']);
                    
                    $staff_val=$staff_name.' | '.$mobile;
                    $vehicle_val=$vehicle_no.' | '.$brand_name.' '.$model_name;
                    $period_val=$fromdate.' to '.$todate;
                    
                    $vehicle_link = "<a href='javascript:void(0);'
                      class='btn_vehicle_view'
                      data-id='{$vehicle_id}'>
                      {$vehicle_val}
                 </a>";
                   $from = new DateTime($row['book_from_date']);

if (!empty($row['book_to_date'])) {

    $to = new DateTime($row['book_to_date']);
    $period = $from->format('d-M-Y H:i') . ' <b>to</b> ' . $to->format('d-M-Y H:i');

    $interval = $from->diff($to);
    $badgeClass = "bg-info-subtle text-info border border-info";
    $prefix = "";

} else {

    // Booking still active
    $to = new DateTime(); // Current date & time
    $period = $from->format('d-M-Y H:i') . ' <b>to</b> <span class="text-danger">Till Now</span>';

    $interval = $from->diff($to);
    $badgeClass = "bg-warning-subtle text-warning border border-warning";
    $prefix = "Ongoing: ";
}

$duration = [];

if ($interval->days > 0)
    $duration[] = $interval->days . ' Day' . ($interval->days > 1 ? 's' : '');

if ($interval->h > 0)
    $duration[] = $interval->h . ' Hr' . ($interval->h > 1 ? 's' : '');

if ($interval->i > 0)
    $duration[] = $interval->i . ' Min';

if (empty($duration))
    $duration[] = '0 Min';

$period_val = '
<div>
    <div style="font-weight:600;color:#2c3e50;">
        '.$period.'
    </div>
    <span class="badge '.$badgeClass.' mt-1">
        <i class="icon-history me-1"></i> '.$prefix.implode(' ', $duration).'
    </span>
</div>';
                    $data[] = [
                         $sl++, 
                        $booking_no,
                        $staff_val,
                        $vehicle_link,
                        $period_val,
                        $notes,
                        $return_notes,
                        $status_badge
                    ];
                }
            }
        
            echo json_encode([
                "data" => $data
            ]);
        
            break;
            default:
                $noAction = json_encode([
                    'status' => false,
                    'message' => "No Action Found"
                ]);

                echo $noAction;

                Logger::ActivityLog(
                    'DailyReport',
                    "default",
                    [json_decode($noAction)]
                );

           break;
        }
    }
    

}

$obj = new DailyReportController();
$obj->DataRequest($obj->actionevents);
