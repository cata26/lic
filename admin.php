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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/friconix@2.4.0/css/friconix.min.css">
    </head>
    <body>
        
    <div class="user-navbar">
        <input type="checkbox" id="toggle-dropdown" class="toggle-dropdown">
        <label for="toggle-dropdown" class="username">
            <?php echo $_SESSION['name']; ?> <i class="fas fa-angle-down"></i>
        </label>
        <div class="dropdown-content">
            <a href="#"><i class="fa fa-user" aria-hidden="true"></i> Profil</a>
            <a href="forgot.php"><i class="fa fa-key" aria-hidden="true"></i> Resetarea parolei</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Delogare</a>
        </div>
    </div>


<div class="content">
    <?php
    $defaultPage = 'main'; 
    $page = isset($_GET['page']) ? $_GET['page'] : $defaultPage; 
    $allowed_pages = ['main', 'register', 'list_st'];

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