<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Eliberare documente</title>
    <link rel="icon" href="upt.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style10.css">
</head>
<body>



<form action="generate_pdf.php" method="post">
    <h1>Eliberare documente</h1>
    <?php 
        if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION['success'])) { ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php } ?>
    <p>Număr matricol:</p>
    <input type="text" name="nr_matricol" id="nr_matricol" required>
    <p>Vă rugăm să alegeți documentul pe care doriți să-l primiți:</p>
    <select name="document_type" id="document_type" required>
        <option value="">Alegeti document</option>
        <option value="Adeverinta">Adeverință student</option>
    </select>
    
    <p>Motivul solicitării documentului:</p>
    <select name="document_reason" id="document_reason" required>
        <option value="">Alegeti motivul din lista</option>
        <option value="locul de munca">Locul de muncă</option>
        <option value="angajare">Angajare</option>
        <option value="asigurare de sanatate">Asigurare de sanatate</option>
        <option value="banca">Banca</option>
    </select>
    <br><br>

    <button type="submit">Trimite</button>
</form>

</body>
</html>
