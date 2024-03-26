<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    ?>
    <!DOCTYPE html>
    <html> 
    <head>
        <title>Secretar</title>
        <link rel="stylesheet" type ="text/css" href="style.css">
    </head>
    <body>
    <form>
        <h1 class="greeting">Hello, <?php echo $_SESSION['name']; ?></h1>
    </form>
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