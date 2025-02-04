<?php
require_once 'config.php';

// Initialize response array
$response = array(
    'status' => 'error',
    'message' => ''
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Check connection
        if (!$conn) {
            throw new Exception("Database connection failed: " . mysqli_connect_error());
        }

        // Validate required fields
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['message'])) {
            throw new Exception("All fields are required");
        }

        // Prepare statement
        $stmt = $conn->prepare("INSERT INTO contact_requests (name, email, phone, message) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param("ssss", 
            $_POST['name'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['message']
        );

        // Execute the statement
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $response['status'] = 'success';
        $response['message'] = 'Thank you for contacting us!';
        
        // Log successful submission (optional)
        error_log("New contact form submission from: " . $_POST['email']);
        
        $stmt->close();
    } catch (Exception $e) {
        $response['message'] = "Error: " . $e->getMessage();
        error_log("Contact form error: " . $e->getMessage());
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

mysqli_close($conn);
?>