<?php
include "db_conn.php"; 
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Anunțuri</title>
    <link rel="stylesheet" href="css/style8.css">
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            background-color: #0f4470;
            color: white;
            border-radius: 4px;
        }
        .pagination a.active {
            background-color: #9fc5e8;
            color: black;
        }
        .pagination a:hover {
            background-color: #cfe2f3;
        }
    </style>
</head>
<body>
    <form>
    <h1>Anunțuri</h1>
    <div class="announcements">
        <?php
        // Numărul de înregistrări pe pagină
        $records_per_page = 4;
        
        // Determinarea paginii curente
        $page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($page - 1) * $records_per_page;
        
        // Obținerea numărului total de înregistrări
        $sql = "SELECT COUNT(*) FROM news";
        $result = $conn->query($sql);
        $total_records = $result->fetch_row()[0];
        $total_pages = ceil($total_records / $records_per_page);
        
        $query = "SELECT * FROM news ORDER BY created_at DESC LIMIT ?, ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $offset, $records_per_page);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $date = date("d", strtotime($row["data"]));
                $month = date("M", strtotime($row["data"]));
                $year = date("Y", strtotime($row["data"]));
                ?>
                <div class="announcement">
                    <div class="date">
                        <span class="day"><?php echo $date; ?></span>
                        <span class="month-year"><?php echo strtoupper($month) . " " . $year; ?></span>
                    </div>
                    <h2><?php echo htmlspecialchars($row["title"]); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($row["content"])); ?></p>
                </div>
                <?php
            }
        } else {
            echo "Nu există anunțuri.";
        }
        $stmt->close();
        ?>
    </div>
    </form>
    <div class="pagination">
        <?php
        if ($page > 1) {
            echo '<a href="student.php?page=anunturi_stud&p=' . ($page - 1) . '">&laquo; Anterior</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="student.php?page=anunturi_stud&p=' . $i . '" class="active">' . $i . '</a>';
            } else {
                echo '<a href="student.php?page=anunturi_stud&p=' . $i . '">' . $i . '</a>';
            }
        }
        if ($page < $total_pages) {
            echo '<a href="student.php?page=anunturi_stud&p=' . ($page + 1) . '">Următor &raquo;</a>';
        }
        ?>
    </div>
</body>
</html>
