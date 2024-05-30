<?php
session_start();
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_name'])) {
        $username = $_SESSION['user_name'];

        // Preluarea detaliilor studentului din baza de date
        $sql = "SELECT nr_matricol, name, year, facultate, sectia, tip_invatamant FROM users WHERE user_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nr_matricol = $row['nr_matricol'];
            $name = $row['name'];
            $year = $row['year'];
            $facultate = $row['facultate'];
            $sectia = $row['sectia'];
            $tip_invatamant = $row['tip_invatamant'];

            // Preluarea datelor din formular
            $data_programarii = $conn->real_escape_string($_POST['data_programarii']);
            $ora_programarii = $conn->real_escape_string($_POST['ora_programarii']);

            // Verificarea dacă data este în weekend
            $day_of_week = date('N', strtotime($data_programarii));
            if ($day_of_week == 6 || $day_of_week == 7) {
                $_SESSION['error'] = "Nu te poți programa în weekend.";
                header("Location: student.php?page=prog");
                exit();
            }

            // Verificarea dacă data este în trecut
            $current_date = date('Y-m-d');
            if ($data_programarii < $current_date) {
                $_SESSION['error'] = "Nu te poți programa înainte de data curentă.";
                header("Location: student.php?page=prog");
                exit();
            }

            // Verificarea dacă ora este deja rezervată
            $sql = "SELECT * FROM prog WHERE data_prog = ? AND ora_prog = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $data_programarii, $ora_programarii);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION['error'] = "Ora selectată este deja rezervată. Alege o altă oră.";
                header("Location: student.php?page=prog");
                exit();
            }

            // Salvarea programării în baza de date
            $sql = "INSERT INTO prog (nr_matricol, name,data_prog, ora_prog) VALUES (?,?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $nr_matricol,$name, $data_programarii, $ora_programarii);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Programarea a fost salvată cu succes.";
            } else {
                $_SESSION['error'] = "A apărut o eroare la salvarea programării: " . $stmt->error;
            }

        } else {
            $_SESSION['error'] = "Nu s-au găsit detalii pentru utilizatorul specificat.";
        }
        header("Location: student.php?page=prog");
        exit();
        
    } else {
        $_SESSION['error'] = "Numele de utilizator nu este disponibil în sesiune.";
    }
}
?>
