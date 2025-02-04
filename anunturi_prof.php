<?php
include "db_conn.php"; 


function getAnnouncements($conn, $page, $records_per_page) {
    $strat = ($page - 1) * $records_per_page;
    $sql = "SELECT COUNT(*) FROM news";
    $result = $conn->query($sql);
    $total_records = $result->fetch_row()[0];
    $total_pages = ceil($total_records / $records_per_page);

    $query = "SELECT * FROM news ORDER BY data DESC LIMIT ?, ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $strat, $records_per_page);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $date = date("d", strtotime($row["data"]));
            $month = date("M", strtotime($row["data"]));
            $year = date("Y", strtotime($row["data"]));
            echo '<div class="announcement"><br>';
            echo '<div class="date">';
            echo '<span class="day">' . $date . '</span>';
            echo '<span class="month-year">' . strtoupper($month) . ' ' . $year . '</span>';
            echo '</div>';
            echo '<h2>' . htmlspecialchars($row["title"]) . '</h2>';
            echo '<p>' . nl2br(htmlspecialchars($row["content"])) . '</p>';
            echo '</div>';
        }
    } else {
        echo "Nu există anunțuri.";
    }
    $stmt->close();
    return $total_pages;
}

?>
<?php

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>


<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Anunțuri</title>
    <link rel="stylesheet" href="css/style8.css">
</head>
<body>
    
    <div class="announcements">
    <h1>Anunțuri</h1>
        <?php
        $records_per_page = 4;
        $page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
        $total_pages = getAnnouncements($conn, $page, $records_per_page);
        ?>
    </div>
    <div class="pagination">
        <?php
        if ($page > 1) {
            echo '<a href="profesor.php?page=anunturi_prof&p=' . ($page - 1) . '">&laquo; Anterior</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="profesor.php?page=anunturi_prof&p=' . $i . '" class="active">' . $i . '</a>';
            } else {
                echo '<a href="profesor.php?page=anunturi_prof&p=' . $i . '">' . $i . '</a>';
            }
        }
        if ($page < $total_pages) {
            echo '<a href="profesor.php?page=anunturi_prof&p=' . ($page + 1) . '">Următor &raquo;</a>';
        }
        ?>
    </div>
</body>
</html>
<?php
} else {
   header("Location: index.php");
   exit();
}
?>