<?php
// Koneksi ke MariaDB dengan PDO

require_once __DIR__ ."/../public/config.php";

try {
    $conn = new PDO("mysql:host=".DBHOST.";port=".DBPORT.";dbname=".DBNAME ,DBUSER, DBPASS);
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
