<?php

include "db_conn.php"; 

function addAnnouncement($conn, $title, $content) {
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

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $result = addAnnouncement($conn, $title, $content);
    if (strpos($result, 'succes') !== false) {
        $_SESSION['success'] = $result;
    } else {
        $_SESSION['error'] = $result;
    }
    header("Location: secretar.php?page=news");
    exit();
}

?>
