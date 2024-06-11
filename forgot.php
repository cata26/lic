<?php 
session_start();
$error = array();

require "mail.php";

if (!$con = mysqli_connect("localhost", "root", "", "login_db")) {
    die("could not connect");
}

$mode = "enter_email";
if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
}

// something is posted
if (count($_POST) > 0) {
    switch ($mode) {
        case 'enter_email':
            $email = $_POST['email'];
            // validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error[] = "Te rogăm introdu un email valid";
            } elseif (!valid_email($email)) {
                $error[] = "Email-ul nu a fost găsit";
            } else {
                $_SESSION['forgot']['email'] = $email;
                send_email($email);
                header("Location: forgot.php?mode=enter_code");
                die;
            }
            break;

        case 'enter_code':
            $code = $_POST['code'];
            $result = is_code_correct($code);

            if ($result === "Codul este corect") {
                $_SESSION['forgot']['code'] = $code;
                header("Location: forgot.php?mode=enter_password");
                die;
            } else {
                $error[] = $result;
            }
            break;

        case 'enter_password':
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            if ($password !== $password2) {
                $error[] = "Parola nu se potrivește";
            } elseif (!isset($_SESSION['forgot']['email']) || !isset($_SESSION['forgot']['code'])) {
                header("Location: forgot.php");
                die;
            } else {
                save_password($password);
                if (isset($_SESSION['forgot'])) {
                    unset($_SESSION['forgot']);
                }

                header("Location: login.php");
                die;
            }
            break;

        default:
            break;
    }
}

function send_email($email) {
    global $con;

    $expire = time() + (60 * 15); // Codul expiră în 15 minute
    $code = rand(10000, 99999);
    $email = addslashes($email);

    $query = "INSERT INTO codes (email, code, expire) VALUES ('$email', '$code', '$expire')";
    mysqli_query($con, $query);

    // Trimite emailul cu codul de resetare
    send_mail($email, 'Resetare parola!', "Codul tau este " . $code);
}

function save_password($password) {
    global $con;

    $password = password_hash($password, PASSWORD_DEFAULT);
    $email = addslashes($_SESSION['forgot']['email']);

    $query = "UPDATE users_1 SET password = '$password' WHERE email = '$email' LIMIT 1";
    mysqli_query($con, $query);
}

function valid_email($email) {
    global $con;

    $email = addslashes($email);

    $query = "SELECT * FROM users_1 WHERE email = '$email' LIMIT 1";        
    $result = mysqli_query($con, $query);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            return true;
        }
    }

    return false;
}

function is_code_correct($code) {
    global $con;

    $code = addslashes($code);
    $expire = time();
    $email = addslashes($_SESSION['forgot']['email']);

    $query = "SELECT * FROM codes WHERE code = '$code' AND email = '$email' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['expire'] > $expire) {
                return "Codul este corect";
            } else {
                return "Codul este expirat";
            }
        } else {
            return "Codul este incorect";
        }
    }

    return "Codul este incorect";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Am uitat parola!</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" href="upt.png" type="image/x-icon">
</head>
<body>
    <?php 
        switch ($mode) {
            case 'enter_email':
                ?>
                <form method="post" action="forgot.php?mode=enter_email">
                    <h1>Resetare parolă</h1><br>
                    <h3>Te rugăm să introduci adresa de email</h3>
                    <span style="font-size: 12px;color:red;">
                    <?php 
                        foreach ($error as $err) {
                            echo $err . "<br>";
                        }
                    ?>
                    </span>
                    <input class="textbox" type="email" name="email" placeholder="Email"><br>
                    <button type="submit" value="Next">Send</button>
                    <div><a href="login.php">Anulează</a></div>
                </form>
                <?php                
                break;

            case 'enter_code':
                ?>
                <form method="post" action="forgot.php?mode=enter_code"> 
                    <h1>Am uitat parola</h1>
                    <h3>Te rugăm să introduci codul</h3>
                    <span style="font-size: 12px;color:red;">
                    <?php 
                        foreach ($error as $err) {
                            echo $err . "<br>";
                        }
                    ?>
                    </span>

                    <input class="textbox" type="text" name="code" placeholder="12345"><br>
                    <button type="submit" value="Next">Send</button>
                    <div><a href="login.php">Anulează</a></div>
                </form>
                <?php
                break;

            case 'enter_password':
                ?>
                <form method="post" action="forgot.php?mode=enter_password"> 
                    <h1>Forgot Password</h1>
                    <h3>Te rugăm să introduci noua parolă</h3>
                    <span style="font-size: 12px;color:red;">
                    <?php 
                        foreach ($error as $err) {
                            echo $err . "<br>";
                        }
                    ?>
                    </span>

                    <input class="textbox" type="password" name="password" placeholder="Password"><br>
                    <input class="textbox" type="password" name="password2" placeholder="Retype Password"><br>
                    <button type="submit" value="Next">Send</button>
                    <div><a href="login.php">Anulează</a></div>
                </form>
                <?php
                break;
        }
    ?>
</body>
</html>
