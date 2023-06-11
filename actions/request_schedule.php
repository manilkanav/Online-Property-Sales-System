<?php
// Include the database connection file
require_once '../database/db_connect.php';

// Check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to the login page
    header('Location: ../login.php');
    exit;
}

// Check if the property ID and schedule date are provided
if (isset($_POST['property_id']) && isset($_POST['schedule_date'])) {
    $propertyID = $_POST['property_id'];
    $scheduleDate = $_POST['schedule_date'];

    // Prepare the SQL statement to insert the schedule request into the database
    $insertQuery = "INSERT INTO inspection_requests (property_id, user_id, inspection_date) VALUES ('$propertyID', '{$_SESSION['user_id']}', '$scheduleDate')";
    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
        // Schedule request inserted successfully
        // Redirect to property details page
        header("Location: ../property_details.php?id=$propertyID");
        exit;
    } else {
        // Error inserting the schedule request
        echo "Error submitting the schedule request. Please try again.";
    }
} else {
    // Property ID or schedule date is missing
    echo "Invalid request. Please provide the necessary information.";
}

// Close the database connection
mysqli_close($conn);
