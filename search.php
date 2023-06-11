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
        <h2 class ="header_name">Find the property that fits you..</h2>
        <form class="searchbar" method="GET">
            <input type="text" id="search" name="search" class="searchbox" required >
            <select id="search_by" name="search_by" class ="searchbox_dropdown">
                <option value="name">Name</option>
                <option value="location">Location</option>
                <option value="bedrooms">Bedrooms</option>
                <option value="bathrooms">Bathrooms</option>
            </select>
            <input type="submit" value="Search" class = "searchbutton">
        </form>
    </div>

    <div id="search-results">
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
                        $query = "SELECT * FROM properties WHERE title LIKE '%$searchTerm%' AND status = 'approved'";
                        break;
                    case 'location':
                        $query = "SELECT * FROM properties WHERE address LIKE '%$searchTerm%' AND status = 'approved'";
                        break;
                    case 'bedrooms':
                        $query = "SELECT * FROM properties WHERE bedrooms = '$searchTerm' AND status = 'approved'";
                        break;
                    case 'bathrooms':
                        $query = "SELECT * FROM properties WHERE bathrooms = '$searchTerm' AND status = 'approved'";
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
                        // Display the property information
                        echo "<p>Title: " . $row['title'] . "</p>";
                        echo "<p>Location: " . $row['address'] . "</p>";
                        echo "<p>Bedrooms: " . $row['bedrooms'] . "</p>";
                        echo "<p>Bathrooms: " . $row['bathrooms'] . "</p>";
                        echo "<a href='property_details.php?id=" . $row['id'] . "'>View More</a>";
                        echo "<hr>";
                    }
                } else {
                    echo "No properties found.";
                }

                // Close the database connection
                mysqli_close($conn);
            }
        ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
