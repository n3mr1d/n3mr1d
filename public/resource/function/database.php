<?php
// Define database constants
define("DB_HOST", DBHOST);
define("DB_NAME", DBNAME);
define("DB_PASS", DBPASS);
define("DB_PORT", DBPORT);
define("DB_USER", DBUSER);

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $sql = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Create tables
$queries = [
    "users" => "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB",
  "skill" => "CREATE TABLE IF NOT EXISTS skill (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(20) NOT NULL UNIQUE,
        persentase INT NOT NULL,
        icon VARCHAR(50) NOT NULL DEFAULT 'fa-arrows-to-dot',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

    ) ENGINE=InnoDB",
    "crypto" => "CREATE TABLE IF NOT EXISTS crypto (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(20) NOT NULL UNIQUE,
        address LONGTEXT NOT NULL,
        icon VARCHAR(50) NOT NULL DEFAULT 'fa-coins',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

    ) ENGINE=InnoDB",

    "certif" => "CREATE TABLE IF NOT EXISTS certif (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(50) NOT NULL,
        imglink VARCHAR(255) NOT NULL,
        source VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

    ) ENGINE=InnoDB",
"pro" => "CREATE TABLE IF NOT EXISTS pro (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(80) NOT NULL,
        repo VARCHAR(255) DEFAULT NULL,
        demo VARCHAR(255) DEFAULT NULL,
        imglink VARCHAR(255) DEFAULT NULL,
        deskrip TEXT DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB",
    
    "language" => "CREATE TABLE IF NOT EXISTS language (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        project_id INT NOT NULL,
        color VARCHAR(7) NOT NULL DEFAULT '#e74c3c',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (project_id) REFERENCES pro(id) ON DELETE CASCADE
    ) ENGINE=InnoDB",
    
    "framework" => "CREATE TABLE IF NOT EXISTS framework (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        project_id INT NOT NULL,
        color VARCHAR(7) NOT NULL DEFAULT '#f39c12 ',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (project_id) REFERENCES pro(id) ON DELETE CASCADE
    ) ENGINE=InnoDB",
    
    "data" => "CREATE TABLE IF NOT EXISTS data (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        project_id INT NOT NULL,
        color VARCHAR(7) NOT NULL DEFAULT '#3498db',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (project_id) REFERENCES pro(id) ON DELETE CASCADE
    ) ENGINE=InnoDB"
];

foreach ($queries as $table => $query) {
    try {
        $sql->exec($query);
    } catch (PDOException $e) {
        echo "Error creating table $table: " . $e->getMessage() . "\n";
    }
}

