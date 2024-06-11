<?php
session_start();
include "db_conn.php";  // Include scriptul de conectare la baza de date

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_i'])) {
    $data_programarii = $_POST['delete_i'];

    // Pregătește declarația SQL pentru a preveni SQL injection
    $sql = "DELETE FROM prog WHERE data_prog = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Eroare la pregătirea interogării SQL: " . $conn->error);
    }
    
    $stmt->bind_param("s", $data_programarii);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Programarea a fost șters cu succes.";
    } else {
        $_SESSION['error'] = "A apărut o eroare la ștergerea programării: " . $stmt->error;
    }

    $stmt->close();
}

header("Location: secretar.php?page=lista_prog");
exit();
?>
