
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

<?php
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Profesor</title>
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
            <p><strong>Profesor</p>
            <p><strong>Facultate:</strong> <?php echo htmlspecialchars($user['facultate']); ?></p>
        </div>
        <div class="columns">
            <div class="column box">
                <h2>Link-uri Utile</h2>
                <div class="link-container">
                    <a href="https://www.upt.ro">UPT</a>
                    <a href="https://ac.upt.ro/">AC</a>
                    <a href="https://etc.upt.ro/">ETTI</a>
                    <a href="http://www.arh.upt.ro/">Arhitectura</a>
                    <a href="https://cv.upt.ro/login/index.php">Campus Virtual</a>
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
                <a href="profesor.php?page=list_st_prof"        class="list-button"><i class="fas fa-list"></i> Listă studenți</a>
                <a href="profesor.php?page=solicitari_prof"     class="list-button"><i class="fas fa-clipboard"></i> Solicitari</a>
                <a href="student.php?page=doc_prof"             class="doc-button"><i class="fas fa-file"></i> Documente</a>
                <a href="profesor.php?page=anunturi"            class="anunuturi-button"><i class="fas fa-newspaper"></i> Anunțuri</a>
                <a href="profesor.php?page=raport_prof"          class="raport-button"><i class="fas fa-clipboard"></i> Raportare probleme</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
} else {
   header("Location: index.php");
   exit();
}
?>