<?php
session_start();
include "db_conn.php";

function validate($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function updateUser($conn, $nr_matricol, $uname, $rol, $email, $name, $year, $facultate, $sectia, $tip_invatamant) {
    $sql = "UPDATE users SET user_name=?, rol=?, email=?, name=?, year=?, facultate=?, sectia=?, tip_invatamant=? WHERE nr_matricol=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $uname, $rol, $email, $name, $year, $facultate, $sectia, $tip_invatamant, $nr_matricol);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Utilizatorul a fost actualizat cu succes!";
    } else {
        $_SESSION['error'] = "A apărut o eroare necunoscută: " . $stmt->error;
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['nr_matricol']) && isset($_POST['rol']) && isset($_POST['uname']) &&
        isset($_POST['email']) && isset($_POST['name']) && isset($_POST['an']) &&
        isset($_POST['facultate']) && isset($_POST['sectia']) && isset($_POST['tip_invatamant'])
    ) {
        $nr_matricol = validate($_POST['nr_matricol']);
        $uname = validate($_POST['uname']);
        $rol = validate($_POST['rol']);
        $email = validate($_POST['email']);
        $name = validate($_POST['name']);
        $year = validate($_POST['an']);
        $facultate = validate($_POST['facultate']);
        $sectia = validate($_POST['sectia']);
        $tip_invatamant = validate($_POST['tip_invatamant']);

        if (empty($uname) || empty($email) || empty($name) || empty($year) || empty($facultate) || empty($sectia) || empty($tip_invatamant)) {
            $_SESSION['error'] = "Toate câmpurile sunt obligatorii.";
            header("Location: update.php?nr_matricol=" . $nr_matricol);
            exit();
        } else {
            updateUser($conn, $nr_matricol, $uname, $rol, $email, $name, $year, $facultate, $sectia, $tip_invatamant);
            header("Location: admin.php?page=list_st");
            exit();
        }
    } else {
        $_SESSION['error'] = "Toate câmpurile sunt obligatorii.";
        header("Location: update.php?nr_matricol=" . $_POST['nr_matricol']);
        exit();
    }
}
?>
