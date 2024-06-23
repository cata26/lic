<?php
session_start();
include "db_conn.php";

if (isset($_GET['nr_matricol'])) {
    $nr_matricol = $_GET['nr_matricol'];

    // Preia informațiile utilizatorului din baza de date
    $sql = "SELECT * FROM users WHERE nr_matricol = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nr_matricol);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Nu s-a găsit un utilizator cu acest număr matricol.";
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Număr matricol invalid.";
    exit();
}
?>
<?php

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizează Utilizator</title>
    <link rel="stylesheet" type="text/css" href="css/style10.css">
    <link rel="icon" href="upt.png" type="image/x-icon">
</head>
<body>
    <form action="update_process.php" method="post" <?php 
        if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION['success'])) { ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php } ?>
        <h2>Actualizează Utilizator</h2>
        <div class="form-row">
            <div class="form-group">

                <input type="hidden" name="nr_matricol" value="<?php echo htmlspecialchars($row['nr_matricol']); ?>">
                <input type="text" name="rol" value="<?php echo htmlspecialchars($row['rol']); ?>" placeholder="Rol"><br>
                <input type="text" name="uname" value="<?php echo htmlspecialchars($row['user_name']); ?>" placeholder="Username"><br>
                <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" placeholder="Email"><br>
                <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" placeholder="Name"><br>
                <input type="text" name="an" value="<?php echo htmlspecialchars($row['an']); ?>" placeholder="An"><br>
                <input type="text" name="facultate" value="<?php echo htmlspecialchars($row['facultate']); ?>" placeholder="Facultate"><br>

            </div>
            <div class="form-group">
               
                <input type="text" name="sectia" value="<?php echo htmlspecialchars($row['sectia']); ?>" placeholder="Secția"><br>
                <input type="text" name="tip_invatamant" value="<?php echo htmlspecialchars($row['tip_invatamant']); ?>" placeholder="Tip învățământ"><br>
                <input type="text" name="localitate_dom" value="<?php echo htmlspecialchars($row['localitate_dom']); ?>" placeholder="Localitate"><br>
                <input type="text" name="judet_dom" value="<?php echo htmlspecialchars($row['judet_dom']); ?>" placeholder="Județ"><br>
                <label>Data nașterii</label>
                <input type="date" name="data_nasterii" value="<?php echo htmlspecialchars($row['data_nasterii']); ?>" placeholder="Data nașterii"><br>

            </div>
        </div>
        <button type="submit">Actualizează</button>
        <button type="button" onclick="window.history.back()">Înapoi</button>
    </form>
</body>
</html>

<?php
} else {
   header("Location: index.php");
   exit();
}
?>