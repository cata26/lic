<!DOCTYPE html>
<html lang="ro">
<head>
    <title>Documente Generate</title>
    <link rel="stylesheet" href="css/style5.css">
</head>
<body>
    <h1>Documente Generate</h1>
    <table>
        <tr>
            <th>Tip document</th>
            <th>Descarcare document</th>
        </tr>


<?php
include "db_conn.php"; 

if (isset($_SESSION['user_name'])) {
    $username = $_SESSION['user_name'];

    $sql = "SELECT nr_matricol FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nr_matricol = $row['nr_matricol'];
    } else {
        echo "Nu s-a găsit un număr de matricol pentru utilizatorul $user_name.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Numele de utilizator nu este disponibil în sesiune.";
}
        $dir = "student_documents/".$nr_matricol;
        if (is_dir($dir) && $dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'pdf') {
                    echo "<tr><td>" . htmlspecialchars($file) . "</td>";
                    echo "<td><a href='$dir/$file' target='_blank'>PDF</a></td></tr>";
                }
            }
            closedir($dh);
        } else {
            echo "<tr><td colspan='2'>Nu se poate deschide directorul sau directorul nu există.</td></tr>";
        }

?>

</table>
</body>
</html>
