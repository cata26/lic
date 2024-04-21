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
<title>Secretar</title>
<link rel="stylesheet" href="style2.css">
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
        <li><a href="secretar.php?page=main"      class="main-button">Pagina principală</a></li><br>
        <li><a href="secretar.php?page=solicitari" class="sol-button">Solicitări</a></li><br>
        <li><a href="secretar.php?page=doc"       class="doc-button">Documente</a></li><br>
        <li><a href="secretar.php?page=prog"      class="prog-button">Progrămari</a></li><br>
        <li><a href="secretar.php?page=anunturi"  class="anunuturi-button">Anunțuri</a></li><br>
        <li><a href="secretar.php?page=calendar" class="calendar-button">Calendar</a></li><br>
        <li><a href="logout.php"                 class="logout-button">Deconectare </a><li>
    </ul>
    
</nav>
<div class="content">
    <?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        $allowed_pages = ['main','solicitari', 'doc', 'prog', 'anunturi', 'calendar'];
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