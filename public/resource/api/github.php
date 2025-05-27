<?php
// API endpoint untuk mengambil data GitHub menggunakan GraphQL

header('Content-Type: application/json');

// Ambil token dari environment variable
$github_token = getenv('GITHUB_TOKEN');

// Ambil body request (GraphQL query dari client)
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Validasi query
if (!isset($data['query'])) {
    echo json_encode(['error' => 'No GraphQL query provided']);
    exit;
}

$query = $data['query'];

// Siapkan request ke GitHub GraphQL API
$ch = curl_init('https://api.github.com/graphql');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['query' => $query]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $github_token,
    'Content-Type: application/json',
    'User-Agent: PHP-cURL' // User-Agent wajib untuk GitHub API
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => curl_error($ch)]);
    curl_close($ch);
    exit;
}

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    echo json_encode(['error' => 'GitHub API returned HTTP ' . $http_code, 'response' => $response]);
    exit;
}

// Output response dari GitHub langsung ke client
echo $response;

