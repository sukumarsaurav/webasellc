<?php
require_once 'config.php';

$sql = "SELECT * FROM blog ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='blog-post'>";
        echo "<h3>" . $row['title'] . "</h3>";
        echo "<p>" . $row['content'] . "</p>";
        echo "<p><em>By " . $row['author'] . " on " . $row['created_at'] . "</em></p>";
        echo "</div>";
    }
} else {
    echo "No blog posts found.";
}

mysqli_close($conn);
?> 