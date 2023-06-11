<header>
    <nav>
        <div class="logo">
            <a href="index.php"><img src="../images/assets/logo.png" alt="Logo" ></a>
        </div>
        <div class="pages">
            <ul>
                <li><a href="index.php" class="nav-link">Home</a></li>
                <li><a href="search.php" class="nav-link">Search</a></li>
                <li><a href="user_profile.php" class="nav-link">My Profile</a></li>
                <li><a href="add_listing.php" class="nav-link">Add Listing</a></li>
                <!-- Add more menu items as needed -->
            </ul>
        </div>
        <div class="user">
            <?php
            session_start();
            // Check if user is logged in
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                // User is logged in, display profile pic and dropdown arrow

                $profile_picture = $_SESSION['profile_pic'];

                echo '<div class="profile-container">';
                echo '<img class="profile-img" src="../images/profile/' . $profile_picture . '" alt="Profile Pic">';
                echo '<svg class="dropdown-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z"></path></svg>';
                echo '<div class="dropdown-menu">';
                echo '<a href="user_dashboard.php" class="dropdown-link">Dashboard</a>';
                echo '<a href="#" class="dropdown-link">Settings</a>';
                echo '<a href="#" class="dropdown-link">Profile</a>';
                echo '<a href="actions/logout.php" class="dropdown-link">Logout</a>';
                echo '</div>';
                echo '</div>';
            } else {
                // User is not logged in, display login and signup buttons

                echo '<div class="buttons">';
                echo '<a href="login.php" class="login_button button">Login</a>';
                echo '<a href="test.php" class="signup_button button">Sign Up</a>';
                echo '</div>';
            }
            ?>
        </div>
    </nav>
</header>
