<!DOCTYPE html>
<html>
<head>
    <title>Edit Property</title>
    <!-- Include your CSS stylesheets and other necessary resources here -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<?php
// Include the database connection file
require_once 'database/db_connect.php';

// Check if the user is logged in
include 'includes/header.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Check if property ID is provided in the URL
if (isset($_GET['id'])) {
    $propertyID = $_GET['id'];

    // Check if the logged in user is the owner of the property
    $userID = $_SESSION['user_id'];
    $checkOwnershipQuery = "SELECT * FROM properties WHERE id = $propertyID AND user_id = $userID";
    $checkOwnershipResult = mysqli_query($conn, $checkOwnershipQuery);

    if (mysqli_num_rows($checkOwnershipResult) === 0) {
        // User is not the owner of the property, redirect to an error page or display an error message
        header('Location: error.php');
        exit();
    }

    // Retrieve the property details from the database
    $getPropertyQuery = "SELECT * FROM properties WHERE id = $propertyID";
    $getPropertyResult = mysqli_query($conn, $getPropertyQuery);

    if (mysqli_num_rows($getPropertyResult) === 1) {
        $property = mysqli_fetch_assoc($getPropertyResult);
    } else {
        // Property not found, redirect to an error page or display an error message
        header('Location: error.php');
        exit();
    }
} else {
    // Invalid property ID
    header('Location: error.php');
    exit();
}

// Close the database connection
mysqli_close($conn);
?>


    <!-- Include your header.php file here -->

    <div class="container">
        <h2>Edit Property</h2>
        <form method="POST" action="actions/update_property.php?id=<?php echo $propertyID; ?>">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo $property['title']; ?>" required><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo $property['description']; ?></textarea><br>

            <label for="price">Price:</label>
            <input type="text" id="price" name="price" value="<?php echo $property['price']; ?>" required><br>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $property['address']; ?>" required><br>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo $property['city']; ?>" required><br>

            <label for="state">State:</label>
            <input type="text" id="state" name="state" value="<?php echo $property['state']; ?>" required><br>

            <label for="country">Country:</label>
            <input type="text" id="country" name="country" value="<?php echo $property['country']; ?>" required><br>

            <label for="bedrooms">Bedrooms:</label>
            <input type="number" id="bedrooms" name="bedrooms" value="<?php echo $property['bedrooms']; ?>"><br>

            <label for="bathrooms">Bathrooms:</label>
            <input type="number" id="bathrooms" name="bathrooms" value="<?php echo $property['bathrooms']; ?>"><br>

            <label for="size">Size:</label>
            <input type="text" id="size" name="size" value="<?php echo $property['size']; ?>" required><br>

            <input type="submit" value="Update">
        </form>
    </div>

    <!-- Include your footer.php file here -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>
