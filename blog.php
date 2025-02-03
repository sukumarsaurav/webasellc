<?php
require_once 'config.php';

$sql = "SELECT b.*, c.name as category_name 
        FROM blog b 
        LEFT JOIN blog_categories c ON b.category_id = c.id 
        ORDER BY b.created_at DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<article class="blog-post fade-in" data-category="' . $row['category_name'] . '">';
        echo '<img src="' . $row['image_path'] . '" alt="' . $row['title'] . '" class="blog-image">';
        echo '<div class="blog-content">';
        echo '<div class="blog-meta">';
        echo '<span><i class="far fa-user"></i> ' . $row['author'] . '</span>';
        echo '<span><i class="far fa-calendar"></i> ' . date('M d, Y', strtotime($row['created_at'])) . '</span>';
        echo '<span><i class="far fa-folder"></i> ' . $row['category_name'] . '</span>';
        echo '</div>';
        echo '<h2 class="blog-title">' . $row['title'] . '</h2>';
        echo '<p class="blog-excerpt">' . substr($row['content'], 0, 150) . '...</p>';
        echo '<a href="blog-post.php?id=' . $row['id'] . '" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>';
        echo '</div>';
        echo '</article>';
    }
} else {
    echo '<div class="no-posts">No blog posts found.</div>';
}

mysqli_close($conn);
?> 