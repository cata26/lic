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

<div class="user-navbar">
        <input type="checkbox" id="toggle-dropdown" class="toggle-dropdown">
        <label for="toggle-dropdown" class="username">
            <?php echo $_SESSION['name']; ?>
        </label>
</div>

<nav class="sidebar">
    <div class="sidebar-header">
    <img class="mb-4" src="logo.png" alt="logo" width="200">
    </div>
    <ul class="sidebar-menu">
        <li><a href="profesor.php?page=main_profesor"        class="main-button"><i class="fas fa-home"></i> Pagina principală</a></li><br>
        <li><a href="profesor.php?page=list_st_prof"         class="list-button"><i class="fas fa-list"></i> Listă studenți</a></li><br>
        <li><a href="profesor.php?page=solicitari_prof"      class="list-button"><i class="fas fa-clipboard"></i> Solicitari</a></li><br>
        <li><a href="profesor.php?page=doc_prof"             class="doc-button"><i class="fas fa-file"></i> Documente</a></li><br>
        <li><a href="profesor.php?page=anunturi_prof"        class="anunuturi-button"><i class="fas fa-newspaper"></i> Anunțuri</a></li><br>
        <li><a href="profesor.php?page=raport_prof"          class="raport-button"><i class="fas fa-clipboard"></i> Raportare probleme</a></li><br>
        <li><a href="logout.php"                             class="logout-button"><i class="fas fa-sign-out-alt"></i> Deconectare </a><li>
    </ul>
    
</nav>
<div class="content">
<?php
    $defaultPage = 'main_profesor'; 
    $page = isset($_GET['page']) ? $_GET['page'] : $defaultPage; 
    $allowed_pages = ['main_profesor','doc_prof','solicitari_prof','list_st_prof', 'anunturi_prof','raport_prof', 'calendar'];

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
