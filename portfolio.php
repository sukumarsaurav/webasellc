<?php
require_once 'config.php';

$sql = "SELECT * FROM portfolio";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='portfolio-item'>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p>" . $row['description'] . "</p>";
        echo "<img src='" . $row['image_path'] . "' alt='" . $row['title'] . "'>";
        echo "</div>";
    }
} else {
    echo "No portfolio items found.";
}

mysqli_close($conn);
?> 