<?php
include "db_conn.php";

if (!isset($_SESSION['name'])) {
    $_SESSION['error'] = "Numele nu este disponibil în sesiune.";
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'];

function getStudentReclamatii($conn, $name, $start, $records_per_page) {
    $sql = "SELECT problema, created_at, status FROM raport WHERE name = ? ORDER BY created_at DESC LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $name, $start, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
    $reclamatii = [];

    while ($row = $result->fetch_assoc()) {
        $reclamatii[] = $row;
    }
    $stmt->close();

    return $reclamatii;
}

function getStudentTotalRecords($conn, $name) {
    $sql = "SELECT COUNT(*) FROM raport WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_row()[0];
}

$records_per_page = 5;
$page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
$start = ($page - 1) * $records_per_page;
$total_records = getStudentTotalRecords($conn, $name);
$total_pages = ceil($total_records / $records_per_page);
$reclamatii = getStudentReclamatii($conn, $name, $start, $records_per_page);
?>

<?php
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Problemele mele</title>
    <link rel="stylesheet" href="css/style5.css">
</head>
<body>
<div class="container list">
    <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php } ?>

    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php } ?>
    <h1>Problemele mele</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Descriere</th>
                <th>Data</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (count($reclamatii) > 0) {
            foreach ($reclamatii as $reclamatie) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($reclamatie['problema']) . "</td>";
                echo "<td>" . htmlspecialchars($reclamatie['created_at']) . "</td>";
                echo "<td>" . htmlspecialchars($reclamatie['status']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nu există reclamații.</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <div class="pagination-container">
        <div class="pagination">
            <?php
            if ($page > 1) {
                echo '<a href="student.php?page=status&p=' . ($page - 1) . '">&laquo; Anterior</a>';
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo '<a href="student.php?page=status&p=' . $i . '" class="active">' . $i . '</a>';
                } else {
                    echo '<a href="student.php?page=status&p=' . $i . '">' . $i . '</a>';
                }
            }
            if ($page < $total_pages) {
                echo '<a href="student.php?page=status&p=' . ($page + 1) . '">Următor &raquo;</a>';
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