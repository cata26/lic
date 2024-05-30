<?php

include "db_conn.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];

        $sql = "INSERT INTO news (title, content) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $title, $content);

        if ($stmt->execute()) {
            $_SESSION['success']= "Anunțul a fost publicat cu succes!";
           
        } else {
            $_SESSION['error']= "Eroare la publicarea anunțului.";
          
        }
        header("Location: secretar.php?page=news");
        exit();
       
        
    }$stmt->close();
    ?>