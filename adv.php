<?php

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Eliberare adeverințe</title>
    <link rel="icon" href="upt.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style10.css">
</head>
<body>

<form action="generate_pdf.php" method="post">
    <h1>Adeverință student</h1>
    <?php 
        if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION['success'])) { ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php } ?>
    
    <p>Motivul solicitării documentului:</p>
    <select name="document_reason" id="document_reason" required>
        <option value="">Alegeti motivul din lista</option>
        <option value="locul de munca">locul de muncă</option>
        <option value="angajare">angajare</option>
        <option value="asigurare de sanatate">asigurare de sanatate</option>
        <option value="banca">banca</option>
        <option value="alta facultate">alta facultate</option>
        <option value="alocatie europeana">alocatie europeana</option>
        <option value="text">alt motiv...</option>
    </select>
    <textarea name="alt_motiv" id="alt_motiv" placeholder="Scrieți motivul aici"></textarea>
    <br><br>
    
    <button type="submit">Trimite</button>
</form>
</body>
</html>
<?php
} else {
   header("Location: index.php");
   exit();
}
?>