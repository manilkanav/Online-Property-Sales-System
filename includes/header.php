<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Online Property Sales</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="search.php">Search Properties</a></li>
                <li><a href="user_profile.php">My Profile</a></li>
                <li><a href="add_listing.php">Add Listing</a></li>
                <!-- Add more menu items as needed -->
            </ul>
            <?php
                session_start();

                // Check if user is logged in
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    // User is logged in, display profile pic logo and dropdown menu

                    $profile_picture = $_SESSION['profile_pic'];


                    echo '<img src="' . $profile_picture . '"' . 'alt="Profile Pic">';
                    echo '<div class="dropdown-menu">';
                    echo '<a href="#">Settings</a>';
                    echo '<a href="#">Profile</a>';
                    echo '<a href="actions/logout.php">Logout</a>';
                    echo '</div>';
                } else {
                    // User is not logged in, display login button
                    echo '<a href="login.php">Login</a>';
                }
                ?>            
        </nav>
    </header>

