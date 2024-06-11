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
            <?php echo $_SESSION['name']; ?>
        </label>
        <!--<div class="dropdown-content">
            <a href="#"><i class="fa fa-user" aria-hidden="true"></i> Profil</a>
            <a href="forgot.php"><i class="fa fa-key" aria-hidden="true"></i> Resetarea parolei</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Delogare</a>
        </div>-->
    </div>

 <nav class="sidebar">
    <div class="sidebar-header">
    <img class="mb-4" src="logo.png" alt="logo" width="200">
    </div>
    <ul class="sidebar-menu">
    <li><a href="admin.php?page=main_admin"          class="main-button"><i class="fas fa-home"></i> Pagina principală</a></li><br>    
    <li><a href="admin.php?page=register"            class="register-button"><i class="fas fa-user"></i> Creare conturi </a></li><br>
    <li><a href="admin.php?page=list_st"             class="list-button"><i class="fas fa-list"></i> Listă studenți</a></li><br>
    <li><a href="admin.php?page=det_suplimentare"   class="list-button"><i class="fas fa-clipboard"></i> Detalii studenți</a></li><br>
    <li><a href="logout.php"                         class="logout-button"><i class="fas fa-sign-out-alt"></i> Deconectare </a><li>
    </ul>
</nav>

<div class="content">
    <?php
    $defaultPage = 'main_admin'; 
    $page = isset($_GET['page']) ? $_GET['page'] : $defaultPage; 
    $allowed_pages = ['main_admin', 'register', 'list_st','det_suplimentare'];

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