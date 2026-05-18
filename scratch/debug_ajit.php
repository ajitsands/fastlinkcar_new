<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=aacar_local', 'root', 'S@nds1@b');
$sql = "SELECT ids, company_id, customer_code, payment_method, cheque_status, cheque_date, trans_date, credit 
        FROM tbl_customer_ledger 
        WHERE customer_code IN ('C0001', 'C0003') 
        AND (cheque_date < '2026-03-01' OR trans_date < '2026-03-01')";
$stmt = $pdo->query($sql);
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
