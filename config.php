<?php
$db_host = 'localhost';
$db_user = 'u462549710_admin';
$db_pass = '!Apnt^&d5';
$db_name = 'u462549710_ssinfotechweb';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>