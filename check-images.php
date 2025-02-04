<?php
require_once 'config.php';

if ($conn) {
    $query = "SELECT id, title, image_path FROM blog";
    $result = mysqli_query($conn, $query);
    
    echo "<h2>Image Path Check</h2>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<hr>";
        echo "Blog ID: " . $row['id'] . "<br>";
        echo "Title: " . $row['title'] . "<br>";
        echo "Image Path in DB: " . $row['image_path'] . "<br>";
        
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($row['image_path'], '/');
        echo "Full System Path: " . $fullPath . "<br>";
        
        if (file_exists($fullPath)) {
            echo "Status: ✅ Image file exists<br>";
        } else {
            echo "Status: ❌ Image file not found<br>";
            echo "Readable: " . (is_readable($fullPath) ? 'Yes' : 'No') . "<br>";
            echo "Directory exists: " . (is_dir(dirname($fullPath)) ? 'Yes' : 'No') . "<br>";
        }
    }
} else {
    echo "Database connection failed";
}

// Show directory structure
echo "<h2>Directory Structure</h2>";
echo "<pre>";
function listDir($dir) {
    $files = scandir($dir);
    foreach($files as $file) {
        if ($file != "." && $file != "..") {
            if (is_dir($dir . '/' . $file)) {
                echo "📁 " . $dir . '/' . $file . "\n";
                listDir($dir . '/' . $file);
            } else {
                echo "📄 " . $dir . '/' . $file . "\n";
            }
        }
    }
}
listDir($_SERVER['DOCUMENT_ROOT'] . '/src/images/blog');
echo "</pre>";

mysqli_close($conn);
?> 