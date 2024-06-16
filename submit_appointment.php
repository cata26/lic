<?php
session_start();
include "db_conn.php";

function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

function getReservedHours($conn, $date) {
    $sql = "SELECT ora_prog FROM prog WHERE data_prog = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $reserved_hours = [];
    while ($row = $result->fetch_assoc()) {
        $reserved_hours[] = $row['ora_prog'];
    }
    return $reserved_hours;
}

function programare($conn, $username, $data_programarii, $ora_programarii) {
    $sql = "SELECT nr_matricol, name FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nr_matricol = $row['nr_matricol'];
        $name = $row['name'];

        $day_of_week = date('N', strtotime($data_programarii));
        if ($day_of_week == 6 || $day_of_week == 7) {
            return "Nu te poți programa în weekend.";
        }

        $current_date = date('Y-m-d');
        if ($data_programarii < $current_date) {
            return "Nu te poți programa înainte de data curentă.";
        }

        $sql = "SELECT * FROM prog WHERE data_prog = ? AND ora_prog = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $data_programarii, $ora_programarii);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return "Ora selectată este deja rezervată. Alege o altă oră.";
        }

        $sql = "INSERT INTO prog (nr_matricol, name, data_prog, ora_prog) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nr_matricol, $name, $data_programarii, $ora_programarii);

        if ($stmt->execute()) {
            return "Programarea a fost salvată cu succes.";
        } else {
            return "A apărut o eroare la salvarea programării: " . $stmt->error;
        }
    } else {
        return "Nu s-au găsit detalii pentru utilizatorul specificat.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_name'])) {
    $username = $_SESSION['user_name'];
    $data_programarii = $conn->real_escape_string($_POST['data_programarii']);
    $ora_programarii = $conn->real_escape_string($_POST['ora_programarii']);

    if (!validateDate($data_programarii)) {
        $_SESSION['error'] = "Data programării nu este validă.";
        header("Location: student.php?page=prog");
        exit();
    }

    $message = programare($conn, $username, $data_programarii, $ora_programarii);
    if (strpos($message, 'succes') !== false) {
        $_SESSION['success'] = $message;
    } else {
        $_SESSION['error'] = $message;
    }

    header("Location: student.php?page=prog");
    exit();
} else {
    $_SESSION['error'] = "Numele de utilizator nu este disponibil în sesiune.";
    header("Location: student.php?page=prog");
    exit();
}
?>