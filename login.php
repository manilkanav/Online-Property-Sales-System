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

<section class = "section">
    <h2 class = "title">Welocome Back</h2>
    <form action="actions/login_process.php" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>
        </div>
        <button class="loginbtn" type="submit">Login</button>
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

include 'includes/footer.php';
?>

</body>
</html>