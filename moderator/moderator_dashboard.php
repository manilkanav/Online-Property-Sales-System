<?php
session_start();

// Check if the moderator is logged in
if (!isset($_SESSION['moderator_id'])) {
    // Redirect to the moderator login page if not logged in
    header('Location: moderator_login.php');
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    // Destroy the session and redirect to the login page
    session_destroy();
    header('Location: moderator_login.php');
    exit();
}

// Include the database connection file
require '../database/db_connect.php';
require '../includes/utility_functions.php';


// Handle delete button click
if (isset($_POST['delete'])) {
    $propertyId = $_POST['property_id'];
    deleteProperty($propertyId);
}

// Handle approve button click
if (isset($_POST['approve'])) {
    $propertyId = $_POST['property_id'];
    approveProperty($propertyId);
}

// Handle reject button click
if (isset($_POST['reject'])) {
    $propertyId = $_POST['property_id'];
    rejectProperty($propertyId);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Moderator Dashboard</title>
    <link rel="stylesheet" href="../css/moderator_styles.css">
</head>
<body>
    <header class="nav">
        <div class="container">
            <h1>Welcome to the Moderator Dashboard</h1>
            <a href="?logout" class="logout-btn">Logout</a>
        </div>
    </header>

    <div class="container">
        <h2>Approved Properties</h2>
        <?php
        // Retrieve the approved properties from the database
        $approvedQuery = "SELECT * FROM properties WHERE status = 'approved'";
        $approvedResult = mysqli_query($conn, $approvedQuery);

        // Check if there are any approved properties
        if (mysqli_num_rows($approvedResult) > 0) {
            // Display each approved property with a delete button and details button
            while ($property = mysqli_fetch_assoc($approvedResult)) {
                echo "<div>";
                echo "<p>Title: " . $property['title'] . "</p>";
                echo "<p>Description: " . $property['description'] . "</p>";
                // Add additional property details as needed

                // Add details button
                echo "<form action='property_details_moderator.php' method='GET'>";
                echo "<input type='hidden' name='property_id' value='" . $property['id'] . "'>";
                echo "<button type='submit' class='details-btn'>Details</button>";
                echo "</form>";

                // Add delete button
                echo "<form action='' method='POST'>";
                echo "<input type='hidden' name='property_id' value='" . $property['id'] . "'>";
                echo "<button type='submit' name='delete' class='delete-btn'>Delete</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No approved properties available.</p>";
        }

        // Retrieve the pending properties from the database
        $pendingQuery = "SELECT * FROM properties WHERE status = 'pending'";
        $pendingResult = mysqli_query($conn, $pendingQuery);

        // Check if there are any pending properties
        if (mysqli_num_rows($pendingResult) > 0) {
            echo "<h2>Pending Properties</h2>";
            // Display each pending property with approve and reject buttons
            while ($property = mysqli_fetch_assoc($pendingResult)) {
                echo "<div>";
                echo "<p>Title: " . $property['title'] . "</p>";
                echo "<p>Description: " . $property['description'] . "</p>";
                // Add additional property details as needed

                // Add details button
                echo "<form action='property_details_moderator.php' method='GET'>";
                echo "<input type='hidden' name='property_id' value='" . $property['id'] . "'>";
                echo "<button type='submit' class='details-btn'>Details</button>";
                echo "</form>";

                // Add approve and reject buttons
                echo "<form action='' method='POST'>";
                echo "<input type='hidden' name='property_id' value='" . $property['id'] . "'>";
                echo "<button type='submit' name='approve' class='approve-btn'>Approve</button>";
                echo "<button type='submit' name='reject' class='reject-btn'>Reject</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No pending properties available.</p>";
        }
        ?>
    </div>

    <script src="../js/script.js"></script>
</body>
</html>
