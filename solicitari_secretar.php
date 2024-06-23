<?php
include "db_conn.php";

function getSolicitari($conn, $start, $records_per_page) {
    $sql = "SELECT name, facultate, document_type, created_at FROM solicitari ORDER BY created_at DESC LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $start, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
    $solicitari = [];

    while ($row = $result->fetch_assoc()) {
        $solicitari[] = $row;
    }

    $stmt->close();
    return $solicitari;
}

function getTotalRecords($conn) {
    $sql = "SELECT COUNT(*) FROM solicitari";
    $result = $conn->query($sql);
    return $result->fetch_row()[0];
}

$records_per_page = 10;
$page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
$start = ($page - 1) * $records_per_page;
$total_records = getTotalRecords($conn);
$total_pages = ceil($total_records / $records_per_page);
$solicitari = getSolicitari($conn, $start, $records_per_page);
?>


<?php
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Programări</title>
    <link rel="stylesheet" type="text/css" href="css/style5.css">
</head>
<body>
<div class="container list">
       <?php 
        if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION['success'])) { ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php } ?>
    <h1>Solicitări</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Nume</th>
                <th>Facultate</th>
                <th>Socilitare</th>
                <th>Ora solicitării</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (count($solicitari) > 0) {
            foreach ($solicitari as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['facultate']) . "</td>";
                echo "<td>" . htmlspecialchars($row['document_type']) . "</td>";
                echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nu există solicitări.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php
        if ($page > 1) {
            echo '<a href="secretar.php?page=solicitari_secretar&p=' . ($page - 1) . '">&laquo; Anterior</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="secretar.php?page=solicitari_secretar&p=' . $i . '" class="active">' . $i . '</a>';
            } else {
                echo '<a href="secretar.php?page=solicitari_secretar&p=' . $i . '">' . $i . '</a>';
            }
        }
        if ($page < $total_pages) {
            echo '<a href="secretar.php?page=solicitari_secretar&p=' . ($page + 1) . '">Următor &raquo;</a>';
        }
        ?>
    </div>
</div>
</body>
</html>
<?php
} else {
   header("Location: index.php");
   exit();
}
?>