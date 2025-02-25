<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Required fields
    $firstName = $_POST['firstName'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    
    // Optional fields - with default empty values
    $lastName = !empty($_POST['lastName']) ? $_POST['lastName'] : 'Not provided';
    $address = !empty($_POST['address']) ? $_POST['address'] : 'Not provided';
    $dob = !empty($_POST['dob']) ? $_POST['dob'] : 'Not provided';
    $occupation = !empty($_POST['occupation']) ? $_POST['occupation'] : 'Not provided';
    $services = isset($_POST['services']) ? implode(", ", $_POST['services']) : '';
    $comments = $_POST['comments'] ?? '';

    // Validate required fields
    if (empty($firstName) || empty($phone) || empty($email)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
        exit;
    }

    // Prepare email content
    $to = "info@ssinfotechweb.com";
    $subject = "New Customer Query";
    
    $message = "
    <html>
    <head>
        <title>New Customer Query</title>
        <style>
            table { border-collapse: collapse; width: 100%; }
            th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
            th { background-color: #f2f2f2; }
        </style>
    </head>
    <body>
        <h2>New Customer Query Details</h2>
        <table>
            <tr><th>Field</th><th>Information</th></tr>
            <tr><td><strong>First Name:</strong></td><td>$firstName</td></tr>
            <tr><td><strong>Last Name:</strong></td><td>$lastName</td></tr>
            <tr><td><strong>Phone:</strong></td><td>$phone</td></tr>
            <tr><td><strong>Email:</strong></td><td>$email</td></tr>
            <tr><td><strong>Address:</strong></td><td>$address</td></tr>
            <tr><td><strong>Date of Birth:</strong></td><td>$dob</td></tr>
            <tr><td><strong>Occupation:</strong></td><td>$occupation</td></tr>
            <tr><td><strong>Services Required:</strong></td><td>$services</td></tr>
            <tr><td><strong>Comments:</strong></td><td>$comments</td></tr>
        </table>
    </body>
    </html>
    ";

    // Email headers
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: $email\r\n";
    
    // Send email
    $mailSent = mail($to, $subject, $message, $headers);

    // Return response
    header('Content-Type: application/json');
    if ($mailSent) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?> 