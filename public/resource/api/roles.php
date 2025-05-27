<?php
// Koneksi ke MariaDB dengan PDO
$host = "localhost";
$user = "root";
$pass = "180406";
$dbname = "porto";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query data

    $sql = "SELECT role FROM roles";
    
    // Fetch roles data
    $stmt = $conn->query($sql);
    $rolesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

    $response = [
        "roles" => $rolesData,
    ];

    // Set header and output JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    
} catch(PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    $conn = null; // Tutup koneksi
}
?>
