<?php
header('Content-Type: application/json');

try {
    // Get the raw POST data
    $data = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON input');
    }

    // GitHub API endpoint
    $url = 'https://api.github.com/graphql';

    // Personal access token from environment variable
    $token = getenv('GITHUB_TOKEN');
    if (!$token) {
        throw new Exception('GitHub token not configured');
    }

    // Initialize cURL if available
    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: bearer ' . $token,
            'Content-Type: application/json',
            'User-Agent: PHP'
        ]);
        
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('cURL error: ' . curl_error($ch));
        }
        curl_close($ch);
    } else {
        // Fallback to file_get_contents
        $headers = [
            'Authorization: bearer ' . $token,
            'Content-Type: application/json',
            'User-Agent: PHP'
        ];

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
            throw new Exception('Failed to fetch data from GitHub API');
        }
    }

    // Output the response
    echo $response;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
