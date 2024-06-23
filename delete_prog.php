<?php
include "db_conn.php";  
function deleteAppointment($conn, $data_programarii) {
    
    $sql = "DELETE FROM prog WHERE data_prog = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        return "Eroare la pregătirea interogării SQL: ";
    }
    
    $stmt->bind_param("s", $data_programarii);

    if ($stmt->execute()) {
        $stmt->close();
        return "Programarea a fost ștearsă cu succes.";
    } else {
        $error = "A apărut o eroare la ștergerea programării: " . $stmt->error;
        $stmt->close();
        return $error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_i'])) {
    $data_programarii = $_POST['delete_i'];
    $result = deleteAppointment($conn, $data_programarii);
    
    if (strpos($result, 'succes') !== false) {
        $_SESSION['success'] = $result;
    } else {
        $_SESSION['error'] = $result;
    }

    header("Location: secretar.php?page=lista_prog");
    exit();
}

?>
