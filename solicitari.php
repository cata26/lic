<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="form-container">
        <h1>Eliberare documente</h1>
        <form>
            <label for="document">Vă rugăm să alegeți documentul pe care doriți să-l primiți:</label>
            <select name="document" id="document">
                <option value="">Alegeti document</option>
                <option value="document1">Adeverinta student</option>
                <option value="document2">Foaie matricola</option>
                <!-- Adăugați alte opțiuni aici -->
            </select>
            <br>
            <br>
            <label for="necesitate">Motivul solicitarii documentului:</label>
            <select name="necesitate" id="necesitate">
                <option value="">Alegeti motivul din lista</option>
                <option value="n1">Locul de munca</option>
                <option value="n2">Asigurare de sanatate</option>
                <option value="n2">Banca</option>
                <!-- Adăugați alte opțiuni aici -->
            </select>
            <br>
            <br>
            <button type="submit" class="btn">Trimite</button>
        </form>
    </div>

</body>
</html>
