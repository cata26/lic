<?php

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Solicitări</title>
    <link rel="icon" href="upt.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style10.css">
</head>
<body>

<form action="sol_profesor.php" method="post">
    <h1>Solicitări</h1>
    <?php 
        if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION['success'])) { ?> 
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php } ?>
    
    <p>Tipul documentului:</p>
    <input type="text" name="document_type" id="document_type" required>
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