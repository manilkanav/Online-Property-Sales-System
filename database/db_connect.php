<?php
// Include the configuration file
require_once 'config.php';

// Establish a database connection
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Other database-related code...
