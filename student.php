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
</head>
<body>
<nav class="sidebar">
    <div class="sidebar-header">
    <img class="mb-4" src="logo.png" alt="logo" width="200">
    </div>
    <ul class="sidebar-menu">
        <li><a href="student.php?page=main"       class="main-button">Pagina principală</a></li><br>
        <li><a href="student.php?page=solicitari" class="sol-button">Solicitări</a></li><br>
        <li><a href="student.php?page=doc"        class="doc-button">Documente</a></li><br>
        <li><a href="student.php?page=prog"       class="prog-button">Progrămari</a></li><br>
        <li><a href="student.php?page=anunturi"   class="anunuturi-button">Anunțuri</a></li><br>
        <li><a href="student.php?page=calendar"   class="calendar-button">Calendar</a></li><br>
        <li><a href="logout.php"                  class="logout-button">Deconectare </a><li>
    </ul>
    
</nav>
<div class="content">
    <?php
    $defaultPage = 'main'; 
    $page = isset($_GET['page']) ? $_GET['page'] : $defaultPage; 
    $allowed_pages = ['main', 'solicitari', 'doc', 'prog', 'anunturi', 'calendar'];

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