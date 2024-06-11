<?php
session_start();
include "db_conn.php";

if (isset($_POST['nr_matricol']) && isset($_POST['uname']) && isset($_POST['email']) && isset($_POST['name']) && isset($_POST['year']) && isset($_POST['facultate']) && isset($_POST['sectia']) && isset($_POST['tip_invatamant'])) {

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $nr_matricol = validate($_POST['nr_matricol']);
    $uname = validate($_POST['uname']);
    $email = validate($_POST['email']);
    $name = validate($_POST['name']);
    $year = validate($_POST['year']);
    $facultate = validate($_POST['facultate']);
    $sectia = validate($_POST['sectia']);
    $tip_invatamant = validate($_POST['tip_invatamant']);

    if (empty($uname) || empty($email) || empty($name) || empty($year) || empty($facultate) || empty($sectia) || empty($tip_invatamant)) {
        $_SESSION['error'] = "Toate câmpurile sunt obligatorii.";
        header("Location: update_user.php?nr_matricol=" . $nr_matricol);
        exit();
    } else {
        $sql = "UPDATE users_1 SET user_name=?, email=?, name=?, year=?, facultate=?, sectia=?, tip_invatamant=? WHERE nr_matricol=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $uname, $email, $name, $year, $facultate, $sectia, $tip_invatamant, $nr_matricol);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Utilizatorul a fost actualizat cu succes!";
            header("Location: admin.php?page=list_st");
            exit();
        } else {
            $_SESSION['error'] = "A apărut o eroare necunoscută.";
            header("Location: update.php?nr_matricol=" . $nr_matricol);
            exit();
        }
    }


} else {
    $_SESSION['error'] = "Toate câmpurile sunt obligatorii.";
    header("Location: update.php?nr_matricol=" . $_POST['nr_matricol']);
    exit();
}
?>
