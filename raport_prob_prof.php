<?php
session_start();
include "db_conn.php";

function reportProblem($conn, $username, $problema) {
    // Preluarea detaliilor studentului din baza de date
    $sql = "SELECT nr_matricol, name FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];

        // Salvarea programării în baza de date
        $sql = "INSERT INTO raport (name, problema) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $problema);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Problema a fost raportată cu succes.";
        } else {
            $_SESSION['error'] = "A apărut o eroare la raportarea problemei: " . $stmt->error;
        }

    } else {
        $_SESSION['error'] = "Nu s-au găsit detalii pentru utilizatorul specificat.";
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_name'])) {
        $username = $_SESSION['user_name'];
        $problema = $conn->real_escape_string($_POST['problema']);
        
        reportProblem($conn, $username, $problema);

        header("Location: profesor.php?page=raport_prof");
        exit();
    } else {
        $_SESSION['error'] = "Numele de utilizator nu este disponibil în sesiune.";
        header("Location: profesor.php?page=raport_prof");
        exit();
    }
}
?>
