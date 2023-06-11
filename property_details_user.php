<!DOCTYPE html>
<html>
<head>
    <title>Property Details</title>
</head>
<body>
    <?php
    // Include the database connection file
    require_once 'database/db_connect.php';

    // Check if the user is logged in
    session_start();
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
            <h2>Property Details</h2>
            <p>Title: <?php echo $property['title']; ?></p>
            <p>Description: <?php echo $property['description']; ?></p>
            <p>Price: $<?php echo $property['price']; ?></p>
            <p>Address: <?php echo $property['address']; ?></p>
            <p>City: <?php echo $property['city']; ?></p>
            <p>State: <?php echo $property['state']; ?></p>
            <p>Country: <?php echo $property['country']; ?></p>
            <p>Bedrooms: <?php echo $property['bedrooms']; ?></p>
            <p>Bathrooms: <?php echo $property['bathrooms']; ?></p>
            <p>Size: <?php echo $property['size']; ?> sqft</p>
            <p>Status: <?php echo $property['status']; ?></p>

            <?php
            // Check if the property is pending approval
            if ($property['status'] === 'pending') {
                echo "<p>Your property is currently pending approval.</p>";
            } elseif ($property['status'] === 'rejected') {
                echo "<p>Your property has been rejected.</p>";
            }
            ?>

            <!-- Display edit and delete buttons for the property -->
            <a href="edit_property.php?id=<?php echo $propertyID; ?>">Edit Property</a>
            <a href="actions/delete_property.php?id=<?php echo $propertyID; ?>">Delete Property</a>
            <?php
        } else {
            // Property not found or user is not the owner
            echo "Property not found or you are not the owner of the property.";
        }
    } else {
        // Invalid property ID
        echo "Invalid property ID.";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
