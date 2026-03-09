<?php
session_start();
include "db.php";
$_SESSION['user_id'] =1;
$user_id = $_SESSION['user_id'];

$sql = "
SELECT 
    sa.action_name,
    COALESCE(us.shortcut_key, sa.default_key) AS shortcut_key
FROM shortcut_actions sa
LEFT JOIN user_shortcuts us
    ON sa.action_name = us.action_name
    AND us.user_id = $user_id
";

$result = $conn->query($sql);

$shortcuts = [];

while ($row = $result->fetch_assoc()) {
    $shortcuts[$row['action_name']] = $row['shortcut_key'];
}

echo json_encode($shortcuts);
?>
