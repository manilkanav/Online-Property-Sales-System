<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard - Manage Inspections</title>
    <!-- Include your CSS stylesheets and other necessary resources here -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Include your header.php file here -->
    <?php
        include 'includes/header.php';
        // Check if the user is logged in
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            // Redirect to the login page if not logged in
            header('Location: login.php');
            exit();
        }

        echo '<h1>Welcome to Property Sales, ' . $_SESSION['name'] . '!</h1>';
    ?>

    <!-- Subheader with tabs -->
    <div class="subheader">
        <ul class="tabs">
            <li><a href="user_dashboard.php">Manage Listings</a></li>
            <li><a class="selected" href="manage_inspections.php">Manage Inspections</a></li>
            <li><a href="manage_reviews.php">Manage Reviews</a></li>
        </ul>
    </div>

    <!-- Main content of the user dashboard -->
    <div class="content">
        <section>
        <!-- Display inspection requests done by the user -->
        <h2>Inspection Requests Done By You</h2>
        <?php
            // Include the database connection file
            require_once 'database/db_connect.php';

            // Retrieve the user's ID from the session
            $userID = $_SESSION['user_id'];

            // Prepare the SQL statement to fetch the inspection requests done by the user
            $inspectionQuery = "SELECT inspection_requests.*, properties.title AS property_title FROM inspection_requests JOIN properties ON inspection_requests.property_id = properties.id WHERE inspection_requests.user_id = $userID";
            $inspectionResult = mysqli_query($conn, $inspectionQuery);

            // Check if the user has any inspection requests done
            if (mysqli_num_rows($inspectionResult) > 0) {
                // Display each inspection request with its status and property name
                while ($inspection = mysqli_fetch_assoc($inspectionResult)) {
                    echo "<div>";
                    echo "<p>Property: " . $inspection['property_title'] . "</p>";
                    echo "<p>Status: " . $inspection['status'] . "</p>";
                    // Add additional details as needed

                    // Add cancel button if the request is pending
                    if ($inspection['status'] === 'Pending') {
                        echo "<a href='actions/cancel_inspection.php?id=" . $inspection['id'] . "'>Cancel</a>";
                    }
                    echo "</div>";
                }
            } else {
                // No inspection requests done by the user
                echo "<p>You have not made any inspection requests.</p>";
            }
        ?>
        </section>

        <!-- Display inspection requests received by the user -->
        <section>
        <h2>Inspection Requests Received By You</h2>
        <?php
            // Prepare the SQL statement to fetch the inspection requests received by the user
            $receivedQuery = "SELECT inspection_requests.*, properties.title AS property_title FROM inspection_requests JOIN properties ON inspection_requests.property_id = properties.id WHERE properties.user_id = $userID";
            $receivedResult = mysqli_query($conn, $receivedQuery);

            // Check if the user has received any inspection requests
            if (mysqli_num_rows($receivedResult) > 0) {
                // Display each inspection request with approve and cancel buttons
                while ($received = mysqli_fetch_assoc($receivedResult)) {
                    echo "<div>";
                    echo "<p>Property: " . $received['property_title'] . "</p>";
                    echo "<p>Status: " . $received['status'] . "</p>";
                    // Add additional details as needed

                    // Add approve and cancel buttons if the request is pending
                    if ($received['status'] === 'Pending') {
                        echo "<a href='actions/approve_inspection.php?id=" . $received['id'] . "'>Approve</a>";
                        echo "<a href='actions/cancel_inspection.php?id=" . $received['id'] . "'>Cancel</a>";
                    }
                    echo "</div>";
                }
            } else {
                // No inspection requests received by the user
                echo "<p>You have not received any inspection requests.</p>";
            }
            // Close the database connection
            mysqli_close($conn);
        ?>
        </section>
    </div>

    <!-- Include your footer.php file here -->
    <?php
        include 'includes/footer.php';
    ?>
</body>
</html>
