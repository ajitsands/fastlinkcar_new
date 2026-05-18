<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=aacar_local', 'root', 'S@nds1@b');
$sql = "SELECT customer_id, customer_name FROM customer_details WHERE customer_name LIKE '%Ajit%'";
$stmt = $pdo->query($sql);
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
