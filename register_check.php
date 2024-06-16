<?php
session_start();
include "db_conn.php";

function validate($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function registerUser($conn, $nr_matricol,$rol, $uname, $email, $name, $an, $facultate, $sectia, $tip_invatamant,$localitate_dom,$judet_dom,$data_nasterii,$parola) {
    // Verificarea existenței numelui de utilizator sau email-ului
    $sql = "SELECT * FROM users WHERE nr_matricol OR user_name=? OR email=? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nr_matricol, $uname, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Numele de utilizator, email-ul sau numărul matricol sunt deja folosite. Încearcă altceva!";
        return false;
    } else {
        // Criptarea parolei
        $parola = password_hash($parola, PASSWORD_DEFAULT);

        // Inserarea utilizatorului în baza de date
        $sql2 = "INSERT INTO users(nr_matricol, user_name, email, name, an, facultate, sectia, tip_invatamant, rol,localitate_dom,judet_dom,data_nasterii, parola) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ssssissssssss", $nr_matricol,$rol, $uname, $email, $name, $an, $facultate, $sectia, $tip_invatamant,$localitate_dom,$judet_dom,$data_nasterii, $parola);

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
    if (isset($_POST['nr_matricol'], $_POST['uname'], $_POST['email'], $_POST['name'], $_POST['an'], $_POST['facultate'], $_POST['sectia'], $_POST['tip_invatamant'], $_POST['rol'],$_POST['localitate_dom'],$_POST['judet_dom'],$_POST['data_nasterii'], $_POST['parola'])) {
        
        $nr_matricol = validate($_POST['nr_matricol']);
        $uname = validate($_POST['uname']);
        $email = validate($_POST['email']);
        $name = validate($_POST['name']);
        $an = validate($_POST['an']);
        $facultate = validate($_POST['facultate']);
        $sectia = validate($_POST['sectia']);
        $tip_invatamant = validate($_POST['tip_invatamant']);
        $rol = validate($_POST['rol']);
        $localitate_dom = validate($_POST['localitate_dom']);
        $judet_dom = validate($_POST['judet_dom']);
        $data_nasterii = validate($_POST['data_nasterii']);
        $parola = validate($_POST['parola']);

        if (empty($uname) || empty($email) || empty($name) || empty($parola)) {
            $_SESSION['error'] = "Câmpurile marcate cu steluță sunt obligatorii!";
        } else {
            if (registerUser($conn, $nr_matricol, $uname, $email, $name, $an, $facultate, $sectia, $tip_invatamant, $rol,$localitate_dom,$judet_dom,$data_nasterii, $parola)) {
                header("Location: admin.php?page=list_st");
                exit();
            }
        }
        header("Location: admin.php?page=register");
        exit();
    } else {
        $_SESSION['error'] = "Toate câmpurile sunt obligatorii.";
        header("Location: admin.php?page=register");
        exit();
    }
} else {
    header("Location: admin.php?page=register");
    exit();
}
?>
