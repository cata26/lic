<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Programări</title>
    <link rel="stylesheet" type="text/css" href="css/style5.css">
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
<div class="container mt-4">
    <?php 
    if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php } ?>

    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php } ?>
    <h1>Programări</h1>
    <table class="table table-striped">
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
        include "db_conn.php";  

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
        
        // Obținerea înregistrărilor pentru pagina curentă
        $sql = "SELECT name, facultate, document_type, created_at FROM solicitari ORDER BY created_at DESC LIMIT ?, ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $records_per_page);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['facultate']) . "</td>";
                echo "<td>" . htmlspecialchars($row['document_type']) . "</td>";
                echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nu există programări.</td></tr>";
        }
        $stmt->close();
        ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php
        if ($page > 1) {
            echo '<a href="secretar.php?page=solicitari_secretar&p' . ($page - 1) . '">&laquo; Anterior</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="secretar.php?page=solicitari_secretar&p' . $i . '" class="active">' . $i . '</a>';
            } else {
                echo '<a href="secretar.php?page=solicitari_secretar&p' . $i . '">' . $i . '</a>';
            }
        }
        if ($page < $total_pages) {
            echo '<a href="secretar.php?page=solicitari_secretar&p' . ($page + 1) . '">Următor &raquo;</a>';
        }
        ?>
    </div>
</div>
</body>
</html>
