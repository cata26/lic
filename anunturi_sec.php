<?php

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
include "db_conn.php"; 

function addAnunt($conn, $title, $content) {
    $sql = "INSERT INTO news (title, content) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $content);
    if (!$stmt) {
        return "Eroare la pregătirea declarației: " . $conn->error;
    }

    if ($stmt->execute()) {
        return "Anunțul a fost publicat cu succes!";
    } else {
        return "Eroare la publicarea anunțului: " . $stmt->error;
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $result = addAnunt($conn, $title, $content);
    if (strpos($result, 'succes') !== false) {
        $_SESSION['success'] = $result;
    } else {
        $_SESSION['error'] = $result;
    }
    header("Location: secretar.php?page=news");
    exit();
}

} else {
   header("Location: index.php");
   exit();
}
?>