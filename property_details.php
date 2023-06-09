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
            $propertyQuery = "SELECT * FROM properties WHERE id = $propertyID";
            $propertyResult = mysqli_query($conn, $propertyQuery);

            // Check if the property exists
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
                $reviewQuery = "SELECT * FROM reviews WHERE property_id = $propertyID";
                $reviewResult = mysqli_query($conn, $reviewQuery);

                // Check if there are reviews for the property
                if (mysqli_num_rows($reviewResult) > 0) {
                    while ($review = mysqli_fetch_assoc($reviewResult)) {
                        ?>
                        <div class="review">
                            <p>Rating: <?php echo $review['rating']; ?></p>
                            <p>Comment: <?php echo $review['comment']; ?></p>
                        </div>
                        <?php
                    }
                } else {
                    echo "No reviews found for this property.";
                }
            } else {
                echo "Property not found.";
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
