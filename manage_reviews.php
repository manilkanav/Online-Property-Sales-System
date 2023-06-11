<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard - Manage Reviews</title>
    <!-- Include your CSS stylesheets and other necessary resources here -->
    <link rel="stylesheet" href="css/styles.css">
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
            <li><a href="user_dashboard.php">Manage Listings</a></li>
            <li><a href="manage_inspections.php">Manage Inspections</a></li>
            <li><a class="selected" href="manage_reviews.php">Manage Reviews</a></li>
        </ul>
    </div>

    <!-- Main content of the user dashboard -->
    <div class="content">
        <!-- Display reviews done by the user -->
        <h2>Reviews Done By You</h2>
        <?php
            // Include the database connection file
            require_once 'database/db_connect.php';

            // Retrieve the user's ID from the session
            $userID = $_SESSION['user_id'];

            // Prepare the SQL statement to fetch the reviews done by the user
            $reviewQuery = "SELECT reviews.*, properties.title AS property_title FROM reviews JOIN properties ON reviews.property_id = properties.id WHERE reviews.user_id = $userID";
            $reviewResult = mysqli_query($conn, $reviewQuery);

            // Check if the user has any reviews
            if (mysqli_num_rows($reviewResult) > 0) {
                // Display each review with property name and options
                while ($review = mysqli_fetch_assoc($reviewResult)) {
                    echo "<div>";
                    echo "<p>Property: " . $review['property_title'] . "</p>";
                    echo "<p>Review: " . $review['comment'] . "</p>";
                    // Add additional details as needed

                    // Add option to view property details
                    echo "<a href='property_details.php?id=" . $review['property_id'] . "'>View Property Details</a>";
                    // Add option to edit review
                    echo "<a href='edit_review.php?id=" . $review['id'] . "'>Edit Review</a>";
                    // Add option to delete review
                    echo "<a href='actions/delete_review.php?id=" . $review['id'] . "'>Delete Review</a>";
                    echo "</div>";
                }
            } else {
                // No reviews done by the user
                echo "<p>You have not written any reviews.</p>";
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
