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

// Function to delete a moderator
function deleteModerator($moderatorId) {
    global $conn;

    // Prepare the SQL statement to delete the moderator by ID
    $deleteQuery = "DELETE FROM moderator WHERE id = ?";
    $stmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $moderatorId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Handle moderator deletion
if (isset($_GET['delete'])) {
    $moderatorId = $_GET['delete'];
    deleteModerator($moderatorId);
    // Redirect back to the admin dashboard
    header('Location: admin_dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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
        <h2>Moderators</h2>
        <table class="moderator-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve the list of moderators from the database
                $moderatorQuery = "SELECT * FROM moderator";
                $moderatorResult = mysqli_query($conn, $moderatorQuery);

                // Display each moderator in a table row
                while ($moderator = mysqli_fetch_assoc($moderatorResult)) {
                    echo "<tr>";
                    echo "<td>" . $moderator['name'] . "</td>";
                    echo "<td>" . $moderator['email'] . "</td>";
                    echo "<td>";
                    echo "<a href='edit_moderator.php?id=" . $moderator['id'] . "' class='action-btn'>Edit</a>";
                    echo "<a href='?delete=" . $moderator['id'] . "' onclick='return confirm(\"Are you sure you want to delete this moderator?\")' class='action-btn'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        
        <a href="add_moderator.php" class="add-moderator-link">Add Moderator</a>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
