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

<!DOCTYPE html>
<html>
<head>
    <title>Actualizează Utilizator</title>
    <link rel="stylesheet" type="text/css" href="css/style10.css">
    <link rel="icon" href="upt.png" type="image/x-icon">
</head>
<body>
    <form action="update_process.php" method="post">
        <h2>Actualizează Utilizator</h2>
        <div class="form-row">
            <div class="form-group">
                <input type="hidden" name="nr_matricol" value="<?php echo htmlspecialchars($row['nr_matricol']); ?>">

                <label>Rol</label>
                <input type="text" name="rol" value="<?php echo htmlspecialchars($row['rol']); ?>" placeholder="Rol"><br>

                <label>User Name</label>
                <input type="text" name="uname" value="<?php echo htmlspecialchars($row['user_name']); ?>" placeholder="Username"><br>

                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" placeholder="Email"><br>

                <label>Nume</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" placeholder="Name"><br>

                <label>An</label>
                <input type="number" name="an" value="<?php echo htmlspecialchars($row['an']); ?>" placeholder="An"><br>

                <label>Facultate</label>
                <input type="text" name="facultate" value="<?php echo htmlspecialchars($row['facultate']); ?>" placeholder="Facultate"><br>
            </div>
            <div class="form-group">
                <label>Secția</label>
                <input type="text" name="sectia" value="<?php echo htmlspecialchars($row['sectia']); ?>" placeholder="Secția"><br>

                <label>Tip învățământ</label>
                <input type="text" name="tip_invatamant" value="<?php echo htmlspecialchars($row['tip_invatamant']); ?>" placeholder="Tip învățământ"><br>

                <label>Localitate domiciu</label>
                <input type="text" name="localitate_dom" value="<?php echo htmlspecialchars($row['localitate_dom']); ?>" placeholder="Localitate"><br>

                <label>Judet domiciu</label>
                <input type="text" name="judet_dom" value="<?php echo htmlspecialchars($row['judet_dom']); ?>" placeholder="Judet"><br>

                <label>Data nașterii</label>
                <input type="date" name="data_nasterii" value="<?php echo htmlspecialchars($row['data_nasterii']); ?>" placeholder="Data nașterii"><br>
            </div>
        </div>
        <button type="submit">Actualizează</button>
        <button type="button" onclick="window.history.back()">Înapoi</button>
    </form>
</body>
</html>
