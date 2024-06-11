<?php
include "db_conn.php"; 
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Programări</title>
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
<?php 
        if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>

        <?php if (isset($_SESSION['success'])) { ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php } ?>
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
           include "db_conn.php";  

        // Numărul de înregistrări pe pagină
        $records_per_page = 10;
           
        // Determinarea paginii curente
        $page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($page - 1) * $records_per_page;
           
        // Determinarea coloanei de sortare și direcției de sortare
        $sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'name';
        $sort_direction = isset($_GET['dir']) && $_GET['dir'] == 'desc' ? 'DESC' : 'ASC';
        
        $sql = "SELECT COUNT(*) FROM prog";
        $result = $conn->query($sql);
        $total_records = $result->fetch_row()[0];
        $total_pages = ceil($total_records / $records_per_page);
           
        $sql = "SELECT nr_matricol,name, data_prog, ora_prog, created_at FROM prog ORDER BY created_at DESC LIMIT ?, ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $records_per_page);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nr_matricol']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['data_prog']) . "</td>";
                echo "<td>" . htmlspecialchars($row['ora_prog']) . "</td>";
                echo "<td>
                <form method='post' action='delete_prog.php' style='display:inline-block;'>
                     <input type='hidden' name='delete_i' value='" . htmlspecialchars($row['data_prog']) . "'>
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
    <div class="pagination">
        <?php
        if ($page > 1) {
            echo '<a href="secretar.php?page=lista_prog&p' . ($page - 1) . '">&laquo; Anterior</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="secretar.php?page=lista_prog&p' . $i . '" class="active">' . $i . '</a>';
            } else {
                echo '<a href="secretar.php?page=lista_prog&p' . $i . '">' . $i . '</a>';
            }
        }
        if ($page < $total_pages) {
            echo '<a href="secretar.php?page=lista_prog&p' . ($page + 1) . '">Următor &raquo;</a>';
        }
        ?>
    </div>
</body>
</html>
