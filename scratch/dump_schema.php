<?php
require 'e:/aacar/pdf/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable('e:/aacar/envfiles');
$dotenv->load();
$mysqli = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);

$tables = [];
$res = $mysqli->query("SHOW TABLES LIKE '%vehicle%'");
while($row = $res->fetch_array()) {
    $tables[] = $row[0];
}
$res = $mysqli->query("SHOW TABLES LIKE 'vehicles'");
while($row = $res->fetch_array()) {
    $tables[] = $row[0];
}

$output = "";
foreach($tables as $table) {
    $output .= "Table: $table\n";
    $res = $mysqli->query("DESCRIBE `$table`");
    while($row = $res->fetch_assoc()) {
        $output .= "  " . $row['Field'] . " - " . $row['Type'] . "\n";
    }
    $output .= "\n";
}
file_put_contents('e:/aacar/scratch/db_schema.txt', $output);
echo "Done";
