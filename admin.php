<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    ?>
    <!DOCTYPE html>
    <html> 
    <head>
        <title>Admin</title>
        <link rel="icon" href="upt.png" type="image/x-icon">
        <link rel="stylesheet" type ="text/css" href="css/style2.css">
    </head>
    <body>
<nav class="sidebar">
    <div class="sidebar-header">
    <img class="mb-4" src="logo.png" alt="logo" width="200">
    </div>
    <ul class="sidebar-menu">
    <li><a href="admin.php?page=main"         class="main-button">Pagina principală</a></li><br>    
    <li><a href="admin.php?page=register"     class="register-button">Creare conturi </a></li><br>
    <li><a href="admin.php?page=act"          class="act-button">Actualizare conturi </a></li><br>
    <li><a href="admin.php?page=delete"       class="delete-button">Ștergere conturi</a></li><br>
    <li><a href="logout.php"                  class="logout-button">Deconectare </a><li>
    </ul>
</nav>

<div class="content">
    <?php
    $defaultPage = 'main'; 
    $page = isset($_GET['page']) ? $_GET['page'] : $defaultPage; 
    $allowed_pages = ['main', 'register', 'act', 'delete'];

    if (in_array($page, $allowed_pages) && file_exists($page . '.php')) {
        include($page . '.php');
    } else {
        echo '<p>Pagina nu a fost găsită.</p>';
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