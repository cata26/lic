<?php

include "db_conn.php";

if (isset($_SESSION['user_name'])) {
    $username = $_SESSION['user_name'];

    $sql = "SELECT nr_matricol, name, an, facultate, sectia, tip_invatamant FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
 

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $name = $user['name'];
        $nameParts = explode(" ", $name);
        $prenume = end($nameParts);
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
    <title>Dashboard Student</title>
    <link rel="stylesheet" href="css/style14.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Salut,<?php echo htmlspecialchars($prenume); ?></h1>
            <p>Bine ai venit pe Secretariat UPT!</p>
        </div>
        <div class="profile-info box">
            <h2>Informații Student</h2>
            <p><strong>Număr matricol:<?php echo htmlspecialchars($user['nr_matricol']); ?></p>
            <p><strong>Facultate:</strong> <?php echo htmlspecialchars($user['facultate']); ?></p>
            <p><strong>Secția:</strong> <?php echo htmlspecialchars($user['sectia']); ?></p>
            <p><strong>Anul </strong> <?php echo htmlspecialchars($user['an']); ?></p>
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
                <a href="student.php?page=adv"           class="sol-button"><i class="fas fa-clipboard"></i> Adeverință student</a>
                <a href="student.php?page=doc"           class="doc-button"><i class="fas fa-file"></i> Documente</a>
                <a href="student.php?page=prog"          class="prog-button"><i class="fas fa-calendar-check"></i> Progrămari</a>
                <a href="student.php?page=anunturi_stud" class="anunuturi-button"><i class="fas fa-newspaper"></i> Anunțuri</a>
                <a href="student.php?page=raport"        class="anunuturi-button"><i class="fas fa-clipboard"></i> Raportare problemă</a>
                <a href="student.php?page=status"         class="status-button"><i class="fas fa-check"></i> Status</a>
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