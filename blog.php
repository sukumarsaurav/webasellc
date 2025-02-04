<?php
require_once 'config.php';

// Initialize error message variable
$error_message = '';

try {
    // Check if connection is successful
    if (!$conn) {
        throw new Exception("Database connection failed: " . mysqli_connect_error());
    }

    // Get category filter if provided
    $category = isset($_GET['category']) ? $_GET['category'] : 'all';
    
    // Build SQL query based on category
    $sql = "SELECT b.*, c.name as category_name, c.slug as category_slug 
            FROM blog b 
            LEFT JOIN blog_categories c ON b.category_id = c.id";
    
    if ($category !== 'all') {
        $sql .= " WHERE c.slug = '" . mysqli_real_escape_string($conn, $category) . "'";
    }
    
    $sql .= " ORDER BY b.created_at DESC";
    
    // Execute query and check for errors
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        throw new Exception("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Debug output (remove in production)
            // echo "<!-- Debug: Processing blog post ID: " . $row['id'] . " -->\n";
            
            // Add this near the top of your try block for debugging
            if (isset($_GET['debug'])) {
                echo "<!-- Debug Information -->\n";
                echo "<!-- Document Root: " . $_SERVER['DOCUMENT_ROOT'] . " -->\n";
                echo "<!-- Current Directory: " . getcwd() . " -->\n";
            }

            // Update the image path checking logic
            if (!empty($row['image_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($row['image_path'], '/'))) {
                $imagePath = $row['image_path'];
            } else {
                $imagePath = 'src/images/blog/default-blog.jpg';
            }

            // Add this inside your while loop for debugging image paths
            if (isset($_GET['debug'])) {
                echo "<!-- Image Path: " . $row['image_path'] . " -->\n";
                echo "<!-- Full Path: " . $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($row['image_path'], '/') . " -->\n";
                echo "<!-- File Exists: " . (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($row['image_path'], '/')) ? 'Yes' : 'No') . " -->\n";
            }

            echo '<article class="blog-post" data-category="' . htmlspecialchars($row['category_slug']) . '">';
            echo '<div class="blog-image-container">';
            echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row['title']) . '" class="blog-image" onerror="this.src=\'src/images/blog/default-blog.jpg\'">';
            echo '</div>';
            echo '<div class="blog-content">';
            echo '<div class="blog-meta">';
            echo '<span><i class="far fa-user"></i> ' . htmlspecialchars($row['author']) . '</span>';
            echo '<span><i class="far fa-calendar"></i> ' . date('M d, Y', strtotime($row['created_at'])) . '</span>';
            echo '<span><i class="far fa-folder"></i> ' . htmlspecialchars($row['category_name']) . '</span>';
            echo '</div>';
            echo '<h2 class="blog-title">' . htmlspecialchars($row['title']) . '</h2>';
            echo '<p class="blog-excerpt">' . htmlspecialchars(substr($row['content'], 0, 150)) . '...</p>';
            echo '<a href="blog-details.php?slug=' . htmlspecialchars($row['slug']) . '" class="read-more">Read More <i class="fas fa-arrow-right"></i></a>';
            echo '</div>';
            echo '</article>';
        }
    } else {
        echo '<div class="no-posts">No blog posts found for this category.</div>';
    }

} catch (Exception $e) {
    // Log the error (in a production environment, use proper logging)
    error_log("Blog Error: " . $e->getMessage());
    
    // Display user-friendly error message
    $error_message = "We're experiencing technical difficulties displaying the blog posts. Please try again later.";
    
    // For debugging (remove or comment out in production)
    if (isset($_GET['debug']) && $_GET['debug'] == 1) {
        $error_message .= "<br>Debug: " . $e->getMessage();
    }
    
    echo '<div class="error-message">';
    echo '<i class="fas fa-exclamation-circle"></i>';
    echo '<p>' . $error_message . '</p>';
    echo '</div>';
}

// Close the connection
if (isset($conn) && $conn) {
    mysqli_close($conn);
}
?>

<!-- Add this CSS to your blog.css or style.css file -->
<style>
.error-message {
    background-color: #fff3f3;
    border: 1px solid #ffa7a7;
    border-radius: 4px;
    padding: 20px;
    margin: 20px 0;
    text-align: center;
    color: #d63031;
}

.error-message i {
    font-size: 24px;
    margin-bottom: 10px;
}

.error-message p {
    margin: 0;
    font-size: 16px;
}

.blog-image-container {
    width: 100%;
    height: 200px;
    overflow: hidden;
    border-radius: 8px 8px 0 0;
}

.blog-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style> 