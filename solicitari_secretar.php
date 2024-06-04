<?php
include "db_conn.php"; 
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Programări</title>
    <link rel="stylesheet" href="css/style5.css">
</head>
<body>
    <h1>Programări</h1>
    <table>
        <tr>
            <th>Nume</th>
            <th>Facultate</th>
            <th>Socilitare</th>
            <th>Ora solicitării</th>
        </tr>

        <?php
        $sql = "SELECT name, facultate, document_type, created_at FROM solicitari ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['facultate']) . "</td>";
                echo "<td>" . htmlspecialchars($row['document_type']) . "</td>";
                echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
            }
        } else {
            echo "<tr><td colspan='4'>Nu există programări.</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
