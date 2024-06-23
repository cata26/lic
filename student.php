<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="upt.png" type="image/x-icon">
    <title><?php echo $_SESSION['name']; ?></title>
    <link rel="stylesheet" href="css/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <nav class="sidebar">
        <div class="sidebar-header">
            <img class="mb-4" src="logo.png" alt="logo" width="200">
        </div>
        <ul class="sidebar-menu">
            <li><a href="student.php?page=main_st"        class="main-button"><i class="fas fa-home"></i> Pagina principală</a></li><br>
            <li><a href="student.php?page=adv"            class="sol-button"><i class="fas fa-clipboard"></i> Adeverință student</a></li><br>
            <li><a href="student.php?page=solicitari"     class="sol-button"><i class="fas fa-clipboard"></i> Solicitări</a></li><br>
            <li><a href="student.php?page=doc"            class="doc-button"><i class="fas fa-file"></i> Documente</a></li><br>
            <li><a href="student.php?page=prog"           class="prog-button"><i class="fas fa-calendar-check"></i> Progrămari</a></li><br>
            <li><a href="student.php?page=anunturi_stud"  class="anunuturi-button"><i class="fas fa-newspaper"></i> Anunțuri</a></li><br>
            <li><a href="student.php?page=raport"         class="raport-button"><i class="fas fa-clipboard"></i> Raportare probleme</a></li><br>
            <li><a href="student.php?page=status"         class="status-button"><i class="fas fa-check"></i> Status</a></li><br>
            <li><a href="logout.php"                      class="logout-button"><i class="fas fa-sign-out-alt"></i> Deconectare </a></li>
        </ul>
    </nav>

    <div class="user-navbar">    
        <label for="user_name" class="username">
        <?php echo $_SESSION['name']; ?>
        </label>
    </div>

    <div class="content">
        <?php
        $defaultPage = 'main_st'; 
        $page = isset($_GET['page']) ? $_GET['page'] : $defaultPage; 
        $allowed_pages = ['main_st', 'adv','solicitari', 'doc', 'prog', 'anunturi_stud', 'raport','status'];

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
} else {
   header("Location: index.php");
   exit();
}
?>
