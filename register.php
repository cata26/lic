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
                <label>Număr Matricol</label>
                <input type="text" name="nr_matricol" placeholder="Număr Matricol"><br>

                <label>Grad</label>
                <input type="text" name="rol" placeholder="rol"><br>

                <label>User Name*</label>
                <input type="text" name="uname" placeholder="User Name"><br>

                <label>Email*</label>
                <input type="email" name="email" placeholder="Email"><br>

                <label>Name*</label>
                <input type="text" name="name" placeholder="Name"><br>

                <label>Year</label>
                <input type="number" name="an" placeholder="An"><br>
            </div>

            <div class="form-group">
                <label>Facultate</label>
                <input type="text" name="facultate" placeholder="Facultate"><br>

                <label>Secția</label>
                <input type="text" name="sectia" placeholder="Secția"><br>

                <label>Tip învățământ</label>
                <input type="text" name="tip_invatamant" placeholder="Tip învățământ"><br>

                <label>Localitate domiciu</label>
                <input type="text" name="localitate_dom" placeholder="localitate"><br>

                <label>Judet domiciu</label>
                <input type="text" name="judet_dom" placeholder="judet"><br>

                <label>Data nasterii</label>
                <input type="text" name="data_nasterii" placeholder="Data nasterii"><br>

                <label>Parola*</label>
                <input type="password" name="parola" placeholder="parola"><br>

                
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