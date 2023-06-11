<!DOCTYPE html>
<html>
<head>
    <title>Edit Review</title>
    <link rel="stylesheet" href="css/styles.css">
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

// Check if review ID is provided in the URL
if (isset($_GET['id'])) {
    $reviewID = $_GET['id'];
    $userID = $_SESSION['user_id'];

    // Retrieve the review details
    $query = "SELECT * FROM reviews WHERE id = $reviewID AND user_id = $userID";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $review = mysqli_fetch_assoc($result);

        // Check if the form is submitted for updating the review
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newComment = $_POST['comment'];

            // Update the review in the database
            $updateQuery = "UPDATE reviews SET comment = '$newComment' WHERE id = $reviewID";
            if (mysqli_query($conn, $updateQuery)) {
                // Redirect to the manage_reviews.php page after successful update
                header('Location: manage_reviews.php');
                exit();
            } else {
                echo "Error updating review: " . mysqli_error($conn);
            }
        }
        ?>

require 'includes/header.php'; 

<h2 class="edit-review-title">Edit Review</h2>

<form action="" method="POST" class="edit-review-form">
    <label for="comment">Comment:</label>
    <textarea name="comment" id="comment" rows="4" cols="50"><?php echo $review['comment']; ?></textarea>

    <input type="submit" value="Update Review" class="update-review-btn">
</form>

<?php require 'includes/footer.php'; ?>
</body>
</html>

        <?php
    } else {
        // Review not found or user is not the author of the review
        echo "Review not found or you are not the author of the review.";
    }
} else {
    // Invalid review ID
    echo "Invalid review ID.";
}

// Close the database connection
mysqli_close($conn);
?>
