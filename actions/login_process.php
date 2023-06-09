<?php
session_start();
// Include the database connection file
require '../database/db_connect.php';

// Simulating login process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Execute the query
    $query = "SELECT * FROM users WHERE name = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if a row is returned
    if (mysqli_num_rows($result) === 1) {
        // Successful login
        $row = mysqli_fetch_assoc($result);
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['profile_pic'] = $row['profile_pic'];
        header('Location: ../index.php'); // Redirect to the user's profile page
        exit();
    }
}

// Invalid login credentials
$_SESSION['loggedin'] = false;
$error = 'Invalid username or password.';
header('Location: ../login.php?error=' . urlencode($error));

// Close the database connection
mysqli_close($conn);
?>
