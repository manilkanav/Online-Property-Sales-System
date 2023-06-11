<?php
session_start();

// Check if the moderator is logged in
if (!isset($_SESSION['moderator_id'])) {
    // Redirect to the moderator login page if not logged in
    header('Location: moderator_login.php');
    exit();
}

// Include the database connection file
require '../database/db_connect.php';

// Check if the property ID is provided
if (isset($_GET['property_id'])) {
    $propertyId = $_GET['property_id'];

    // Retrieve the property details from the database
    $propertyQuery = "SELECT * FROM properties WHERE id = ?";
    $stmt = mysqli_prepare($conn, $propertyQuery);
    mysqli_stmt_bind_param($stmt, "i", $propertyId);
    mysqli_stmt_execute($stmt);
    $propertyResult = mysqli_stmt_get_result($stmt);
    $property = mysqli_fetch_assoc($propertyResult);

    // Check if the property exists
    if (!$property) {
        echo "<p>Property not found.</p>";
        exit();
    }
} else {
    echo "<p>Invalid property ID.</p>";
    exit();
}

// Retrieve the images for the property from the database
$imageQuery = "SELECT * FROM images WHERE property_id = ?";
$stmt = mysqli_prepare($conn, $imageQuery);
mysqli_stmt_bind_param($stmt, "i", $propertyId);
mysqli_stmt_execute($stmt);
$imageResult = mysqli_stmt_get_result($stmt);
$images = mysqli_fetch_all($imageResult, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Property Details</title>
    <link rel="stylesheet" href="../css/moderator_styles.css">
    <link rel="stylesheet" href="../css/property_details_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
</head>
<body>
    <header class="nav">
        <div class="container">
            <h1>Property Details</h1>
            <a href="moderator_dashboard.php" class="back-btn">Back to Dashboard</a>
            <a href="?logout" class="logout-btn">Logout</a>
        </div>
    </header>

    <div class="container">
        <h2>Property Information</h2>
        <p><strong>Title:</strong> <?php echo $property['title']; ?></p>
        <p><strong>Description:</strong> <?php echo $property['description']; ?></p>
        <p><strong>Number of Rooms:</strong> <?php echo $property['bedrooms']; ?></p>
        <p><strong>Number of Bathrooms:</strong> <?php echo $property['bathrooms']; ?></p>
        <p><strong>Price:</strong> <?php echo $property['price']; ?></p>
        <p><strong>Area:</strong> <?php echo $property['size']; ?></p>
        <!-- Add additional property details as needed -->
    </div>

    <h2>Property Images</h2>
    <?php if (count($images) > 0): ?>
        <div class="image-carousel">
            <?php foreach ($images as $image): ?>
                <img src="<?php echo $image['image_url']; ?>" alt="Property Image">
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No images available for this property.</p>
    <?php endif; ?>

    <div class="buttons-container">
        <?php if ($property['status'] === 'pending'): ?>
            <form action="" method="POST">
                <input type="hidden" name="property_id" value="<?php echo $property['id']; ?>">
                <button type="submit" name="approve" class="approve-btn">Approve</button>
                <button type="submit" name="reject" class="reject-btn">Reject</button>
            </form>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="hidden" name="property_id" value="<?php echo $property['id']; ?>">
            <button type="submit" name="delete" class="delete-btn">Delete</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="../js/script.js"></script>
    <script>
        $(document).ready(function() {
            $('.image-carousel').slick({
                dots: true,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1
            });
        });
    </script>
</body>
</html>
