<?php
include "db_conn.php";  
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista Studenți</title>
    <link rel="stylesheet" type="text/css" href="css/style5.css">
    <link rel="icon" href="upt.png" type="image/x-icon">
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
    <h2>Lista Studenți</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><a href="?page=list_st_prog&p=<?php echo $page; ?>&sort=nr_matricol&dir=<?php echo $sort_direction == 'ASC' ? 'desc' : 'asc'; ?>">Număr Matricol</a></th>
                <th><a href="?page=list_st_prog&p=<?php echo $page; ?>&sort=name&dir=<?php echo $sort_direction == 'ASC' ? 'desc' : 'asc'; ?>">Nume</a></th>
                <th><a href="?page=list_st_prog&p=<?php echo $page; ?>&sort=user_name&dir=<?php echo $sort_direction == 'ASC' ? 'desc' : 'asc'; ?>">Username</a></th>
                <th><a href="?page=list_st_prog&p=<?php echo $page; ?>&sort=email&dir=<?php echo $sort_direction == 'ASC' ? 'desc' : 'asc'; ?>">Email</a></th>
            </tr>
        </thead>
        <tbody>
        <?php

        $records_per_page = 10;
        // Determinarea paginii curente
        $page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($page - 1) * $records_per_page;
        
        // Determinarea coloanei de sortare și direcției de sortare
        $sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'name';
        $sort_direction = isset($_GET['dir']) && $_GET['dir'] == 'desc' ? 'DESC' : 'ASC';
        
        // Obținerea numărului total de înregistrări
        $sql = "SELECT COUNT(*) FROM users_1 WHERE email LIKE '%@student.upt.ro'";
        $result = $conn->query($sql);
        $total_records = $result->fetch_row()[0];
        $total_pages = ceil($total_records / $records_per_page);
        
        // Obținerea înregistrărilor pentru pagina curentă cu sortare
        $sql = "SELECT nr_matricol, name, user_name, email FROM users_1 WHERE email LIKE '%@student.upt.ro' ORDER BY $sort_column $sort_direction LIMIT ?, ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $records_per_page);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nr_matricol']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            }
        } else {
            echo "<tr><td colspan='5'>Nu există studenți în baza de date.</td></tr>";
        }
        $stmt->close();
        ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php
        if ($page > 1) {
            echo '<a href="profesor.php?page=list_st_prof&p=' . ($page - 1) . '&sort=' . $sort_column . '&dir=' . $sort_direction . '">&laquo; Anterior</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="profesor.php?page=list_st_prof&p=' . $i . '&sort=' . $sort_column . '&dir=' . $sort_direction . '" class="active">' . $i . '</a>';
            } else {
                echo '<a href="profesor.php?page=list_st_prof&p=' . $i . '&sort=' . $sort_column . '&dir=' . $sort_direction . '">' . $i . '</a>';
            }
        }
        if ($page < $total_pages) {
            echo '<a href="profesor.php?page=list_st_prof&p=' . ($page + 1) . '&sort=' . $sort_column . '&dir=' . $sort_direction . '">Următor &raquo;</a>';
        }
        ?>
    </div>
</div>
</body>
</html>
