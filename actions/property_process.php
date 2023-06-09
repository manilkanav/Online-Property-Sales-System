<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Include the database connection file
require '../database/db_connect.php';

// Get the form data
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$bedrooms = $_POST['bedrooms'];
$bathrooms = $_POST['bathrooms'];
$size = $_POST['size'];

// Prepare the SQL statement to insert the property details
$query = "INSERT INTO properties (user_id, title, description, price, address, city, state, country, bedrooms, bathrooms, size) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);

// Bind the parameters
$stmt->bind_param("isssssssiii", $_SESSION['user_id'], $title, $description, $price, $address, $city, $state, $country, $bedrooms, $bathrooms, $size);

// Execute the query
$stmt->execute();

// Get the last inserted property ID
$propertyId = $conn->insert_id;

// Check if any images were uploaded
if (!empty($_FILES['images']['name'][0])) {
    // Process the uploaded images
    $fileNames = array_filter($_FILES['images']['name']);
    
    // Loop through the uploaded images
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $fileName = $_FILES['images']['name'][$key];
        $fileType = $_FILES['images']['type'][$key];
        $fileSize = $_FILES['images']['size'][$key];
        $fileError = $_FILES['images']['error'][$key];
        $fileTmp = $_FILES['images']['tmp_name'][$key];

        // Check if the file upload was successful
        if ($fileError === UPLOAD_ERR_OK) {
            // Generate a unique filename for the image
            $uniqueFileName = uniqid() . '_' . $fileName;
            $uploadPath = '../images/property/' . $uniqueFileName;

            // Move the uploaded image to the destination folder
            if (move_uploaded_file($fileTmp, $uploadPath)) {
                // Insert the image details into the images table
                $insertQuery = "INSERT INTO images (property_id, image_url) VALUES (?, ?)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param("is", $propertyId, $uploadPath);
                $insertStmt->execute();
            }
        }
    }
}

// Close the prepared statement and database connection
$stmt->close();
$conn->close();

// Redirect to the property listing page or any other desired page
header('Location: ../user_dashboard.php');
exit();
