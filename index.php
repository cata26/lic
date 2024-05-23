<!DOCTYPE html>
<html>
<head>
    <title>Autentificare Secretariat UPT</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="upt.png" type="image/x-icon">
</head>

<body>
<img class="mb-4" src="loginlogo.png" alt="logo" width="700">
    <form action="login.php" method="post">
        <h2>Autentificare</h2>
        <?php if(isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password"><br>
        <button type="submit">Conectare</button><br><br>
        <a href="forgot.php">Ai uitat parola?</a>
    </form>
    <p class="mt-5 mb-3 text-muted">Universitatea Politehnica Timișoara | 2024</p>
</body>
</html>

