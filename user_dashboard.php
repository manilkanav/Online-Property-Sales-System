<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <!-- Include your CSS stylesheets and other necessary resources here -->
</head>
<body>
    <!-- Include your header.php file here -->
    <?php

        include 'includes/header.php';
        // Check if the user is logged in<?php

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            // Redirect to the login page if not logged in
            header('Location: login.php');
            exit();
        }

        echo '<h1> Welcome to Property Sales ' . $_SESSION['name'] . '!!!!</h1>';


    ?>

    <!-- Subheader with tabs -->



    <div class="subheader">
        <ul class="tabs">
            <li><a class="selected" href="user_dashboard.php">Manage Listings</a></li>
            <li><a href="manage_inspections.php">Manage Inspections</a></li>
            <li><a href="manage_reviews.php">Manage Reviews</a></li>
        </ul>
    </div>

    <!-- Main content of the user dashboard -->
    <div class="content">
        <!-- Your user dashboard content goes here -->
        <a href="add_listing.php">Add Property</a>
    </div>

    <!-- Include your footer.php file here -->
    <?php
    include 'includes/footer.php';
    ?>
</body>
</html>
