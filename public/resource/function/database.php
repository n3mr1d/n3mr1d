<?php
// connection database
try {
    $db = new PDO("mysql:host=" . DBHOST . ";port=" . DBPORT .";dbname=" . DBNAME, DBUSER, DBPASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("FATAL ERROR: " . $e->getMessage());
}

// create database function
function createdb() {
    global $db;
    $sql1 = "CREATE TABLE IF NOT EXISTS project(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    deskrip VARCHAR(255) NOT NULL,
    github VARCHAR(255) NOT NULL,
    demo VARCHAR(255) NOT NULL,
    statuspo ENUM('complated','ongoing') NOT NULL default 'ongoing',
    uploadat TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
    $crypto = "CREATE TABLE IF NOT EXISTS cry(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    addre VARCHAR(255) NOT NULL,
    icon VARCHAR(255) NOT NULL DEFAULT 'fa-coins',
    creatat TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
    $sql2 = "CREATE TABLE IF NOT EXISTS image(
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    path_image VARCHAR(255),
    createat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(project_id) REFERENCES project(id))";

    $sql3 = "CREATE TABLE IF NOT EXISTS tag(
    id INT AUTO_INCREMENT PRIMARY KEY,
    tag VARCHAR(50) NOT NULL,
    color VARCHAR(10),
    project_id INT NOT NULL,
    createat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(project_id) REFERENCES project(id))";
    $setting= "CREATE TABLE IF NOT EXISTS settings(
    id INT AUTO_INCREMENT PRIMARY KEY,
    value VARCHAR(50),
    settings VARCHAR(255)
    )";
    $certification = "CREATE TABLE IF NOT EXISTS certification(
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    path_image VARCHAR(255) NOT NULL,
    source VARCHAR(255) NOT NULL,
    createat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $role = "CREATE TABLE IF NOT EXISTS roles
    (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    role VARCHAR(255),
    creat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $user =  "CREATE TABLE IF NOT EXISTS admins(
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) unique,
    password VARCHAR(255),
    creat TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
    $skill = "CREATE TABLE IF NOT EXISTS skill(
    id INT AUTO_INCREMENT PRIMARY KEY,
    skill VARCHAR(255),
    percentage INT NOT NULL,
    svg_name VARCHAR(255),
    svg_content TEXT NOT NULL,
    creat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    try {
        $db->exec($sql1);
        $db->exec($sql2);
        $db->exec($sql3);
        $db->exec($setting);
        $db->exec($role);
        $db->exec($user);
        $db->exec($crypto);
        $db->exec($certification);
        $db->exec($skill);
    } catch(PDOException $e) {
        die("Database creation error: " . $e->getMessage());
    }
}
createdb();

// function cron untuk menghapus file apabila sudah tidak ada

function cron() {
    global $db;
    $uploadsDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadsDir)) {
        // Folder uploads tidak ada, tidak perlu melakukan apa-apa
        return;
    }

    // Ambil semua path_image dari tabel image dan certification
    $dbFiles = [];

    // Ambil path_image dari tabel image
    $stmt1 = $db->query("SELECT path_image FROM image");
    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($row['path_image'])) {
            $dbFiles[] = basename($row['path_image']);
        }
    }

    // Ambil path_image dari tabel certification
    $stmt2 = $db->query("SELECT path_image FROM certification");
    while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($row['path_image'])) {
            $dbFiles[] = basename($row['path_image']);
        }
    }

    // Scan semua file di folder uploads
    $files = scandir($uploadsDir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        // Hanya hapus file yang tidak ada di database
        if (!in_array($file, $dbFiles)) {
            $filePath = $uploadsDir . $file;
            if (is_file($filePath)) {
                @unlink($filePath);
            }
        }
    }
}
cron();