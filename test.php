<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Online Property Sales</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

  <h2>Sign Up</h2>
  <form action="actions/signup_process.php" method="POST" enctype="multipart/form-data">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="firstname" required><br><br>

    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lastname" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="contact">Contact Number:</label>
    <input type="text" id="contact" name="contact" required><br><br>

    <label for="profilepic">Profile Picture:</label>
    <input type="file" id="profilepic" name="profilepic"><br><br>


    <input type="submit" value="Sign Up">
  </form>

  <?php include 'includes/footer.php'; ?>
</body>
</html>
