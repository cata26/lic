<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="css/style14.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Salut,Admin</h1>
            <p>Bine ai venit pe Secretariat UPT!</p>
        </div>
        <div class="profile-info box">
            <h2>Informații</h2>
            <p><strong>Admin</p>
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
                <a href="admin.php?page=register"     class="register-button"><i class="fas fa-user"></i> Creare conturi </a>
                <a href="admin.php?page=list_st"      class="list-button"><i class="fas fa-list"></i> Listă studenți</a>
                <a href="admin.php?page=detalii"             class="list-button"><i class="fas fa-clipboard"></i> Detalii studenți</a></li>
                <a href="logout.php"                  class="logout-button"><i class="fas fa-sign-out-alt"></i> Deconectare </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
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

