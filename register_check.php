<?php
session_start();
include "db_conn.php";

function validate($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function registerUser($conn, $nr_matricol, $rol, $user_name, $email, 
$name, $an, $facultate, $sectia, $tip_invatamant, $localitate_dom, $judet_dom, $parola) {
    
    $sql = "SELECT * FROM users WHERE user_name=? OR email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_name, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Numele de utilizator, email-ul sau numărul matricol sunt deja folosite. Încearcă altceva!";
        return false;
    } else {
       
    $parola = password_hash($parola, PASSWORD_DEFAULT);


        $sql2 = "INSERT INTO users (nr_matricol, rol, user_name, email, name, 
        an, facultate, sectia, tip_invatamant, localitate_dom, judet_dom, parola)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("sssssissssss", $nr_matricol, $rol, $user_name, $email, $name, 
        $an, $facultate, $sectia, $tip_invatamant, $localitate_dom, $judet_dom, $parola);

        if ($stmt2->execute()) {
            $_SESSION['success'] = "Contul a fost creat cu succes!";
            return true;
        } else {
            $_SESSION['error'] = "A apărut o eroare necunoscută.";
            return false;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nr_matricol'], $_POST['user_name'], $_POST['email'], $_POST['name'], $_POST['an'], $_POST['facultate'], $_POST['sectia'], $_POST['tip_invatamant'], $_POST['rol'], $_POST['localitate_dom'], $_POST['judet_dom'], $_POST['parola'])) {

        $nr_matricol = validate($_POST['nr_matricol']);
        $rol = validate($_POST['rol']);
        $user_name = validate($_POST['user_name']);
        $email = validate($_POST['email']);
        $name = validate($_POST['name']);
        $an = validate($_POST['an']);
        $facultate = validate($_POST['facultate']);
        $sectia = validate($_POST['sectia']);
        $tip_invatamant = validate($_POST['tip_invatamant']);
        $localitate_dom = validate($_POST['localitate_dom']);
        $judet_dom = validate($_POST['judet_dom']);
        $parola = validate($_POST['parola']);

        if (empty($user_name) || empty($email) || empty($name) || empty($parola)) {
            $_SESSION['error'] = "Câmpurile marcate cu steluță sunt obligatorii!";
        } else {
            if (registerUser($conn, $nr_matricol, $rol, $user_name, $email, $name, $an, $facultate, $sectia, $tip_invatamant, $localitate_dom, $judet_dom, $parola)) {
                header("Location: admin.php?page=register");
                exit();
            }
        }
        header("Location: admin.php?page=register");
        exit();
    } else {
        header("Location: admin.php?page=register");
        exit();
    }
}
?>