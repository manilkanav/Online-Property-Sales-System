<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <!-- Include your CSS stylesheets and other necessary resources here -->
</head>
<body>
    <!-- Include your header.php file here -->
    <?php
        include 'includes/header.php';
        // Check if the user is logged in
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            // Redirect to the login page if not logged in
            header('Location: login.php');
            exit();
        }

        echo '<h1>Welcome to Property Sales, ' . $_SESSION['name'] . '!</h1>';
    ?>

    <!-- Subheader with tabs -->
    <div class="subheader">
        <ul class="tabs">
            <li><a class="selected" href="user_dashboard.php">Manage Listings</a></li>
            <li><a href="manage_inspections.php">Manage Inspections</a></li>
            <li><a href="manage_reviews.php">Manage Reviews</a></li>
        </ul>
    </div>

    <!-- Main content of the user dashboard -->
    <div class="content">
        <!-- Display properties listed by the user -->
        <?php
            // Include the database connection file
            require_once 'database/db_connect.php';

            // Retrieve the user's ID from the session
            $userID = $_SESSION['user_id'];

            // Prepare the SQL statement to fetch the user's properties
            $propertyQuery = "SELECT * FROM properties WHERE user_id = $userID";
            $propertyResult = mysqli_query($conn, $propertyQuery);

            // Check if the user has any listed properties
            if (mysqli_num_rows($propertyResult) > 0) {
                // Display each property with edit and delete buttons
                while ($property = mysqli_fetch_assoc($propertyResult)) {
                    echo "<div>";
                    echo "<h3>Title: " . $property['title'] . "</h3>";
                    echo "<p>Address: " . $property['address'] . "</p>";
                    echo "<p>Bedrooms: " . $property['bedrooms'] . "</p>";
                    echo "<p>Bathrooms: " . $property['bathrooms'] . "</p>";
                    // Add additional property details as needed

                    // Add edit and delete buttons
                    echo "<a href='edit_property.php?id=" . $property['id'] . "'>Edit</a>";
                    echo "<a href='actions/delete_property.php?id=" . $property['id'] . "'>Delete</a>";
                    echo "</div>";
                }
            } else {
                // No properties listed, display a redirect button to add listing page
                echo "<p>You have no listed properties.</p>";
                echo "<a href='add_listing.php'>Add Property</a>";
            }

            // Close the database connection
            mysqli_close($conn);
        ?>
    </div>

    <!-- Include your footer.php file here -->
    <?php
        include 'includes/footer.php';
    ?>
</body>
</html>
