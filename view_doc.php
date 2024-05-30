<?php
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nr_matricol'])) {


    $id = $_POST['validate_id'];
    $sql = "UPDATE documents SET status='Validated', WHERE nr_matricol=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nr_matricol);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Documentul a fost validat cu succes.";
    } else {
        $_SESSION['error'] = "A apărut o eroare la validarea documentului.";
    }
    $stmt->close();
}

$sql = "SELECT * FROM documents ORDER BY upload_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Documente de studiu</title>
    <link rel="stylesheet" href="css/style5.css">
</head>
<body>
    <h2>Incarcare documente de studiu</h2>
    <?php 
    if (isset($_SESSION['error'])) { ?>
        <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php } ?>

    <?php if (isset($_SESSION['success'])) { ?>
        <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <?php } ?>

    <table>
        <thead>
            <tr>
                <th>Nr. Matricol</th>
                <th>Document</th>
                <th>Status</th>
                <th>Observații</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nr_matricol']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td><a href='" . htmlspecialchars($row['file_path']) . "' target='_blank'>Descarcă PDF</a></td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td>
                            <form method='post' style='display:inline-block;'>
                                <input type='hidden' name='validate_id' value='" . htmlspecialchars($row['id']) . "'>
                                <button type='submit'>Validează</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Nu există documente încărcate.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
