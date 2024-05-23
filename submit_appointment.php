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

            // Salvarea programării în baza de date
            $sql = "INSERT INTO prog (nr_matricol, data_prog, ora_prog) VALUES ('$nr_matricol', '$data_programarii', '$ora_programarii')";

            if ($conn->query($sql) === TRUE) {
                echo "Programarea a fost salvată cu succes.";
            } else {
                echo "Eroare: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Nu s-au găsit detalii pentru utilizatorul specificat.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Numele de utilizator nu este disponibil în sesiune.";
    }
}
?>
