<?php
session_start();

require_once '../database/db_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted form data
    $propertyID = $_POST['property_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Get the user ID from the session
    $userID = $_SESSION['user_id'];

    // Prepare the SQL statement to insert the review into the database
    $insertQuery = "INSERT INTO reviews (property_id, user_id, rating, comment) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "iiis", $propertyID, $userID, $rating, $comment);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // Review insertion successful
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        // Redirect back to the property details page with a success message
        header("Location: ../property_details.php?id={$propertyID}&success=true");
        exit();
    } else {
        // Review insertion failed
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        // Redirect back to the property details page with an error message
        header("Location: ../property_details.php?id={$propertyID}&success=false");
        exit();
    }
} else {
    // Redirect back to the property details page if accessed directly without form submission
    header('Location: ../property_details.php');
    exit();
}
?>
