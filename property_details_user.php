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

        // Display the property details
        echo "<h2>Property Details</h2>";
        echo "<p>Title: " . $property['title'] . "</p>";
        echo "<p>Description: " . $property['description'] . "</p>";
        echo "<p>Price: $" . $property['price'] . "</p>";
        echo "<p>Address: " . $property['address'] . "</p>";
        echo "<p>City: " . $property['city'] . "</p>";
        echo "<p>State: " . $property['state'] . "</p>";
        echo "<p>Country: " . $property['country'] . "</p>";
        echo "<p>Bedrooms: " . $property['bedrooms'] . "</p>";
        echo "<p>Bathrooms: " . $property['bathrooms'] . "</p>";
        echo "<p>Size: " . $property['size'] . " sqft</p>";
        echo "<p>Status: " . $property['status'] . "</p>";

        // Check if the property is pending approval
        if ($property['status'] === 'pending') {
            echo "<p>Your property is currently pending approval.</p>";
        } elseif ($property['status'] === 'rejected') {
            echo "<p>Your property has been rejected.</p>";
        }

        // Display edit and delete buttons for the property
        echo "<a href='edit_property.php?id=$propertyID'>Edit Property</a>";
        echo "<a href='actions/delete_property.php?id=$propertyID'>Delete Property</a>";
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
