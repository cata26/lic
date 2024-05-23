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
<link rel="stylesheet" href="css/style2.css">
</head>
<body>
<nav class="sidebar">
    <div class="sidebar-header">
    <img class="mb-4" src="logo.png" alt="logo" width="200">
    </div>
    <ul class="sidebar-menu">
        <li><a href="secretar.php?page=main"            class="main-button">Pagina principală</a></li><br>
        <li><a href="secretar.php?page=solicitari"      class="sol-button">Solicitări</a></li><br>
        <li><a href="secretar.php?page=doc_secretar"    class="doc-button">Documente</a></li><br>
        <li><a href="secretar.php?page=form_inc"        class="incarcare-button">Încarcare documente</a></li><br>
        <li><a href="secretar.php?page=lista_prog"      class="prog-button">Progrămari</a></li><br>
        <li><a href="secretar.php?page=anunturi"        class="anunuturi-button">Anunțuri</a></li><br>
        <li><a href="secretar.php?page=calendar"        class="calendar-button">Calendar</a></li><br>
        <li><a href="logout.php"                        class="logout-button">Deconectare </a><li>
    </ul>
    
</nav>
<div class="content">
    <?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        $allowed_pages = ['main','solicitari', 'doc_secretar','form_inc', 'lista_prog', 'anunturi', 'calendar'];
        if (in_array($page, $allowed_pages) && file_exists($page . '.php')) {
            include($page . '.php');
        } else {
            echo '<p>Pagina nu a fost găsită.</p>';
        }
    } else {
        // Conținutul default al paginii principale
        $page = 'main';
       
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