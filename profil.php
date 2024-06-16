<?php

include "db_conn.php";

if (isset($_SESSION['user_name'])) {
    $username = $_SESSION['user_name'];

    $sql = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Utilizatorul nu a fost găsit.";
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Profilul Meu</title>
    <link rel="stylesheet" href="css/style13.css"> <!-- Adaugă fișierul CSS pentru profil -->
</head>
<body>
    <div class="profile-container">
        <h2>Profilul Meu</h2>
        <div class="profile-info">
            <div class="profile-info-column">
                <p><strong>Nume:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                <p><strong>Număr Matricol:</strong> <?php echo htmlspecialchars($user['nr_matricol']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            <div class="profile-info-column">
                <p><strong>An de studiu:</strong> <?php echo htmlspecialchars($user['an']); ?></p>
                <p><strong>Facultate:</strong> <?php echo htmlspecialchars($user['facultate']); ?></p>
                <p><strong>Secția:</strong> <?php echo htmlspecialchars($user['sectia']); ?></p>
                <p><strong>Tip învățământ:</strong> <?php echo htmlspecialchars($user['tip_invatamant']); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
