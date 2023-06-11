<!DOCTYPE html>
<html>
<head>
    <title>Property Details</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/property_details.css">
</head>
<body>
    <?php
    // Include the database connection file
    require_once 'database/db_connect.php';

    require 'includes/header.php';

    // Check if the user is logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        // Redirect to the login page if not logged in
        header('Location: login.php');
        exit();
    }

    // Check if property ID is provided in the URL
    if (isset($_GET['id'])) {
        $propertyID = $_GET['id'];
        $userID = $_SESSION['user_id'];

        // Retrieve the property details
        $query = "SELECT * FROM properties WHERE id = $propertyID AND user_id = $userID";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 1) {
            $property = mysqli_fetch_assoc($result);
            ?>
            <h2 class="property-title">Property Details</h2>
            <p><strong>Title:</strong> <?php echo $property['title']; ?></p>
            <p><strong>Description:</strong> <?php echo $property['description']; ?></p>
            <p><strong>Price:</strong> $<?php echo $property['price']; ?></p>
            <p><strong>Address:</strong> <?php echo $property['address']; ?></p>
            <p><strong>City:</strong> <?php echo $property['city']; ?></p>
            <p><strong>State:</strong> <?php echo $property['state']; ?></p>
            <p><strong>Country:</strong> <?php echo $property['country']; ?></p>
            <p><strong>Bedrooms:</strong> <?php echo $property['bedrooms']; ?></p>
            <p><strong>Bathrooms:</strong> <?php echo $property['bathrooms']; ?></p>
            <p><strong>Size:</strong> <?php echo $property['size']; ?> sqft</p>
            <p><strong>Status:</strong> <?php echo $property['status']; ?></p>

            <?php
            // Check if the property is pending approval
            if ($property['status'] === 'pending') {
                echo "<p>Your property is currently pending approval.</p>";
            } elseif ($property['status'] === 'rejected') {
                echo "<p>Your property has been rejected.</p>";
            }
            ?>

            <!-- Display edit and delete buttons for the property -->
            <a href="edit_property.php?id=<?php echo $propertyID; ?>" class="edit-property-btn">Edit Property</a>
            <a href="actions/delete_property.php?id=<?php echo $propertyID; ?>" class="delete-property-btn">Delete Property</a>
            <?php
        } else {
            // Property not found or user is not the owner
            echo "<p class='error-msg'>Property not found or you are not the owner of the property.</p>";
        }
    } else {
        // Invalid property ID
        echo "<p class='error-msg'>Invalid property ID.</p>";
    }

    include 'includes/footer.php';
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
