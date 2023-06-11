<!DOCTYPE html>
<html>
<head>
    <title>Moderator Login</title>
    <!-- Include your CSS file here -->
    <link rel="stylesheet" href="../css/moderator_styles.css">
</head>
<body>
    <div class="container">
        <h2>Moderator Login</h2>
        <form action="../actions/moderator_login_process.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
