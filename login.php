<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <!-- Your CSS and other head elements -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<?php
// Include the header
include 'includes/header.php';
?>

<!-- Login form -->
<section  class ="section">
    <h2 class = "title">Welcome back</h2>
    <form action="actions/login_process.php" method="post">
        <input type="text" name="username" placeholder="Username" required class = "username">
        <input type="password" name="password" placeholder="Password" required class ="password">
        <button type="submit">Login</button class = "submitbtn">
    </form>
</section>

<?php

// Check if an error message is present in the URL
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    // Display the error message
    echo '<p class="error">' . htmlspecialchars($error) . '</p>';
}
?>

<?php
// Include the footer
include 'includes/footer.php';
?>

</body>
</html>