<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Eliberare documente</title>
</head>
<body>

<form action="generate_pdf.php" method="post">
    <h1>Eliberare documente</h1>
    <p>Vă rugăm să alegeți documentul pe care doriți să-l primiți:</p>
    <select name="document_type">
        <option value="adeverinta_student">Adeverință student</option>
        <option value="adeverinta_student">Foaie matricola</option>
        <!-- Alte opțiuni pot fi adăugate aici -->
    </select>
    
    <p>Motivul solicitării documentului:</p>
    <select name="document_reason">
        <option value="locul_de_munca">Locul de muncă</option>
        <option value="asigurare_de_sanatate">Asigurare de sanatate</option>
        <option value="banca">Banca</option>
        <!-- Alte motive pot fi adăugate aici -->
    </select>
    <br><br>

    <input type="submit" value="Trimite">
</form>

</body>
</html>
