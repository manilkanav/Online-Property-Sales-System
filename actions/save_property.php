<?php
session_start();
include '../database/db_connect.php';

if (isset($_SESSION['user_id'])) {
    // Check if property ID is provided
    if (isset($_GET['id'])) {
        $propertyID = $_GET['id'];
        $userID = $_SESSION['user_id'];

        // Check if the property is already saved by the user
        $checkQuery = "SELECT * FROM saved_properties WHERE property_id = $propertyID AND user_id = $userID";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            // Property is already saved
            echo "Property is already saved.";
        } else {
            // Save the property
            $saveQuery = "INSERT INTO saved_properties (property_id, user_id) VALUES ($propertyID, $userID)";
            if (mysqli_query($conn, $saveQuery)) {
                // Property saved successfully
                header("Location: ../property_details.php?id=$propertyID");
                exit();
            } else {
                echo "Error saving property: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Invalid property ID.";
    }
} else {
    echo "You must be logged in to save a property.";
}

mysqli_close($conn);
?>
