<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the admin login page if not logged in
    header('Location: admin_login.php');
    exit();
}

// Include the database connection file
require '../database/db_connect.php';

// Initialize variables
$name = $email = $password = $first_name = $last_name = $contact_number = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['contact_number'])) {
        $error = 'Please enter all the required fields.';
    } else {
        // Sanitize form inputs
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);

        // Check if the email is already registered
        $emailQuery = "SELECT * FROM moderator WHERE email = '$email'";
        $emailResult = mysqli_query($conn, $emailQuery);
        if (mysqli_num_rows($emailResult) > 0) {
            $error = 'Email is already registered.';
        } else {
            // Insert new moderator into the database
            $insertQuery = "INSERT INTO moderator (name, email, password, first_name, last_name, contact_number) VALUES ('$name', '$email', '$password', '$first_name', '$last_name', '$contact_number')";
            mysqli_query($conn, $insertQuery);
            
            // Redirect back to the admin dashboard
            header('Location: admin_dashboard.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Moderator</title>
    <link rel="stylesheet" href="../css/admin_styles.css">
</head>
<body>
    <header class="nav">
        <div class="container">
            <h1>Welcome to the Admin Dashboard</h1>
            <a href="admin_logout.php" class="logout-btn">Logout</a>
        </div>
    </header>

    <div class="container">
        <h2>Add Moderator</h2>

        <form method="POST" class="moderator-form">
            <div class="form-group">
                <label for="name">Username:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" value="<?php echo $password; ?>">
            </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $first_name; ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $last_name; ?>">
            </div>
            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="text" id="contact_number" name="contact_number" class="form-control" value="<?php echo $contact_number; ?>">
            </div>

            <div class="form-group">
                <input type="submit" value="Add Moderator" class="submit-btn">
            </div>

            <div class="error"><?php echo $error; ?></div>
        </form>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
