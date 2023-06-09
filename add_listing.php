<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Property Listing</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/header.php'; 

    // Check if the user is logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        // Redirect to the login page if not logged in
        header('Location: login.php');
        exit();
    }
?>

<h2>Add Property Listing</h2>

<script>
    function validateFileUpload() {
        var fileInputs = document.querySelectorAll('input[type="file"]');
        var fileCount = 0;

        // Count the number of selected files
        for (var i = 0; i < fileInputs.length; i++) {
            if (fileInputs[i].value) {
                fileCount++;
            }
        }

        // Check if the number of selected files exceeds the limit
        if (fileCount > 5) {
            alert('You can only upload up to 5 files.');
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }
</script>

<form action="actions/property_process.php" method="POST" enctype="multipart/form-data" onsubmit="return validateFileUpload();">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required><br><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea><br><br>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" required><br><br>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required><br><br>

    <label for="city">City:</label>
    <input type="text" id="city" name="city" required><br><br>

    <label for="state">State:</label>
    <input type="text" id="state" name="state" required><br><br>

    <label for="country">Country:</label>
    <input type="text" id="country" name="country" required><br><br>

    <label for="bedrooms">Bedrooms:</label>
    <input type="number" id="bedrooms" name="bedrooms" required><br><br>

    <label for="bathrooms">Bathrooms:</label>
    <input type="number" id="bathrooms" name="bathrooms" required><br><br>

    <label for="size">Size (in sq ft):</label>
    <input type="number" id="size" name="size" required><br><br>

    <label for="images">Upload Images:</label>
    <input type="file" id="images" name="images[]" accept="image/*" multiple><br><br>

    <input type="submit" value="Add Listing">
</form>

<?php include 'includes/footer.php'; ?>
</body>
</html>
