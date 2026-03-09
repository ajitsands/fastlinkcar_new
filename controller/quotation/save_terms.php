<?php
session_start();
$mysqli = new mysqli("localhost", "sandsl23_quotation_user", "S@nds1@b", "sandsl23_quotation");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
$company_id = $_SESSION['COMPANY_ID'];
$user_id    = $_SESSION['USER_IDS'];
$user_type  = $_SESSION['USER_TYPE'];


$terms_condition = $_POST['terms_condition'];
$t_c_name = $_POST['t_c_name'];
//$stmt = $mysqli->prepare("update tbl_terms_and_condition set terms_condition = ?");
$stmt = $mysqli->prepare("insert into tbl_terms_and_condition(terms_condition,t_c_name,company_id,user_id) values (?,?,?,?)");
$stmt->bind_param("ssdd", $terms_condition,$t_c_name,$company_id,$user_id);
$stmt->execute();

echo "success";
?>