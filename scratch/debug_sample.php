<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=aacar_local', 'root', 'S@nds1@b');
$sql = "SELECT customer_id FROM customer_details WHERE customer_name LIKE '%Sample%'";
$stmt = $pdo->query($sql);
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($customers as $c) {
    $code = $c['customer_id'];
    echo "Customer: $code\n";
    $sql2 = "SELECT ids, payment_method, cheque_status, cheque_date, trans_date, credit 
             FROM tbl_customer_ledger 
             WHERE customer_code = '$code' 
             AND (
                (payment_method = 'Cheque' AND cheque_date < '2026-03-01') 
                OR (payment_method != 'Cheque' AND trans_date < '2026-03-01')
             )";
    $stmt2 = $pdo->query($sql2);
    print_r($stmt2->fetchAll(PDO::FETCH_ASSOC));
}
