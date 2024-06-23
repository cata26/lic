<?php
include "db_conn.php";

function getReclamatii($conn, $start, $records_per_page) {
    $sql = "SELECT id, name, problema, created_at, status FROM raport ORDER BY created_at DESC LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $start, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
    $reclamatii = [];

    while ($row = $result->fetch_assoc()) {
        $reclamatii[] = $row;
    }
    $stmt->close();

    return $reclamatii;
}

function getTotalRecords($conn) {
    $sql = "SELECT COUNT(*) FROM raport";
    $result = $conn->query($sql);
    return $result->fetch_row()[0];
}

function updateReclamatieStatus($conn, $id, $status) {
    $sql = "UPDATE raport SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reclamatie_id']) && isset($_POST['status'])) {
    $reclamatie_id = intval($_POST['reclamatie_id']);
    $status = $conn->real_escape_string($_POST['status']);
    updateReclamatieStatus($conn, $reclamatie_id, $status);
    $_SESSION['success'] = "Starea reclamației a fost actualizată cu succes.";
    header("Location: secretar.php?page=rec");
    exit();
}

$records_per_page = 10;
$page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
$start = ($page - 1) * $records_per_page;
$total_records = getTotalRecords($conn);
$total_pages = ceil($total_records / $records_per_page);
$reclamatii = getReclamatii($conn, $start, $records_per_page);
?>

<?php

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Reclamații</title>
    <link rel="stylesheet" href="css/style5.css">
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

    <h1>Reclamații</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Nume</th>
                <th>Descriere</th>
                <th>Data</th>
                <th>Status</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (count($reclamatii) > 0) {
            foreach ($reclamatii as $reclamatie) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($reclamatie['name']) . "</td>";
                echo "<td>" . htmlspecialchars($reclamatie['problema']) . "</td>";
                echo "<td>" . htmlspecialchars($reclamatie['created_at']) . "</td>";
                echo "<td>" . htmlspecialchars($reclamatie['status']) . "</td>";
                echo "<td>
                    <form method='post' action=''>
                        <input type='hidden' name='reclamatie_id' value='" . htmlspecialchars($reclamatie['id']) . "'>
                        <select name='status' onchange='this.form.submit()'>
                            <option value='Nerezolvat' " . ($reclamatie['status'] == 'Nerezolvat' ? 'selected' : '') . ">Nerezolvat</option>
                            <option value='Rezolvat' " . ($reclamatie['status'] == 'Rezolvat' ? 'selected' : '') . ">Rezolvat</option>
                            <option value='Nu necesită rezolvare' " . ($reclamatie['status'] == 'Nu necesită rezolvare' ? 'selected' : '') . ">Nu necesită rezolvare</option>
                        </select>
                    </form>
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nu există reclamații.</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <div class="pagination-container">
        <div class="pagination">
            <?php
            if ($page > 1) {
                echo '<a href="secretar.php?page=rec&p=' . ($page - 1) . '">&laquo; Anterior</a>';
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo '<a href="secretar.php?page=rec&p=' . $i . '" class="active">' . $i . '</a>';
                } else {
                    echo '<a href="secretar.php?page=rec&p=' . $i . '">' . $i . '</a>';
                }
            }
            if ($page < $total_pages) {
                echo '<a href="secretar.php?page=rec&p=' . ($page + 1) . '">Următor &raquo;</a>';
            }
            ?>
        </div>
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