<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Încărcare document de studiu</title>
    <link rel="stylesheet" href="css/style11.css">
</head>
<body>
    
    <form action="burse.php" method="post" enctype="multipart/form-data">
    <h2>Încărcare document de studiu</h2>
        <label for="document">Document PDF:</label>
        <input type="file" id="document" name="document" accept="application/pdf" required><br><br>
        
        <button type="submit">Încărcare</button>
    </form>
</body>
</html>
