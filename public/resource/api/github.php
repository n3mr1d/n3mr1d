<?php
header('Content-Type: application/json');

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// GitHub API endpoint
$url = 'https://api.github.com/graphql';

// Personal access token
$token = GITHUB_TOKEN;

// Prepare headers
$headers = [
    'Authorization: bearer ' . $token,
    'Content-Type: application/json',
    'User-Agent: PHP'
];

// Use file_get_contents as fallback when cURL is not available
$options = [
    'http' => [
        'header' => implode("\r\n", $headers),
        'method' => 'POST',
        'content' => json_encode($data),
        'ignore_errors' => true
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === false) {
    echo json_encode(['error' => 'Failed to fetch data from GitHub API']);
    exit;
}

// Output the response
echo $response;
?>
