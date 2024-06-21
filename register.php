<?php

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Înregistrare</title>
    <link rel="stylesheet" type="text/css" href="css/style10.css">
</head>
<body>
    <form action="register_check.php" method="post">
        <h2>Înregistrare</h2>
        <?php 
        if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION['success'])) { ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php } ?>
        
        <div class="form-row">
            <div class="form-group">
                <input type="text" name="nr_matricol" placeholder="Număr Matricol" required><br>

                <select type="text" name="rol" placeholder="Rol*" required>
                <option value="">Alegeti rolul</option>
                <option value="admin">Admin</option>
                <option value="secretar">Secretar</option>
                <option value="profesor">Profesor</option>
                <option value="student">Student</option>
                </select>

                <input type="text" name="uname" placeholder="Nume de utilizator" required><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="text" name="name" placeholder="Name" required><br>
                <input type="text" name="an" placeholder="An"><br>

                
            </div>

            <div class="form-group">
                
                 <input type="text" name="facultate" placeholder="Facultate"><br>
                 <input type="text" name="sectia" placeholder="Secția"><br>
                 <input type="text" name="tip_invatamant" placeholder="Tip învățământ"><br>
                 <input type="text" name="localitate_dom" placeholder="Localitate"><br>
                 <input type="text" name="judet_dom" placeholder="Județ">
                 <imput type="date" name="data_nasterii" placeholder="Data nașterii">
                 <input type="password" name="parola" placeholder="Parola" required><br>

                
            </div>


        </div> 

        <button type="submit">Sign Up</button>
    </form>
</body>
</html>

<?php
} else {
   header("Location: index.php");
   exit();
}
?>