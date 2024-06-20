<?php
session_start();
include "db_conn.php";  

function deleteUser($conn, $nr_matricol) {
    
    $sql = "DELETE FROM users WHERE nr_matricol = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nr_matricol);

    if ($stmt->execute()) {
        $stmt->close();
        return "Utilizatorul a fost șters cu succes.";
    } else {
        return "A apărut o eroare la ștergerea utilizatorului. ";
        
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
