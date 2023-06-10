<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Property Details</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <?php
        // Include the database connection file
        require_once 'database/db_connect.php';

        // Check if property ID is provided in the URL
        if (isset($_GET['id'])) {
            $propertyID = $_GET['id'];

            // Prepare the SQL statement to fetch the property details
            $propertyQuery = "SELECT * FROM properties WHERE id = $propertyID AND status = 'approved'";
            $propertyResult = mysqli_query($conn, $propertyQuery);

            // Check if the property exists and is approved
            if (mysqli_num_rows($propertyResult) > 0) {
                $property = mysqli_fetch_assoc($propertyResult);
                ?>
                <h2><?php echo $property['title']; ?></h2>
                <p>Location: <?php echo $property['address']; ?></p>
                <p>Bedrooms: <?php echo $property['bedrooms']; ?></p>
                <p>Bathrooms: <?php echo $property['bathrooms']; ?></p>
                <p>Price: <?php echo $property['price']; ?></p>
                <p>Description: <?php echo $property['description']; ?></p>
                <!-- Display other property fields as needed -->

                <h3>Reviews</h3>
                <?php
                // Prepare the SQL statement to fetch the reviews for the property
                $reviewQuery = "SELECT reviews.*, users.name FROM reviews JOIN users ON reviews.user_id = users.id WHERE property_id = $propertyID";
                $reviewResult = mysqli_query($conn, $reviewQuery);

                // Check if there are reviews for the property
                if (mysqli_num_rows($reviewResult) > 0) {
                    while ($review = mysqli_fetch_assoc($reviewResult)) {
                        ?>
                        <div class="review">
                            <p>User: <?php echo $review['name']; ?></p>
                            <p>Rating: <?php echo $review['rating']; ?></p>
                            <p>Comment: <?php echo $review['comment']; ?></p>
                            <?php
                            // Check if the logged in user is the owner of the review
                            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']) {
                                ?>
                                <a href="actions/delete_review.php?id=<?php echo $review['id']; ?>">Delete</a>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                } else {
                    echo "No reviews found for this property.";
                }

                // Option to write a review
                ?>
                <h3>Write a Review</h3>
                <form action="actions/review_process.php" method="POST">
                    <input type="hidden" name="property_id" value="<?php echo $propertyID; ?>">
                    <label for="rating">Rating:</label>
                    <input type="number" id="rating" name="rating" min="1" max="5" required><br><br>
                    <label for="comment">Comment:</label>
                    <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br><br>
                    <input type="submit" value="Submit Review">
                </form>
                <?php
            } else {
                echo "Property not found or not approved.";
            }

            // Close the database connection
            mysqli_close($conn);
        } else {
            echo "Invalid property ID.";
        }
        ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
