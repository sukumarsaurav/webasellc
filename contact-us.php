<?php
require_once 'config.php';

// Initialize response array
$response = array(
    'status' => 'error',
    'message' => ''
);

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = filter_var(trim($_POST['phone']), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        $response['message'] = 'All fields are required.';
    } 
    // Validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Please enter a valid email address.';
    }
    // Validate phone number (basic validation)
    elseif (!preg_match('/^[0-9+\-\s()]{8,20}$/', $phone)) {
        $response['message'] = 'Please enter a valid phone number.';
    }
    else {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO contact_requests (name, email, phone, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $message);

        // Execute the statement
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Thank you for contacting us. We will get back to you soon!';
            
            // Optional: Send email notification
            $to = "info@webasellc.com";
            $subject = "New Contact Form Submission";
            $email_message = "Name: $name\n";
            $email_message .= "Email: $email\n";
            $email_message .= "Phone: $phone\n\n";
            $email_message .= "Message:\n$message";
            
            $headers = "From: $email";
            
            mail($to, $subject, $email_message, $headers);
        } else {
            $response['message'] = 'Sorry, there was an error submitting your request. Please try again later.';
        }

        $stmt->close();
    }
    
    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

mysqli_close($conn);
?> 