<?php
require_once 'config.php';

if ($conn) {
    $tables = ['blog', 'blog_categories'];
    
    foreach ($tables as $table) {
        $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
        if (mysqli_num_rows($result) > 0) {
            echo "Table '$table' exists<br>";
            
            // Check if table has data
            $count = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM $table"))[0];
            echo "Records in $table: $count<br>";
        } else {
            echo "Table '$table' does not exist<br>";
        }
    }
} else {
    echo "Database connection failed";
}

mysqli_close($conn);
?> 