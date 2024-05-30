<?php
session_start();
include "db_conn.php";  // Include scriptul de conectare la baza de date

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $nr_matricol = $_POST['delete_id'];

    // Pregătește declarația SQL pentru a preveni SQL injection
    $sql = "DELETE FROM prog WHERE nr_matricol = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Eroare la pregătirea interogării SQL: " . $conn->error);
    }
    
    $stmt->bind_param("s", $nr_matricol);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Programarea a fost șters cu succes.";
    } else {
        $_SESSION['error'] = "A apărut o eroare la ștergerea programării: " . $stmt->error;
    }

    $stmt->close();
}

header("Location: secretar.php?page=list_prog");
exit();
?>
