<?php
require_once 'config.php';

if ($conn) {
    echo "Database connection successful!<br>";
    echo "Server info: " . mysqli_get_server_info($conn);
} else {
    echo "Connection failed: " . mysqli_connect_error();
}
?> 