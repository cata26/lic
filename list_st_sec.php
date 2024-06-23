<?php
include "db_conn.php";

function getStudents($conn, $start, $records_per_page, $sort_column, $sort_direction) {
    $sql = "SELECT nr_matricol, name, user_name, email, facultate, sectia FROM users WHERE email LIKE '%@student.upt.ro' ORDER BY $sort_column $sort_direction LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $start, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();
    $students = [];

    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    $stmt->close();

    return $students;
}

function getTotalRecords($conn) {
    $sql = "SELECT COUNT(*) FROM users WHERE email LIKE '%@student.upt.ro'";
    $result = $conn->query($sql);
    return $result->fetch_row()[0];
}

$records_per_page = 10;
$page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
$start = ($page - 1) * $records_per_page;
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'name';
$sort_direction = isset($_GET['dir']) && $_GET['dir'] == 'desc' ? 'DESC' : 'ASC';
$total_records = getTotalRecords($conn);
$total_pages = ceil($total_records / $records_per_page);
$students = getStudents($conn, $start, $records_per_page, $sort_column, $sort_direction);
?>

<?php

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista Studenți</title>
    <link rel="stylesheet" type="text/css" href="css/style5.css">
    <link rel="icon" href="upt.png" type="image/x-icon">
</head>
<body>
<div class="container list">
    <h1>Lista Studenți</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Număr Matricol</th>
                <th><a href="?page=list_st_sec&p=<?php echo $page; ?>&sort=name&dir=<?php echo $sort_direction == 'ASC' ? 'desc' : 'asc'; ?>">Nume</a></th>
                <th>Username</th>
                <th>Email</th>
                <th>Facultate</th>
                <th>Secția</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (count($students) > 0) {
            foreach ($students as $student) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($student['nr_matricol']) . "</td>";
                echo "<td>" . htmlspecialchars($student['name']) . "</td>";
                echo "<td>" . htmlspecialchars($student['user_name']) . "</td>";
                echo "<td>" . htmlspecialchars($student['email']) . "</td>";
                echo "<td>" . htmlspecialchars($student['facultate']) . "</td>";
                echo "<td>" . htmlspecialchars($student['sectia']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nu există studenți în baza de date.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <div class="pagination-container">
        <div class="pagination">
            <?php
            if ($page > 1) {
                echo '<a href="secretar.php?page=list_st_sec&p=' . ($page - 1) . '&sort=' . $sort_column . '&dir=' . $sort_direction . '">&laquo; Anterior</a>';
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo '<a href="secretar.php?page=list_st_sec&p=' . $i . '&sort=' . $sort_column . '&dir=' . $sort_direction . '" class="active">' . $i . '</a>';
                } else {
                    echo '<a href="secretar.php?page=list_st_sec&p=' . $i . '&sort=' . $sort_column . '&dir=' . $sort_direction . '">' . $i . '</a>';
                }
            }
            if ($page < $total_pages) {
                echo '<a href="secretar.php?page=list_st_sec&p=' . ($page + 1) . '&sort=' . $sort_column . '&dir=' . $sort_direction . '">Următor &raquo;</a>';
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