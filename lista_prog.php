<?php
include "db_conn.php"; 
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Programări</title>
    <link rel="stylesheet" href="css/style9.css">
</head>
<body>
    <h1>Programări</h1>
    <table>
        <tr>
            <th>Număr matricol</th>
            <th>Data programării</th>
            <th>Ora programării</th>
        </tr>

        <?php
        $sql = "SELECT nr_matricol, data_prog, ora_prog, created_at FROM prog ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nr_matricol']) . "</td>";
                echo "<td>" . htmlspecialchars($row['data_prog']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ora_prog']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nu există programări.</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
