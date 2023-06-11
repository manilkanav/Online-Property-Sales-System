<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Online Property Sales</title>
    <link rel="stylesheet" href="css/styles.css"> 
    <link rel="stylesheet" href="css/index_styles.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<?php
    include 'includes/header.php';
?>

<main>
    <section class="hero">
        <div class="container">
            <h1>Welcome to Online Property Sales</h1>
            <p>Find your dream property or sell your property hassle-free!</p>
            <a href="search.php" class="btn">Search Properties</a>
        </div>
    </section>

    <section class="featured-properties">
        <div class="container">
            <h2>Featured Properties</h2>
            <div class="property-cards">
                <?php
                // Assuming you have a database connection established
                require 'database/db_connect.php';

                $sql = "SELECT p.id, p.title, i.image_url
                        FROM properties p
                        INNER JOIN images i ON p.id = i.property_id
                        WHERE p.status = 'approved'
                        GROUP BY p.id
                        LIMIT 5";

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $propertyId = $row['id'];
                        $propertyName = $row['title'];
                        $imageUrl = $row['image_url'];

                        echo '<div class="property-card">';
                        echo '<img src="' . $imageUrl . '" alt="' . $propertyName . '">';
                        echo '<h3 class="property-title">' . $propertyName . '</h3>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No featured properties available.</p>';
                }

                mysqli_close($conn);
                ?>
            </div>
        </div>
    </section>
</main>

<?php
    include 'includes/footer.php';
?>
<script src="js/script.js"></script>
</body>
</html>
