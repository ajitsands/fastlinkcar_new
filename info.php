<?php
echo "PHP Version: " . phpversion() . "<br>";
echo "PDO Loaded: " . (class_exists('PDO') ? 'Yes' : 'No') . "<br>";
echo "PDO Drivers: " . (class_exists('PDO') ? implode(', ', PDO::getAvailableDrivers()) : 'N/A') . "<br>";
echo "Session Save Path: " . session_save_path() . "<br>";
echo "Session Save Path Writable: " . (is_writable(session_save_path()) ? 'Yes' : 'No') . "<br>";
echo "Temp Dir: " . sys_get_temp_dir() . "<br>";
?>
