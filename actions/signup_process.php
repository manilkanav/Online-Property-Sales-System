<?php
session_start();

// Include the database connection file
require '../database/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $contact = $_POST['contact'];

    // Check if the username already exists
    $query = "SELECT COUNT(*) FROM users WHERE name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Username already exists, display an error message
        $_SESSION['signup_error'] = 'Username already taken.';
        header('Location: signup.php');
        exit();
    }

    // Handle profile picture upload
    $profilePicName = '';
    if (isset($_FILES['profilepic']) && $_FILES['profilepic']['error'] === UPLOAD_ERR_OK) {
        $profilePicTmpName = $_FILES['profilepic']['tmp_name'];
        $profilePicExtension = pathinfo($_FILES['profilepic']['name'], PATHINFO_EXTENSION);
        $profilePicName = uniqid() . '.' . $profilePicExtension;
        $profilePicPath = '../images/profile/' . $profilePicName;

        // Move the uploaded file to the desired location
        move_uploaded_file($profilePicTmpName, $profilePicPath);
    } else {
        // No profile picture uploaded, assign default profile picture
        $profilePicName = 'profile.png';
    }

    // Insert the user's data into the database
    $query = "INSERT INTO users (name, first_name, last_name, email, password, contact_number, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssss', $username, $firstname, $lastname, $email, $password, $contact, $profilePicName);
    $stmt->execute();
    $stmt->close();

    // Successful sign up
    $_SESSION['signup_success'] = 'Sign up successful! Please log in.';
    header('Location: ../login.php');
    exit();
}

// Close the database connection
$conn->close();
?>
