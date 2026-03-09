<?php
$mysqli = new mysqli("localhost", "sandsl23_quotation_user", "S@nds1@b", "sandsl23_quotation");

$id = $_GET['id'];

$sql = "SELECT * FROM quotations WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();
$row['items'] = json_decode($row['items'], true);
$row['quotation_date'] = date('Y-m-d', strtotime($row['quotation_date']));


echo json_encode($row);

$stmt->close();
$mysqli->close();
?>
