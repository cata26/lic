<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['email']) && isset($_POST['password'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);

    if (empty($email)) {
        header("Location: index.php?error=Email is required");
        exit();
    } else if(empty($pass)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: index.php?error=Invalid email format");
            exit();
        }

        $sql = "SELECT * FROM users_1 WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($pass, $row['password'])) { 
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['rol'] = $row['rol'];
                $location = determineLocation($row['rol']);
                header("Location: $location");
                exit();
            } else {
                header("Location: index.php?error=Incorrect Email or Password");
                exit();
            }
        } else {
            header("Location: index.php?error=Incorrect Email or Password");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}

function determineLocation($rol) {
    switch ($rol) {
        case 'student':
            return "student.php";
        case 'secretar':
            return "secretar.php";
        case 'admin':
            return "admin.php";
        case 'profesor':
            return "profesor.php";
        default:
            header("Location: index.php?error=Invalid role");
            exit();
    }
}
?>
