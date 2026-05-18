<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=aacar_local', 'root', 'S@nds1@b');
print_r($pdo->query("SELECT DISTINCT payment_method FROM tbl_customer_ledger")->fetchAll(PDO::FETCH_COLUMN));
