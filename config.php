<?php
$db_host = '193.203.184.121';
$db_user = 'u911550082_webase';
$db_pass = 'z:qHAizSy4#';
$db_name = 'u911550082_webase';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>