<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    ?>
    <!DOCTYPE html>
    <html> 
    <head>
        <title>Admin</title>
        <link rel="stylesheet" type ="text/css" href="style.css">
    </head>
    <body>
    <form>
        <h1 class="greeting">Admin Page</h1>
    </form>
    <a href="register.php" class="register-button">Register </a>
    <a href="logout.php" class="logout-button">Logout </a>
    </body>
    </html>
    <?php
}
else {
   header("Location: index.php");
   exit();
}

?>