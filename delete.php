<?php
session_start();
include "db_conn.php";  // Include scriptul de conectare la baza de date

function deleteUser($conn, $nr_matricol) {
    // Pregătește declarația SQL pentru a preveni SQL injection
    $sql = "DELETE FROM users WHERE nr_matricol = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        return "Eroare la pregătirea interogării SQL: " . $conn->error;
    }
    
    $stmt->bind_param("s", $nr_matricol);

    if ($stmt->execute()) {
        $stmt->close();
        return "Utilizatorul a fost șters cu succes.";
    } else {
        $error = "A apărut o eroare la ștergerea utilizatorului: " . $stmt->error;
        $stmt->close();
        return $error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $nr_matricol = $_POST['delete_id'];
    $result = deleteUser($conn, $nr_matricol);
    
    if (strpos($result, 'succes') !== false) {
        $_SESSION['success'] = $result;
    } else {
        $_SESSION['error'] = $result;
    }

    header("Location: admin.php?page=list_st");
    exit();
}
?>
