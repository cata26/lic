<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Eliberare documente</title>
    <link rel="icon" href="upt.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style7.css">
</head>
<body>

<form id="myForm" action="generate_pdf.php" method="post">
    <h1>Eliberare documente</h1>
    <p>Număr matricol:</p>
    <input type="text" name="nr_matricol" id="nr_matricol">
    <p>Vă rugăm să alegeți documentul pe care doriți să-l primiți:</p>
    <select name="document_type" id="document_type">
        <option value="">Alegeti document</option>
        <option value="Adeverinta">Adeverință student</option>
        <option value="foaie_matricola">Foaie matricola</option>
    </select>
    
    <p>Motivul solicitării documentului:</p>
    <select name="document_reason" id="document_reason">
        <option value="">Alegeti motivul din lista</option>
        <option value="locul de munca">Locul de muncă</option>
        <option value="angajare">Angajare</option>
        <option value="asigurare de sanatate">Asigurare de sanatate</option>
        <option value="banca">Banca</option>
    </select>
    <br><br>

  
    <div id="errorMessage" style="color: red;"></div>

    <input type="button" value="Trimite" onclick="submitForm()">
</form>

<script>
function submitForm() {
    var form = document.getElementById("myForm");
    var formData = new FormData(form);

    var nrMatricol = document.getElementById("nr_matricol").value;
    var documentType = document.getElementById("document_type").value;
    var documentReason = document.getElementById("document_reason").value;
    
    if (nrMatricol === "" || documentType === "" || documentReason === "") {
    
        document.getElementById("errorMessage").innerText = "Vă rugăm să completați toate câmpurile obligatorii!";
        
     
        setTimeout(function() {
            document.getElementById("errorMessage").innerText = "";
        }, 3000);
        
        return; 
    }
    
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "generate_pdf.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
        
                document.getElementById("errorMessage").innerText = "Cererea a fost trimisă cu succes!";
                
                setTimeout(function() {
                    document.getElementById("errorMessage").innerText = "";
                }, 3000);
                
                form.reset();
            } else {
                
                document.getElementById("errorMessage").innerText = "A apărut o eroare în timpul trimiterii cererii. Vă rugăm să încercați din nou mai târziu.";
                
                
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