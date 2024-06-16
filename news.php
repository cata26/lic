<!DOCTYPE html>
    <html lang="ro">
    <head>
        <meta charset="UTF-8">
        <title>Publică Anunț</title>
        <link rel="stylesheet" href="css/style10.css">
    </head>
    <body>
    
        <form action="anunturi_sec.php" method="post">
        <?php 
        if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION['success'])) { ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php } ?>  
        <h2>Publică Anunț</h2>
            <label for="title">Titlu:</label>
            <input type="text" id="title" name="title" required><br><br>
            <label for="content">Conținut:</label>
            <textarea id="content" name="content" required></textarea><br><br>
            <button type="submit">Publică</button>
        </form>
    </body>
    </html>

