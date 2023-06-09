<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // User is logged in, perform logout actions

    // Clear all session variables
    session_unset();

    // Destroy the session
    session_destroy();
}

// Redirect the user to the login page
header('Location: ../index.php');
exit();
?>
