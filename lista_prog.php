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
            <th>Număr matricol</th>
            <th>Nume</th>
            <th>Data programării</th>
            <th>Ora programării</th>
            <th></th>
        </tr>

        <?php
        $sql = "SELECT nr_matricol,name, data_prog, ora_prog, created_at FROM prog ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nr_matricol']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['data_prog']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ora_prog']) . "</td>";
                echo "<td>
                <form method='post' action='delete_prog.php' style='display:inline-block;'>
                     <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['nr_matricol']) . "'>
                    <button type='submit'>Șterge</button>
                </form>
                </td>";
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
