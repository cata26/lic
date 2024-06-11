<?php
session_start();
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_name'])) {
        $username = $_SESSION['user_name'];

        // Obținem numărul matricol din baza de date
        $sql = "SELECT nr_matricol FROM users_1 WHERE user_name = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nr_matricol = $row['nr_matricol'];
                $stmt->close();

                // Prelucrăm fișierul încărcat
                if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
                    $file_name = $_FILES['document']['name'];
                    $file_tmp = $_FILES['document']['tmp_name'];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                    $allowed_ext = array("pdf");

                    if (in_array($file_ext, $allowed_ext)) {
                        $upload_dir = "burse/";
                        if (!is_dir($upload_dir)) {
                            mkdir($upload_dir, 0777, true);
                        }

                        $new_file_name = $nr_matricol . "_" . time() . "." . $file_ext;
                        $upload_file = $upload_dir . $new_file_name;

                        if (move_uploaded_file($file_tmp, $upload_file)) {
                            $sql = "INSERT INTO documents (nr_matricol, file_path) VALUES (?, ?)";
                            $stmt = $conn->prepare($sql);
                            if ($stmt) {
                                $stmt->bind_param("ss", $nr_matricol, $upload_file);
                                if ($stmt->execute()) {
                                    $_SESSION['success'] = "Fișierul a fost încărcat cu succes.";
                                } else {
                                    $_SESSION['error'] = "A apărut o eroare la salvarea fișierului în baza de date.";
                                }
                                $stmt->close();
                            } else {
                                $_SESSION['error'] = "A apărut o eroare la pregătirea interogării.";
                            }
                        } else {
                            $_SESSION['error'] = "A apărut o eroare la încărcarea fișierului.";
                        }
                    } else {
                        $_SESSION['error'] = "Doar fișierele PDF sunt permise.";
                    }
                } else {
                    $_SESSION['error'] = "A apărut o eroare la încărcarea fișierului.";
                }
            } else {
                $_SESSION['error'] = "Nu am găsit numărul matricol pentru utilizatorul curent.";
            }
        } else {
            $_SESSION['error'] = "A apărut o eroare la pregătirea interogării pentru numărul matricol.";
        }
    } else {
        $_SESSION['error'] = "Utilizatorul nu este autentificat.";
    }
}

header("Location: student.php?page=upload_burse");
exit();
?>
