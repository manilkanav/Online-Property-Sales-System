<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/user_dashboard.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <?php
        // Check if the user is logged in
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            // Redirect to the login page if not logged in
            header('Location: login.php');
            exit();
        }
    ?>

    <h1>Welcome to Property Sales, <?php echo $_SESSION['name']; ?>!</h1>

    <div class="subheader">
        <ul class="tabs">
            <li><a class="selected" href="user_dashboard.php">Manage Listings</a></li>
            <li><a href="manage_inspections.php">Manage Inspections</a></li>
            <li><a href="manage_reviews.php">Manage Reviews</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="property-listings">
            <?php
                // Include the database connection file
                require_once 'database/db_connect.php';

                // Retrieve the user's ID from the session
                $userID = $_SESSION['user_id'];

                // Prepare the SQL statement to fetch the user's properties with the first image
                $propertyQuery = "SELECT p.id, p.title, p.price, p.status, MIN(i.image_url) AS image_url
                                  FROM properties p
                                  INNER JOIN images i ON p.id = i.property_id
                                  WHERE p.user_id = $userID
                                  GROUP BY p.id";
                $propertyResult = mysqli_query($conn, $propertyQuery);

                // Check if the user has any listed properties
                if (mysqli_num_rows($propertyResult) > 0) {
                    // Display each property with image, title, price, status, and view details button
                    while ($property = mysqli_fetch_assoc($propertyResult)) {
                        echo '<div class="property-card">';
                        echo '<img src="' . $property['image_url'] . '" alt="' . $property['title'] . '">';
                        echo '<h3 class="property-title">' . $property['title'] . '</h3>';
                        echo '<p class="property-price">$' . $property['price'] . '</p>';
                        echo '<p class="property-status">' . ucwords($property['status']) . '</p>';
                        echo '<div class="property-actions">';
                        echo '<a href="edit_property.php?id=' . $property['id'] . '">Edit</a>';
                        echo '<a href="delete_property.php?id=' . $property['id'] . '">Delete</a>';
                        echo '</div>';
                        echo '<a href="property_details_user.php?id=' . $property['id'] . '" class="view-details-btn">View Details</a>';
                        echo '</div>';
                    }
                } else {
                    // No properties listed, display a redirect button to add listing page
                    echo '<p>You have no listed properties.</p>';
                    echo '<a href="add_listing.php">Add Property</a>';
                }

                // Close the database connection
                mysqli_close($conn);
            ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
