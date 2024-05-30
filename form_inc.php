<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Încărcare Document</title>
    <link rel="icon" href="upt.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style10.css">
</head>
<body>
    
    <form id="myForm" action = "upload.php" method="post">
    <h1>Încărcare Document</h1>
        <label for="nr_matricol">Număr Matricol:</label>
        <input type="text" name="nr_matricol" id="nr_matricol" required><br>

        <label for="fileToUpload">Selectați documentul:</label>
        <input type="file" name="fileToUpload" id="fileToUpload" required><br><br>

        <div id="errorMessage" style="color: red;"></div>

        <input type="button" value="Încarcă Document" onclick="uploadDocument()">
    </form>

    <script>
        function uploadDocument() {
            var form = document.getElementById("myForm");
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "upload.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Răspunsul este OK, afișăm mesajul de succes
                document.getElementById("errorMessage").innerText = "Documentul a fost încarcat cu succes!";
                
                // Mesajul va dispărea după 3 secunde
                setTimeout(function() {
                    document.getElementById("errorMessage").innerText = "";
                }, 3000);
                
                form.reset();
            } else {
                // A apărut o eroare în timpul trimiterii cererii
                document.getElementById("errorMessage").innerText = "A apărut o eroare în timpul încarcarii documentului. Vă rugăm să încercați din nou mai târziu.";
                
                // Mesajul va dispărea după 3 secunde
                setTimeout(function() {
                    document.getElementById("errorMessage").innerText = "";
                }, 3000);
            }
        }
    };
    xhr.send(formData);
}
    </script>
</body>
</html>