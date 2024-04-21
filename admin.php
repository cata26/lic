<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    ?>
    <!DOCTYPE html>
    <html> 
    <head>
        <title>Admin</title>
        <link rel="icon" href="upt.png" type="image/x-icon">
        <link rel="stylesheet" type ="text/css" href="style2.css">
    </head>
    <body>
    <section>
     <div class="user-container">
     <h1 class="greeting"><?php echo $_SESSION['name']; ?></h1>
    </div>
    </section>
<nav class="sidebar">
    <div class="sidebar-header">
    <img class="mb-4" src="logo.png" alt="logo" width="200">
    </div>
    <ul class="sidebar-menu">
    <li><a href="register.php?page=reg" class="register-button">Creare conturi </a></li><br>
    <li><a href="logout.php?page=out" class="logout-button">Deconectare </a></li><br>
    </ul>
</nav>
<div class="content">
    <?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        $allowed_pages = ['reg','out'];
        if (in_array($page, $allowed_pages) && file_exists($page . '.php')) {
            include($page . '.php');
        } else {
            echo '<p>Pagina nu a fost găsită.</p>';
        }
    } else {
        // Conținutul default al paginii principale
        echo '<h1>Bine ai venit pe secretariat UPT!</h1>';
    }
    ?>
</div>
</body>
</html>
<?php
}
else {
   header("Location: index.php");
   exit();
}

?>