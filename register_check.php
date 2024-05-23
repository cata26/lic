<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['email']) && isset($_POST['name']) && isset($_POST['year'])&& isset($_POST['facultate'])&& isset($_POST['sectia'])&& isset($_POST['tip_invatamant']) && isset($_POST['password'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $email = validate($_POST['email']);
    $name = validate($_POST['name']);
    $year = validate($_POST['year']);
    $facultate = validate($_POST['facultate']);
    $sectia = validate($_POST['sectia']);
    $tip_invatamant = validate($_POST['tip_invatamant']);
    $pass = validate($_POST['password']);

    $user_data = 'uname='. $uname. '&email='. $email. '&name='. $name;

    if (empty($uname) || empty($email) || empty($name)  || empty($pass)) {
        header("Location: register.php?error=Câmpurile marcate cu steluță sunt obligatorii!&$user_data");
        exit();
    } else {

        // hashing the password
        $pass = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM users WHERE user_name='$uname' OR email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            header("Location: register.php?error=The username or email is taken, try another&$user_data");
            exit();
        } else {
            $sql2 = "INSERT INTO users(user_name, email, name, year,facultate,sectia,tip_invatamant, password) VALUES('$uname', '$email', '$name', '$year','$facultate','$sectia','$tip_invatamant', '$pass')";
            $result2 = mysqli_query($conn, $sql2);

            if ($result2) {
                header("Location: register.php?success=Your account has been created successfully");
                exit();
            } else {
                header("Location: register.php?error=Unknown error occurred&$user_data");
                exit();
            }
        }
    }
} else {
    header("Location: register.php");
    exit();
}