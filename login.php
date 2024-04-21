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

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($pass, $row['password'])) { // Verifică parola
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                // Redirecționează utilizatorul în funcție de domeniul email-ului
                $redirect_location = determineRedirectLocation($email);
                header("Location: $redirect_location");
                exit();
            } else {
                header("Location: index.php?error=Incorrect Username or Password");
                exit();
            }
        } else {
            header("Location: index.php?error=Incorrect Username or Password");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}

function determineRedirectLocation($email) {
    // Adaugă domeniile de email specifice
    $student_domain = "@student.upt.ro";
    $secretar_domain = "@upt.ro";
    $admin_domain = "@admin.upt.ro";
    $g_domain = "@gmail.com";
    
    if (strpos($email, $student_domain) !== false) {
        return "student.php";
    } elseif (strpos($email, $secretar_domain) !== false) {
        return "secretar.php";
    } elseif (strpos($email, $admin_domain) !== false) {
        return "admin.php";
    
    } else {
        // Dacă domeniul nu este recunoscut, trimite utilizatorul înapoi la pagina de login cu un mesaj de eroare
        header("Location: index.php?error=Invalid email domain");
        exit();
    }
}
?>
