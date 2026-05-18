<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=aacar_local', 'root', 'S@nds1@b');
$res = $pdo->exec("UPDATE tbl_customer_ledger SET company_id = 1 WHERE company_id = 0");
echo "Updated $res rows.\n";
