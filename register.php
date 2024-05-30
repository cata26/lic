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

                <label>User Name*</label>
                <input type="text" name="uname" placeholder="User Name"><br>

                <label>Email*</label>
                <input type="email" name="email" placeholder="Email"><br>

                <label>Name*</label>
                <input type="text" name="name" placeholder="Name"><br>

                <label>Year</label>
                <input type="number" name="year" placeholder="Year"><br>
            </div>

            <div class="form-group">
                <label>Facultate</label>
                <input type="text" name="facultate" placeholder="Facultate"><br>

                <label>Secția</label>
                <input type="text" name="sectia" placeholder="Secția"><br>

                <label>Tip învățământ</label>
                <input type="text" name="tip_invatamant" placeholder="Tip învățământ"><br>

                <label>Password*</label>
                <input type="password" name="password" placeholder="Password"><br>
            </div>
        </div> 

        <button type="submit">Sign Up</button>
    </form>
</body>
</html>
