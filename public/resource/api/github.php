<?php
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// GitHub API endpoint
$url = 'https://api.github.com/graphql';

// Personal access token
$token = getenv('GITHUB_TOKEN');

// Prepare headers
$headers = [
    'Authorization: bearer ' . $token,
    'Content-Type: application/json',
    'User-Agent: PHP'
];

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute the request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo json_encode(['error' => curl_error($ch)]);
    exit;
}

// Close cURL
curl_close($ch);

// Output the response
echo $response;
?>
