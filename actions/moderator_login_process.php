<?php
session_start();

require '../database/db_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the username and password are provided
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Get the entered username and password
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare the SQL statement to fetch the moderator's information
        $query = "SELECT * FROM moderator WHERE name = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $admin = mysqli_fetch_assoc($result);
            // Verify the password
            if ($password === $admin['password']) {
                // Store moderator data in session variables
                $_SESSION['moderator_id'] = $admin['id'];
                $_SESSION['moderator_username'] = $admin['name'];

                // Redirect to the moderator dashboard upon successful login
                header('Location: ../moderator/moderator_dashboard.php');
                exit();
            } else {
                // Invalid password, display an error message
                echo 'Invalid password.';
            }
        } else {
            // Invalid username, display an error message
            echo 'Invalid username.';
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Username or password is not provided, display an error message
        echo 'Please enter both username and password.';
    }
} else {
    // Redirect back to the login page if the form is not submitted
    header('Location: moderator/moderator_login.php');
    exit();
}
