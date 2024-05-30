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
    <title>Student</title>
    <link rel="stylesheet" href="css/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <nav class="sidebar">
        <div class="sidebar-header">
            <img class="mb-4" src="logo.png" alt="logo" width="200">
        </div>
        <ul class="sidebar-menu">
            <li><a href="student.php?page=main" class="main-button"><i class="fas fa-home"></i> Pagina principală</a></li><br>
            <li><a href="student.php?page=solicitari" class="sol-button"><i class="fas fa-clipboard"></i> Solicitări</a></li><br>
            <li><a href="student.php?page=doc" class="doc-button"><i class="fas fa-file"></i> Documente</a></li><br>
            <li><a href="student.php?page=prog" class="prog-button"><i class="fas fa-calendar-check"></i> Progrămari</a></li><br>
            <li><a href="student.php?page=upload_burse" class="burse-button"><i class="fas fa-file"></i> Burse sociale</a></li><br>
            <li><a href="student.php?page=anunturi_stud" class="anunuturi-button"><i class="fas fa-newspaper"></i> Anunțuri</a></li><br>
            <li><a href="logout.php" class="logout-button"><i class="fas fa-sign-out-alt"></i> Deconectare </a></li>
        </ul>
    </nav>

    <div class="user-navbar">
        <input type="checkbox" id="toggle-dropdown" class="toggle-dropdown">
        <label for="toggle-dropdown" class="username">
            <?php echo $_SESSION['name']; ?> <i class="fas fa-angle-down"></i>
        </label>
        <div class="dropdown-content">
            <a href="#">Profil</a>
            <a href="#">Note</a>
            <a href="#">Calendar</a>
            <a href="#">Mesaje</a>
            <a href="#">Fișiere private</a>
            <a href="#">Rapoarte</a>
            <a href="#">Preferințe</a>
            <a href="logout.php">Delogare</a>
        </div>
    </div>

    <div class="content">
        <?php
        $defaultPage = 'main'; 
        $page = isset($_GET['page']) ? $_GET['page'] : $defaultPage; 
        $allowed_pages = ['main', 'solicitari', 'doc', 'prog', 'upload_burse', 'anunturi_stud', 'calendar'];

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
