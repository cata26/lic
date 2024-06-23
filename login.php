<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['email']) && isset($_POST['parola'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $email = validate($_POST['email']);
    $parola = validate($_POST['parola']);

    if (empty($email)) {
        header("Location: index.php?error=Email is required");
        exit();
    } else if(empty($parola)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: index.php?error=Invalid email format");
            exit();
        }

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            
            
            if ($row['rol'] === 'admin' && $row['parola'] === $parola) {
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['rol'] = $row['rol'];
                header("Location: admin.php");
                exit();
            
            
            } elseif ($row['rol'] !== 'admin' && password_verify($parola, $row['parola'])) {
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['rol'] = $row['rol'];
                $location = login($row['rol']);
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

function login($rol) {
    switch ($rol) {
        case 'student':
            return "student.php";
        case 'secretar':
            return "secretar.php";
        case 'profesor':
            return "profesor.php";
        default:
            header("Location: index.php?error=Invalid role");
            exit();
    }
}
?>
