<?php

require_once '../database/db_connect.php';

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

    // Check if the logged in user is the owner of the property
    $userID = $_SESSION['user_id'];
    $checkOwnershipQuery = "SELECT * FROM properties WHERE id = $propertyID AND user_id = $userID";
    $checkOwnershipResult = mysqli_query($conn, $checkOwnershipQuery);

    if (mysqli_num_rows($checkOwnershipResult) === 0) {
        // User is not the owner of the property, redirect to an error page or display an error message
        header('Location: error.php');
        exit();
    }

    // Handle the form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the updated property information from the form
        $title = $_POST['title'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $country = $_POST['country'];
        $bedrooms = $_POST['bedrooms'];
        $bathrooms = $_POST['bathrooms'];
        $price = $_POST['price'];
        $size = $_POST['size'];
        $description = $_POST['description'];

        // Update the property in the database
        $updateQuery = "UPDATE properties SET title = '$title', address = '$address', city = '$city', state = '$state', country = '$country', bedrooms = $bedrooms, bathrooms = $bathrooms, price = $price, size = $size, description = '$description' WHERE id = $propertyID";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            // Property updated successfully
            header("Location: ../property_details_user.php?id=$propertyID");
            exit();
        } else {
            // Failed to update the property
            exit();
        }
    }
} else {
    // Invalid property ID
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
