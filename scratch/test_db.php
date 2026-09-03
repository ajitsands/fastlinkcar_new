<?php
$pdo = new PDO('mysql:host=localhost;dbname=aacar_local', 'root', 'S@nds1@b');
foreach ($pdo->query('DESCRIBE tbl_vehicle_rentout_contracts') as $row) {
    echo $row['Field'] . "\n";
}
