<?php
define('ROOT_PATH', __DIR__);
//$rootPath = realpath(__DIR__ );
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();

if (isset($_ENV['APP_TIMEZONE'])) {
        date_default_timezone_set($_ENV['APP_TIMEZONE']);
}


$mysqli = new mysqli("localhost", "sandsl23_quotation_user", "S@nds1@b", "sandsl23_quotation");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$quotation_id = $_POST['quotation_id'] ?? '';
$action_type = $_POST['action_type'] ?? 'new';
$save_type = $_POST['save_type'] ?? 'final';
$original_draft = $_POST['original_draft'] ?? 'No';

if($save_type == "draft"){
    $prefix = "QD-".$_ENV['COMPANY_CODE'].date('y').'-';
    $draft_flag = "Yes";
} else {
    $prefix = "QT-".$_ENV['COMPANY_CODE'].date('y').'-';
    $draft_flag = "No";
}

$customer_name = $_POST['customer_name'] ?? null;
$customer_phone = $_POST['customer_phone'] ?? null;
$customer_email = $_POST['customer_email'] ?? null;
$customer_address = $_POST['customer_address'] ?? null;
$quotation_date = $_POST['quotation_date'] ?? null;
$items = json_encode($_POST['items']);
$subtotal = $_POST['subtotal'] ?? null;
$vat_total = $_POST['vat_total'] ?? null;
$grand_total = $_POST['grand_total'] ?? null;

$total_discount = $_POST['total_discount'] ?? null;
$total_discount_amount = $_POST['total_discount_amount'] ?? null;
$after_discount_amount = $_POST['after_discount_amount'] ?? null;
$storage_company_id = $_POST['storage_company_id'] ?? null;
$storage_company_name = $_POST['storage_company_name'] ?? null;
$storage_customer_emails = $_POST['storage_customer_emails'] ?? null;
$storage_username = $_POST['storage_username'] ?? null;
$storage_userid = $_POST['storage_userid'] ?? null;
$allItemSubtotal = $_POST['allItemSubtotal'] ?? null;

$reference_number  = $_POST['reference_number'] ?? null;
$itemNamesThroughPost = $_POST['items'];

$termsContentValue = $_POST['termsContentValue'] ?? null;
$attentionValue = $_POST['attentionValue'] ?? null;

/* ------------------ UPDATE EXISTING ------------------ */
if($action_type == "update" && $quotation_id != ""){
    $sql = "UPDATE quotations SET
        customer_name=?,
        quotation_date=?,
        customer_phone=?,
        customer_email=?,
        customer_address=?,
        items=?,
        subtotal=?,
        vat_total=?,
        grand_total=?,
        draft=?,
        reference_number=?,
        total_discount=?,
        total_discount_amount=?,
        after_discount_amount=?,
        user_id=?,
        user_name=?,
        company_id=?,
        company_name=?,
        allItemSubtotal=?,
        terms=?,
        attention=?
        WHERE id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param(
        "ssssssdddssdddisisdssi",
        $customer_name,
        $quotation_date,
        $customer_phone,
        $customer_email,
        $customer_address,
        $items,
        $subtotal,
        $vat_total,
        $grand_total,
        $draft_flag,
        $reference_number,
        $total_discount,
        $total_discount_amount,
        $after_discount_amount,
        $storage_userid,
        $storage_username,
        $storage_company_id,
        $storage_company_name,
        $allItemSubtotal,
        $termsContentValue,
        $attentionValue,
        $quotation_id
    );
    $stmt->execute();
     InsertToItemsTables($itemNamesThroughPost,$mysqli); 
    echo "Quotation updated successfully.";
}

