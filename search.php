<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Property Search</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/search_styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h2 class="header_name">Find the property that fits you..</h2>
        <form class="searchbar" method="GET">
            <input type="text" id="search" name="search" class="searchbox" required>
            <select id="search_by" name="search_by" class="searchbox_dropdown">
                <option value="name">Name</option>
                <option value="location">Location</option>
                <option value="bedrooms">Bedrooms</option>
                <option value="bathrooms">Bathrooms</option>
            </select>
            <input type="submit" value="Search" class="searchbutton">
        </form>
    </div>

    <div id="search-results" class="property-listings">
        <?php
            // Include the database connection file
            require 'database/db_connect.php';

            if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
                // Retrieve the search term and search by option
                $searchTerm = $_GET['search'];
                $searchBy = $_GET['search_by'];

                // Prepare the SQL statement based on the selected search option
                switch ($searchBy) {
                    case 'name':
                        $query = "SELECT p.*, MIN(i.image_url) AS image_url FROM properties p
                                  INNER JOIN images i ON p.id = i.property_id
                                  WHERE p.title LIKE '%$searchTerm%' AND p.status = 'approved'
                                  GROUP BY p.id";
                        break;
                    case 'location':
                        $query = "SELECT p.*, MIN(i.image_url) AS image_url FROM properties p
                                  INNER JOIN images i ON p.id = i.property_id
                                  WHERE p.address LIKE '%$searchTerm%' AND p.status = 'approved'
                                  GROUP BY p.id";
                        break;
                    case 'bedrooms':
                        $query = "SELECT p.*, MIN(i.image_url) AS image_url FROM properties p
                                  INNER JOIN images i ON p.id = i.property_id
                                  WHERE p.bedrooms = '$searchTerm' AND p.status = 'approved'
                                  GROUP BY p.id";
                        break;
                    case 'bathrooms':
                        $query = "SELECT p.*, MIN(i.image_url) AS image_url FROM properties p
                                  INNER JOIN images i ON p.id = i.property_id
                                  WHERE p.bathrooms = '$searchTerm' AND p.status = 'approved'
                                  GROUP BY p.id";
                        break;
                    default:
                        $query = "";
                        break;
                }

                // Execute the query
                $result = mysqli_query($conn, $query);

                // Check if any properties are found
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Display the property card
                        echo '<div class="property-card">';
                        echo '<img src="' . $row['image_url'] . '" alt="' . $row['title'] . '">';
                        echo '<h3 class="property-title">' . $row['title'] . '</h3>';
                        echo '<p class="property-price">$' . $row['price'] . '</p>';
                        echo '<a href="property_details.php?id=' . $row['id'] . '" class="view-details">View Details</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="empty-container">No properties found.</div>';
                }

                // Close the database connection
                mysqli_close($conn);
            } else {
                echo '<div class="empty-container">Perform a search to see results.</div>';
            }
        ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
