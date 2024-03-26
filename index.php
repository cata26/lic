<!DOCTYPE html>
<html>
<head>
    <title>Autentificare Secretariat UPT</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="upt.png" type="image/x-icon">
</head>

<body>
    <form action="login.php" method="post">
    <img class="mb-4" src="upt.png" alt="logo" width="200">
        <h2>Autentificare</h2>
        <?php if(isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <label>Email</label>
        <input type="text" name="email" placeholder="Email"><br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Password"><br>
        <button type="submit">Login</button>
    </form>
    <p class="mt-5 mb-3 text-muted">Universitatea Politehnica Timișoara | 2024</p>
</body>
</html>
