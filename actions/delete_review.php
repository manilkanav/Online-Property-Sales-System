<?php
// Include the database connection file
require_once '../database/db_connect.php';

// Check if review ID is provided in the URL
if (isset($_GET['id'])) {
    $reviewID = $_GET['id'];

    // Prepare the SQL statement to fetch the property ID associated with the review
    $propertyIDQuery = "SELECT property_id FROM reviews WHERE id = $reviewID";
    $propertyIDResult = mysqli_query($conn, $propertyIDQuery);

    if (mysqli_num_rows($propertyIDResult) > 0) {
        $property = mysqli_fetch_assoc($propertyIDResult);
        $propertyID = $property['property_id'];

        // Prepare the SQL statement to delete the review
        $deleteQuery = "DELETE FROM reviews WHERE id = $reviewID";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            // Review deleted successfully
            header("Location: ../property_details.php?id={$propertyID}&success=true");
            exit();
        } else {
            // Failed to delete the review
            header("Location: ../property_details.php?id={$propertyID}&success=false");
            exit();
        }
    } else {
        // Review not found or invalid review ID
        header("Location: ../property_details.php?success=false");
        exit();
    }
} else {
    // Invalid review ID
    header("Location: ../property_details.php?success=false");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
