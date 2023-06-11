<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Property Details</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/property_details.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <h2 class="property-title"><?php echo $property['title']; ?></h2>

                <!-- Image Carousel -->
                <div class="carousel">
                    <div class="carousel-image">
                        <?php
                        // Prepare the SQL statement to fetch the property images
                        $imageQuery = "SELECT * FROM images WHERE property_id = $propertyID";
                        $imageResult = mysqli_query($conn, $imageQuery);

                        // Check if there are images for the property
                        if (mysqli_num_rows($imageResult) > 0) {
                            while ($image = mysqli_fetch_assoc($imageResult)) {
                                echo '<img src="' . $image['image_url'] . '" alt="Property Image">';
                            }
                        } else {
                            echo '<p>No images available.</p>';
                        }
                        ?>
                    </div>
                    <div class="carousel-buttons">
                        <button class="carousel-button" onclick="changeImage(-1)"><i class="fas fa-chevron-left"></i></button>
                        <button class="carousel-button" onclick="changeImage(1)"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="property-section">
                    <h3 class="property-section-heading">Location</h3>
                    <p class="property-section-content">Location: <?php echo $property['address']; ?></p>
                </div>

                <div class="property-section">
                    <h3 class="property-section-heading">Details</h3>
                    <p class="property-section-content">Bedrooms: <?php echo $property['bedrooms']; ?></p>
                    <p class="property-section-content">Bathrooms: <?php echo $property['bathrooms']; ?></p>
                    <p class="property-section-content">Price: <?php echo $property['price']; ?></p>
                    <!-- Display other property fields as needed -->
                </div>

                <div class="property-section">
                    <h3 class="property-section-heading">Description</h3>
                    <p class="property-section-content">Description: <?php echo $property['description']; ?></p>
                </div>

                <!-- Save Property button -->
                <?php
                if (isset($_SESSION['user_id'])) {
                    $userID = $_SESSION['user_id'];
                    // Check if the property is already saved by the user
                    $savedQuery = "SELECT * FROM saved_properties WHERE user_id = $userID AND property_id = $propertyID";
                    $savedResult = mysqli_query($conn, $savedQuery);
                    if (mysqli_num_rows($savedResult) > 0) {
                        // Property is already saved
                        echo '<button class="btn btn-primary" disabled><i class="fas fa-star"></i> Property Saved</button>';
                    } else {
                        // Property is not saved, display the save button
                        echo '<a href="actions/save_property.php?id=' . $propertyID . '" class="btn btn-primary"><i class="far fa-star"></i> Save Property</a>';
                        
                        // Fetch owner's contact number
                        $ownerQuery = "SELECT contact_number FROM users WHERE id = " . $property['user_id'];
                        $ownerResult = mysqli_query($conn, $ownerQuery);
                        $owner = mysqli_fetch_assoc($ownerResult);
                        $contactNumber = $owner['contact_number'];

                        // Display the call button with owner's contact number
                        echo '<a href="tel:' . $contactNumber . '" class="btn btn-call"><i class="fas fa-phone"></i> Call</a>';
                    }
                } else {
                    // User not logged in, display a login prompt or redirect to login page
                    echo '<p>Login to save this property.</p>';
                }
                ?>

                <h3 class="property-section-heading">Reviews</h3>
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
                <h3 class="property-section-heading">Write a Review</h3>
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

        <script src="js/carousel.js"></script>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
