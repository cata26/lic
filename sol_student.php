<?php
session_start();
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_name'])) {
        $username = $_SESSION['user_name'];

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

            // Preluarea datelor din formular
            $documment_type = $conn->real_escape_string($_POST['document_type']);


            $sql = "INSERT INTO solicitari (name,facultate, document_type) VALUES (?,?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss",$name, $facultate, $documment_type);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Solicitarea a fost salvată cu succes.";
            } else {
                $_SESSION['error'] = "A apărut o eroare la salvarea solicitării: " . $stmt->error;
            }

        } else {
            $_SESSION['error'] = "Nu s-au găsit detalii pentru utilizatorul specificat.";
        }
        header("Location: student.php?page=solicitari");
        exit();
        
    } else {
        $_SESSION['error'] = "Numele de utilizator nu este disponibil în sesiune.";
    }
}
?>
