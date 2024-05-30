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
        <input type="hidden" name="nr_matricol" value="<?php echo htmlspecialchars($row['nr_matricol']); ?>">

        <label>User Name</label>
        <input type="text" name="uname" value="<?php echo htmlspecialchars($row['user_name']); ?>" placeholder="User Name"><br>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" placeholder="Email"><br>

        <label>Nume</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" placeholder="Name"><br>

        <label>Year</label>
        <input type="number" name="year" value="<?php echo htmlspecialchars($row['year']); ?>" placeholder="Year"><br>

        <label>Facultate</label>
        <input type="text" name="facultate" value="<?php echo htmlspecialchars($row['facultate']); ?>" placeholder="Facultate"><br>

        <label>Secția</label>
        <input type="text" name="sectia" value="<?php echo htmlspecialchars($row['sectia']); ?>" placeholder="Secția"><br>

        <label>Tip învățământ</label>
        <input type="text" name="tip_invatamant" value="<?php echo htmlspecialchars($row['tip_invatamant']); ?>" placeholder="Tip învățământ"><br>

        <button type="submit">Actualizează</button>
        <button type="back">Înapoi</button>
    </form>
</body>
</html>
