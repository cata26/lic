<?php 
session_start(); 
include "db_conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nr_matricol']) && isset($_POST['uname']) && isset($_POST['email']) && isset($_POST['name']) && isset($_POST['year']) && isset($_POST['facultate']) && isset($_POST['sectia']) && isset($_POST['tip_invatamant'])&& isset($_POST['rol']) && isset($_POST['password'])) {

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
        $rol = validate($_POST['rol']);
        $pass = validate($_POST['password']);

        if ( empty($uname) || empty($email) || empty($name) || empty($pass)) {
            $_SESSION['error'] = "Câmpurile marcate cu steluță sunt obligatorii!";
        } else {
            // Hashing the password
            $pass = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "SELECT * FROM users_1 WHERE user_name=? OR email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $uname, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION['error'] = "Numele de utilizator sau email-ul sunt deja folosite. Încearcă altceva!";
            } else {
                $sql2 = "INSERT INTO users_1(nr_matricol, user_name, email, name, year, facultate, sectia, tip_invatamant,rol, password) VALUES(?, ?, ?, ?, ?, ?, ?,?, ?, ?)";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bind_param("ssssisssss", $nr_matricol, $uname, $email, $name, $year, $facultate, $sectia, $tip_invatamant,$rol, $pass);

                if ($stmt2->execute()) {
                    $_SESSION['success'] = "Contul a fost creat cu succes!";
                } else {
                    $_SESSION['error'] = "A apărut o eroare necunoscută.";
                }
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
