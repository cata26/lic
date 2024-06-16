
<?php

include "db_conn.php";

if (isset($_SESSION['user_name'])) {
    $username = $_SESSION['user_name'];

    $sql = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Utilizatorul nu a fost găsit.";
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Secretar</title>
    <link rel="stylesheet" href="css/style14.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Salut,<?php echo htmlspecialchars($user['name']); ?></h1>
            <p>Bine ai venit pe Secretariat UPT!</p>
        </div>
        <div class="profile-info box">
            <h2>Informații</h2>
            <p><strong>Secretar</p>
            <p><strong>Facultate:</strong> <?php echo htmlspecialchars($user['facultate']); ?></p>
        </div>
        <div class="columns">
            <div class="column box">
                <h2>Link-uri Utile</h2>
                <div class="link-container">
                    <a href="https://www.upt.ro">UPT</a>
                    <a href="https://facultate.upt.ro">Facultate</a>
                    <a href="https://campusvirtual.upt.ro">Campus Virtual</a>
                    <a href="https://practica.upt.ro">Practica</a>
                    <a href="https://ccoc.upt.ro">CCOC</a>
                    <a href="https://rezervari.upt.ro">Rezervări</a>
                    <a href="https://cospol.upt.ro">Cospol</a>
                    <a href="https://student.upt.ro/">Student UPT</a>
                </div>
            </div>
            <div class="column box">
                <h2>Servicii</h2>
                <div class="service-container">
                <a href="secretar.php?page=solicitari"      class="sol-button"><i class="fas fa-clipboard"></i> Solicitări</a>
                <a href="secretar.php?page=doc_secretar"    class="doc-button"><i class="fas fa-file"></i> Documente</a>
                <a href="secretar.php?page=form_inc"        class="incarcare-button"><i class="fas fa-upload"></i> Încarcare documente</a>
                <a href="secretar.php?page=list_st_prof"         class="list-button"><i class="fas fa-list"></i> Listă studenți</a>
                <a href="secretar.php?page=lista_prog"      class="prog-button"><i class="fas fa-calendar-check"></i> Progrămari</a>
                <a href="secretar.php?page=news"            class="anunuturi-button"><i class="fas fa-newspaper"></i> Anunțuri</a>
                <a href="secretar.php?page=rec"             class="view-button"><i class="fas fa-clipboard"></i> Reclamații</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
