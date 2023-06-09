<?php
// Include the configuration file
require_once 'config.php';

// Establish a database connection
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the database connection
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

?>
