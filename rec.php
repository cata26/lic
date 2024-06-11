<?php
include "db_conn.php"; 
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Reclamații</title>
    <link rel="stylesheet" href="css/style5.css">
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
    <h1>Reclamații</h1>
    <table>
        <tr>
            <th>Nume</th>
            <th>Descriere</th>
            <th>Data</th>
        </tr>

        <?php
        
        // Numărul de înregistrări pe pagină
        $records_per_page = 10;
        
        // Determinarea paginii curente
        $page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($page - 1) * $records_per_page;
        
        // Obținerea numărului total de înregistrări
        $sql = "SELECT COUNT(*) FROM solicitari";
        $result = $conn->query($sql);
        $total_records = $result->fetch_row()[0];
        $total_pages = ceil($total_records / $records_per_page);


        $sql = "SELECT name, problema, created_at FROM raport ORDER BY created_at DESC LIMIT ?, ?";
         $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $records_per_page);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['problema']) . "</td>";
                echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
            
            }
        } else {
            echo "<tr><td colspan='4'>Nu există programări.</td></tr>";
        }

        $conn->close();
        ?>
    </table>
    <div class="pagination">
        <?php
        if ($page > 1) {
            echo '<a href="secretar.php?page=rec&p' . ($page - 1) . '">&laquo; Anterior</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="secretar.php?page=rec&p' . $i . '" class="active">' . $i . '</a>';
            } else {
                echo '<a href="secretar.php?page=rec&p' . $i . '">' . $i . '</a>';
            }
        }
        if ($page < $total_pages) {
            echo '<a href="secretar.php?page=rec&p' . ($page + 1) . '">Următor &raquo;</a>';
        }
        ?>
    </div>
</body>
</html>
