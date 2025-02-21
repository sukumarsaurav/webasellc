<?php
header('Content-Type: application/json');

function checkBacklinks($domain) {
    // Initialize cURL session
    $ch = curl_init();
    
    // Set Moz API credentials (you'll need to sign up for Moz API)
    $accessID = 'your-access-id';
    $secretKey = 'your-secret-key';
    
    // Set API endpoint
    $endpoint = "https://lsapi.seomoz.com/v2/links";
    $timestamp = time();
    
    // Set request options
    curl_setopt_array($ch, [
        CURLOPT_URL => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Basic ' . base64_encode("$accessID:$secretKey"),
            'Content-Type: application/json'
        ],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'target' => $domain,
            'limit' => 50
        ])
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Handle request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $domain = $data['domain'] ?? '';
    
    if ($domain) {
        $backlinkData = checkBacklinks($domain);
        echo json_encode([
            'status' => 'success',
            'data' => $backlinkData
        ]);
    } else {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Domain is required'
        ]);
    }
}
?> 