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
                <label>Username</label>
                <input type="text" name="user_name" required>
                <label>Nota Admitere</label>
                <input type="text" name="nota_admitere" placeholder="Nota Admitere" required>
                <label>An Admitere</label>
                <input type="text" name="an_admitere" placeholder="An Admitere" >
                <label>An 1</label>
                <input type="text" name="primul_an" placeholder="An 1" >
                <label>An 1 Medie</label>
                <input type="text" name="primul_an_medie" placeholder="An 1 Medie" >
                <label>An 1 Credite</label>
                <input type="text" name="primul_an_credite" placeholder="An 1 Credite" >
                <label>An 2</label>
                <input type="text" name="an_2" placeholder="An 2" >
                <label>An 2 Medie</label>
                <input type="text" name="an_2_medie" placeholder="An 2 Medie" >
            </div>
            <div class="form-group">
               
                <label>An 2 Credite</label>
                <input type="text" name="an_2_credite" placeholder="An 2 Credite" >
                <label>An 3</label>
                <input type="text" name="an_3" placeholder="An 3" >
                <label>An 3 Medie</label>
                <input type="text" name="an_3_medie" placeholder="An 3 Medie" >
                <label>An 3 Credite</label>
                <input type="text" name="an_3_credite" placeholder="An 3 Credite" >
                <label>An 4</label>
                <input type="text" name="an_4" placeholder="An 4" >
                <label>An 4 Medie</label>
                <input type="text" name="an_4_medie" placeholder="An 4 Medie" >
                <label>An 4 Credite</label>
                <input type="text" name="an_4_credite" placeholder="An 4 Credite" >
                <label>An 5</label>
                <input type="text" name="an_5" placeholder="An 5" >
            </div>
            <div class="form-group">
                <label>An 5 Medie</label>
                <input type="text" name="an_5_medie" placeholder="An 5 Medie" >
                <label>An 5 Credite</label>
                <input type="text" name="an_5_credite" placeholder="An 5 Credite" >
                <label>An 6</label>
                <input type="text" name="an_6" placeholder="An 6" >
                <label>An 6 Medie</label>
                <input type="text" name="an_6_medie" placeholder="An 6 Medie" >
                <label>An 6 Credite</label>
                <input type="text" name="an_6_credite" placeholder="An 6 Credite" >
                <label>Bursa</label>
                <input type="text" name="bursa" placeholder="Bursa" >
                <label>Numar semestre bursa</label>
                <input type="text" name="nr_semestre_bursa" placeholder="Numar semestre bursa" >
            </div>
        </div>
        <button type="submit">Adaugă</button>
    </form>
</body>
</html>