<?php

// Function to delete a property
function deleteProperty($propertyId) {
    global $conn;

    // Delete property images
    $deleteImagesQuery = "DELETE FROM images WHERE property_id = $propertyId";
    $deleteImagesResult = mysqli_query($conn, $deleteImagesQuery);

    // Delete property reviews
    $deleteReviewsQuery = "DELETE FROM reviews WHERE property_id = $propertyId";
    $deleteReviewsResult = mysqli_query($conn, $deleteReviewsQuery);

    // Delete property inspection requests
    $deleteInspectionQuery = "DELETE FROM inspection_requests WHERE property_id = $propertyId";
    $deleteInspectionResult = mysqli_query($conn, $deleteInspectionQuery);

    // Delete saved property entries
    $deleteSavedPropertiesQuery = "DELETE FROM saved_properties WHERE property_id = $propertyId";
    $deleteSavedPropertiesResult = mysqli_query($conn, $deleteSavedPropertiesQuery);

    // Delete the property
    $deletePropertyQuery = "DELETE FROM properties WHERE id = $propertyId";
    $deletePropertyResult = mysqli_query($conn, $deletePropertyQuery);
}

// Function to update the status of a property to approved
function approveProperty($propertyId) {
    global $conn;
    // Perform approve operation based on the property ID
    $approveQuery = "UPDATE properties SET status = 'approved' WHERE id = $propertyId";
    $approveResult = mysqli_query($conn, $approveQuery);
}

// Function to update the status of a property to rejected
function rejectProperty($propertyId) {
    global $conn;
    // Perform reject operation based on the property ID
    $rejectQuery = "UPDATE properties SET status = 'rejected' WHERE id = $propertyId";
    $rejectResult = mysqli_query($conn, $rejectQuery);
}

?>
