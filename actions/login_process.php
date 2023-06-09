<?php
session_start();

// Include the database connection file
require '../database/db_connect.php';

// Simulating login process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement
    $query = "SELECT * FROM users WHERE name = :username AND password = :password";
    $stmt = $pdo->prepare($query);

    // Bind the parameters
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    // Execute the query
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch();

    // Check if a row is returned
    if ($result) {
        // Successful login
        $_SESSION['loggedin'] = true;
        $_SESSIONS['name'] = $result['name'];
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['profile_pic'] = $result['profile_pic'];
        header('Location: ../index.php'); // Redirect to the user's profile page
        exit();
    } else {
        // Invalid login credentials
        $_SESSION['loggedin'] = false;
        $error = 'Invalid username or password.';
        // You can redirect the user back to the login page with an error message, or display the error on the same page
        // For simplicity, let's display the error message on the login page
        echo $error;
    }
}

// Close the database connection
$pdo = null;
?>
