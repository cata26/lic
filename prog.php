<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Formular Programare</title>
    <link rel="stylesheet" href="css/style7.css"> 
</head>
<body>
    <form action="submit_appointment.php" method="post">
        <h1>Programare</h1><br>
        <?php 
        if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION['success'])) { ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php } ?>

        <label for="data_programarii">Data programării*</label>
        <input type="date" id="data_programarii" name="data_programarii" required><br>
        <label for="ora_programarii">Ora programării*</label>
        <select id="ora_programarii" name="ora_programarii" required>
            <option value="10:00">10:00</option>
            <option value="10:30">10:30</option>
            <option value="11:00">11:00</option>
            <option value="11:30">11:30</option>
            <option value="12:30">12:30</option>
            <option value="13:00">13:00</option>
            <option value="13:30">13:30</option>
            <option value="14:00">14:00</option>
            <!-- Adaugă alte opțiuni după necesități -->
        </select><br>

        <input type="submit" value="Trimite">
    </form>
</body>
</html>
