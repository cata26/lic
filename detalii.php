<?php

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizează Utilizator</title>
    <link rel="stylesheet" type="text/css" href="css/style16.css">
    <link rel="icon" href="upt.png" type="image/x-icon">
</head>
<body>
    <form action="detalii_update.php" method="post">
        <h2>Detalii student</h2>
        <?php 
        if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION['success'])) { ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php } ?>
        <div class="form-row">
            <div class="form-group">
                
                <input type="text" name="user_name" placeholder="Username" required>
                <input type="text" name="nota_admitere" placeholder="Nota Admitere" required>
                <input type="text" name="an_admitere" placeholder="An Admitere" >
                <input type="text" name="primul_an" placeholder="An 1" >
                <input type="text" name="primul_an_medie" placeholder="Medie primul an" >
                <input type="text" name="primul_an_credite" placeholder="Credite primul an" >
                <input type="text" name="an_2" placeholder="An 2" >
                <input type="text" name="an_2_medie" placeholder="Medie anul 2" >
            </div>
            <div class="form-group">
               
                <input type="text" name="an_2_credite" placeholder="Credite anul 2" >
                <input type="text" name="an_3" placeholder="An 3" >
                <input type="text" name="an_3_medie" placeholder="Medie anul 3" >
                <input type="text" name="an_3_credite" placeholder="Credite anul 3" >
                <input type="text" name="an_4" placeholder="An 4" >
                <input type="text" name="an_4_medie" placeholder="Media anul patru" >
                <input type="text" name="an_4_credite" placeholder="Credite anul patru" >
                <input type="text" name="an_5" placeholder="An 5" >
            </div>
            <div class="form-group">
                <input type="text" name="an_5_medie" placeholder="Medie anul 5" >
                <input type="text" name="an_5_credite" placeholder="Credite anul 5" >
                <input type="text" name="an_6" placeholder="An 6" >
                <input type="text" name="an_6_medie" placeholder="Medie anul 6" >
                <input type="text" name="an_6_credite" placeholder="Credite anul 6" >
                <input type="text" name="bursa" placeholder="Bursa" >
                <input type="text" name="nr_semestre_bursa" placeholder="Numar semestre bursa" >
            </div>
        </div>
        <button type="submit">Adaugă</button>
    </form>
</body>
</html>
<?php
} else {
   header("Location: index.php");
   exit();
}
?>