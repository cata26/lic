<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Eliberare documente</title>
    <link rel="icon" href="upt.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style10.css">
</head>
<body>

<form action="raport_prob_prof.php" method="post">
    <h1>Raportare probleme</h1>
    <?php 
        if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION['success'])) { ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php } ?>
    <p>Decrieți problema:</p>
    <input type="text" name="problema" id="problema" required>
    
    <button type="submit">Trimite</button>
</form>

</body>
</html>