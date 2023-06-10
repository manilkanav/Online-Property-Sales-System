<?php
    // Include the database connection file
    require_once '../database/db_connect.php';

    // Check if the property ID is provided in the URL
    if (isset($_GET['id'])) {
        $propertyID = $_GET['id'];

        // Delete property images
        $deleteImagesQuery = "DELETE FROM images WHERE property_id = $propertyID";
        $deleteImagesResult = mysqli_query($conn, $deleteImagesQuery);

        // Delete property reviews
        $deleteReviewsQuery = "DELETE FROM reviews WHERE property_id = $propertyID";
        $deleteReviewsResult = mysqli_query($conn, $deleteReviewsQuery);

        // Delete property inspection requests
        $deleteInspectionQuery = "DELETE FROM inspection_requests WHERE property_id = $propertyID";
        $deleteInspectionResult = mysqli_query($conn, $deleteInspectionQuery);

        // Delete the property
        $deletePropertyQuery = "DELETE FROM properties WHERE id = $propertyID";
        $deletePropertyResult = mysqli_query($conn, $deletePropertyQuery);

        if ($deleteImagesResult && $deleteReviewsResult && $deleteInspectionResult && $deletePropertyResult) {
            // Property and associated data deleted successfully
            header("Location: ../user_dashboard.php");
            exit();
        } else {
            // Failed to delete the property and associated data
            header("Location: ../user_dashboard.php");
            exit();
        }
    } else {
        // Invalid property ID
        header("Location: ../user_dashboard.php");
        exit();
    }

    // Close the database connection
    mysqli_close($conn);
?>
