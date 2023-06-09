<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <!-- Your CSS and other head elements -->
</head>
<body>

<?php
// Include the header
include 'includes/header.php';
?>

<!-- Login form -->
<section>
    <h2>Login</h2>
    <form action="actions/login_process.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</section>

<?php
// Include the footer
include 'includes/footer.php';
?>

</body>
</html>