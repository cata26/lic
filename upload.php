<?php
session_start();
include "db_conn.php";

function uploadFile($user_name, $file) {
    $target_dir = "documents/" . $user_name . "/";
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $target_file = $target_dir . basename($fileName);

    // Creează directorul dacă nu există
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Verifică dacă fișierul există deja
    if (file_exists($target_file)) {
        return "Ne pare rău, fișierul există deja.";
    }

    // Încearcă să încarce fișierul
    if (move_uploaded_file($fileTmpName, $target_file)) {
        return "Fișierul " . htmlspecialchars($fileName) . " a fost încărcat.";
    } else {
        return "Ne pare rău, a fost o eroare la încărcarea fișierului tău.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : null;
    $file = isset($_FILES['fileToUpload']) ? $_FILES['fileToUpload'] : null;

    if ($user_name && $file) {
        $message = uploadFile($user_name, $file);
        $_SESSION['message'] = $message;
        header("Location: upload.php");
        exit();
    } else {
        $_SESSION['error'] = "Numărul matricol și fișierul sunt necesare.";
        header("Location: upload.php");
        exit();
    }
}
?>