/* ------------------ CREATE NEW ------------------ */
else {
    // generate new number
    $result = $mysqli->query("
        SELECT quotation_no 
        FROM quotations 
        WHERE quotation_no LIKE '$prefix%' 
        ORDER BY id DESC 
        LIMIT 1
    ");
    if ($row = $result->fetch_assoc()) {

        $last_no = $row['quotation_no'];  // Example: QT-AJ25-001
    
        // Split by "-"
        $parts = explode('-', $last_no);
    
        // Get last part (001)
        $last_number = end($parts);
    
        // Convert to integer and increment
        $num = intval($last_number) + 1;
    
    } else {
    
        $num = 1;
    
    }
    // $quotation_no = $prefix . str_pad($num,4,"0",STR_PAD_LEFT);

    // $sql = "INSERT INTO quotations
    //     (quotation_no, quotation_date, customer_name, customer_phone, 
    //     customer_email, customer_address, items, subtotal, vat_total, 
    //     grand_total, draft, reference_number,
    //     total_discount, total_discount_amount, after_discount_amount,
    //     user_id, user_name, company_id, company_name,allItemSubtotal,attention,terms)
    //     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?)";

    // $stmt = $mysqli->prepare($sql);
    // $stmt->bind_param(
    //     "sssssssddsssdddssdsdss",
    //     $quotation_no,
    //     $quotation_date,
    //     $customer_name,
    //     $customer_phone,
    //     $customer_email,
    //     $customer_address,
    //     $items,
    //     $subtotal,
    //     $vat_total,
    //     $grand_total,
    //     $draft_flag,
    //     $reference_number,
    //     $total_discount,
    //     $total_discount_amount,
    //     $after_discount_amount,
    //     $storage_userid,
    //     $storage_username,
    //     $storage_company_id,
    //     $storage_company_name,
    //     $allItemSubtotal,
    //     $attentionValue,
    //     $termsContentValue
        
    // );
    // $stmt->execute();
    try {

            $mysqli->begin_transaction();
        
            // Generate quotation number
            $stmt = $mysqli->prepare("CALL generate_quotation_no(?, ?, @quotation_no, @draft_flag)");
            $stmt->bind_param("ss", $save_type, $_ENV['COMPANY_CODE']);
            $stmt->execute();
            $stmt->close();
        
            $result = $mysqli->query("SELECT @quotation_no AS quotation_no, @draft_flag AS draft_flag");
            $row = $result->fetch_assoc();
        
            $quotation_no = $row['quotation_no'];
            $draft_flag   = $row['draft_flag'];
        
            $sql = "INSERT INTO quotations
            (quotation_no, quotation_date, customer_name, customer_phone, 
            customer_email, customer_address, items, subtotal, vat_total, 
            grand_total, draft, reference_number,
            total_discount, total_discount_amount, after_discount_amount,
            user_id, user_name, company_id, company_name,
            allItemSubtotal, attention, terms)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $mysqli->prepare($sql);
            
            $stmt->bind_param(
            "sssssssdddssdddisisdss",
            $quotation_no,
            $quotation_date,
            $customer_name,
            $customer_phone,
            $customer_email,
            $customer_address,
            $items,
            $subtotal,
            $vat_total,
            $grand_total,
            $draft_flag,
            $reference_number,
            $total_discount,
            $total_discount_amount,
            $after_discount_amount,
            $storage_userid,
            $storage_username,
            $storage_company_id,
            $storage_company_name,
            $allItemSubtotal,
            $attentionValue,
            $termsContentValue
            );
            
            $stmt->execute();
            $stmt->close();
        
            $mysqli->commit();
        
        } catch (Exception $e) {
        
            $mysqli->rollback();
            die("Error: " . $e->getMessage());
        
        }
    
      InsertToItemsTables($itemNamesThroughPost,$mysqli); 
    
    
    echo "New quotation created: " . $quotation_no;
}

function InsertToItemsTables($itemNamesPost,$mysqli)
{
        $itemsArray = $itemNamesPost;
        $itemNames = [];
        
        foreach ($itemsArray as $item) {
            $itemNames[] = $mysqli->real_escape_string($item['item_name']);
        }
        
        // Remove duplicates from input itself
        $itemNames = array_unique($itemNames);
        
        if (!empty($itemNames)) {
        
            $values = [];
            foreach ($itemNames as $name) {
                $values[] = "('$name')";
            }
        
            $sql = "INSERT IGNORE INTO item_master (item_name) VALUES " . implode(",", $values);
        
            $mysqli->query($sql);
        }
}

$stmt->close();
$mysqli->close();

?>
