<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Încărcare Document</title>
    <link rel="icon" href="upt.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style10.css">
</head>
<body>
    
    <form action="upload.php" method="post" enctype="multipart/form-data">
    <?php 
        if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION['success'])) { ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php } ?>
        <h1>Încărcare Document</h1>
        <label>Nume utilizator:</label>
        <input type="text" name="user_name" id="user_name" required><br>
        <label>Selectați documentul:</label>
        <input type="file" name="fileToUpload" id="fileToUpload" required><br><br>
        <button type="submit" value="Încarcă Document">Încarcă document</button>
    </form>

</body>
</html>
