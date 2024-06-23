<?php
session_start();
include "db_conn.php";

function uploadFile($user_name, $file) {
    $target_dir = "documents/" . basename($user_name) . "/";
    $fileName = basename($file['name']);
    $fileTmpName = $file['tmp_name'];
    $target_file = $target_dir . $fileName;

    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            return "Ne pare rău, nu s-a putut crea directorul pentru încărcare.";
        }
    }

    if (file_exists($target_file)) {
        return "Ne pare rău, fișierul există deja.";
    }

    if (move_uploaded_file($fileTmpName, $target_file)) {
        return "Fișierul " . htmlspecialchars($fileName) . " a fost încărcat cu succes.";
    } else {
        return "Ne pare rău, a fost o eroare la încărcarea fișierului tău.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = isset($_POST['user_name']) ? trim($_POST['user_name']) : null;
    $file = isset($_FILES['fileToUpload']) ? $_FILES['fileToUpload'] : null;

    if ($user_name && $file) {
        $result = uploadFile($user_name, $file);

        if (strpos($result, 'succes') !== false) {
            $_SESSION['success'] = $result;
        } else {
            $_SESSION['error'] = $result;
        }
        header("Location: secretar.php?page=form_inc");
        exit();
    } else {
        $_SESSION['error'] = "Numele utilizatorului și fișierul sunt necesare.";
        header("Location: secretar.php?page=form_inc");
        exit();
    }
}
?>
