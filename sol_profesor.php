<?php
session_start();
include "db_conn.php";

function saveSolicitare($conn, $username, $document_type) {
    // Preluarea detaliilor studentului din baza de date
    $sql = "SELECT name, facultate FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $facultate = $row['facultate'];

        // Curățare date
        $document_type = $conn->real_escape_string($document_type);

        // Salvarea solicitării în baza de date
        $sql = "INSERT INTO solicitari (name, facultate, document_type) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $facultate, $document_type);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Solicitarea a fost salvată cu succes.";
        } else {
            $_SESSION['error'] = "A apărut o eroare la salvarea solicitării: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Nu s-au găsit detalii pentru utilizatorul specificat.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_name'])) {
    $username = $_SESSION['user_name'];
    $document_type = $_POST['document_type'];

    saveSolicitare($conn, $username, $document_type);
    header("Location: profesor.php?page=solicitari_prof");
    exit();
} else {
    $_SESSION['error'] = "Numele de utilizator nu este disponibil în sesiune.";
    header("Location: profesor.php?page=solicitari_prof");
    exit();
}
?>
