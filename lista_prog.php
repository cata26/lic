<?php
include "db_conn.php";

function getProgramari($conn, $offset, $records_per_page) {
    $sql = "SELECT nr_matricol, name, data_prog, ora_prog, created_at FROM prog ORDER BY created_at DESC LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $offset, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
    $programari = [];

    while ($row = $result->fetch_assoc()) {
        $programari[] = $row;
    }
    $stmt->close();

    return $programari;
}

function getTotalRecords($conn) {
    $sql = "SELECT COUNT(*) FROM prog";
    $result = $conn->query($sql);
    return $result->fetch_row()[0];
}

$records_per_page = 10;
$page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
$offset = ($page - 1) * $records_per_page;
$total_records = getTotalRecords($conn);
$total_pages = ceil($total_records / $records_per_page);
$programari = getProgramari($conn, $offset, $records_per_page);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Programări</title>
    <link rel="stylesheet" href="css/style5.css">
</head>
<body>
<div class="container mt-4">
    <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php } ?>

    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php } ?>
    <h1>Programări</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Număr matricol</th>
                <th>Nume</th>
                <th>Data programării</th>
                <th>Ora programării</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (count($programari) > 0) {
            foreach ($programari as $prog) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($prog['nr_matricol']) . "</td>";
                echo "<td>" . htmlspecialchars($prog['name']) . "</td>";
                echo "<td>" . htmlspecialchars($prog['data_prog']) . "</td>";
                echo "<td>" . htmlspecialchars($prog['ora_prog']) . "</td>";
                echo "<td>
                    <form method='post' action='delete_prog.php'>
                        <input type='hidden' name='delete_i' value='" . htmlspecialchars($prog['data_prog']) . "'>
                        <button type='submit' class='btn btn-danger btn-sm'>Șterge</button>
                    </form>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nu există programări.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <div class="pagination-container">
        <div class="pagination">
            <?php
            if ($page > 1) {
                echo '<a href="secretar.php?page=lista_prog&p=' . ($page - 1) . '">&laquo; Anterior</a>';
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo '<a href="secretar.php?page=lista_prog&p=' . $i . '" class="active">' . $i . '</a>';
                } else {
                    echo '<a href="secretar.php?page=lista_prog&p=' . $i . '">' . $i . '</a>';
                }
            }
            if ($page < $total_pages) {
                echo '<a href="secretar.php?page=lista_prog&p=' . ($page + 1) . '">Următor &raquo;</a>';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
