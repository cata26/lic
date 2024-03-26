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

    }else if(empty($pass)){

        header("Location: index.php?error=Password is required");
        exit();

    }else{
        // Verifică dacă adresa de email este validă
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: index.php?error=Invalid email format");
            exit();
        }

        // Verifică domeniul adresei de email și direcționează către paginile corespunzătoare
        $student_domain = "@student.upt.ro";
        $secretar_domain = "@upt.ro";
        $admin_domain = "@admin.upt.ro";
        
        // Verifică dacă adresa de email conține @student.upt.com
        if (strpos($email, $student_domain) !== false) {
            // Dacă adresa de email conține @student.upt.ro
            // Direcționează către pagina de student
            $redirect_location = "student.php";
        } elseif (strpos($email, $secretar_domain) !== false) {
            // Dacă adresa de email conține @cs.upt.ro
            // Direcționează către pagina de secretar
            $redirect_location = "secretar.php";
        } elseif (strpos($email, $admin_domain) !== false) {
            // Dacă adresa de email conține @admin.upt.ro
            // Direcționează către pagina de admin
            $redirect_location = "admin.php";
        } else {
            // Altfel, adresa de email nu corespunde niciunei condiții
            header("Location: index.php?error=Invalid email domain");
            exit();
        
        }

        $sql = "SELECT * FROM users WHERE email='$email' AND password='$pass'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if ($row['email'] === $email && $row['password'] === $pass) {
                echo "Logged in!";
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                header("Location: $redirect_location");
                exit();


            }else{

                header("Location: index.php?error=Incorect User name or password");

                exit();

            }

        }else{

            header("Location: index.php?error=Incorect User name or password");

            exit();

        }

    }

}else{

    header("Location: index.php");

    exit();

}


?>