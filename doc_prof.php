<?php
include "db_conn.php"; 

if (isset($_SESSION['user_name'])) {
    $username = $_SESSION['user_name'];

    $sql = "SELECT nr_matricol FROM users_1 WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nr_matricol = $row['nr_matricol'];
    } else {
        echo "Nu s-a găsit un număr de matricol pentru utilizatorul $username.";
        exit();
    }

    $stmt->close();
} else {
    echo "Numele de utilizator nu este disponibil în sesiune.";
    exit();
}

// Definirea numărului de documente pe pagină
$records_per_page = 5;

// Determinarea paginii curente
$page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
$offset = ($page - 1) * $records_per_page;

// Determinarea numărului total de documente
$dir = "student_documents/" . $nr_matricol;
$total_records = 0;
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'pdf') {
                $total_records++;
            }
        }
        closedir($dh);
    }
} else {
    echo "Nu se poate deschide directorul sau directorul nu există.";
    exit();
}

$total_pages = ceil($total_records / $records_per_page);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <title>Documente Generate</title>
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
    <h1>Documente Generate</h1>
    <table>
        <tr>
            <th>Tip document</th>
            <th>Descarcare document</th>
        </tr>

        <?php
        $document_count = 0;
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'pdf') {
                        if ($document_count >= $offset && $document_count < $offset + $records_per_page) {
                            echo "<tr><td>" . htmlspecialchars($file) . "</td>";
                            echo "<td><a href='$dir/$file' target='_blank'>PDF</a></td></tr>";
                        }
                        $document_count++;
                    }
                }
                closedir($dh);
            } else {
                echo "<tr><td colspan='2'>Nu se poate deschide directorul.</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Nu există documente pentru acest utilizator.</td></tr>";
        }
        ?>
    </table>

    <div class="pagination">
        <?php
        if ($page > 1) {
            echo '<a href="profesor.php?page=doc_prof&p=' . ($page - 1) . '">&laquo; Anterior</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="profesor.php?page=doc_prof&p=' . $i . '" class="active">' . $i . '</a>';
            } else {
                echo '<a href="profesor.php?page=doc_prof&p=' . $i . '">' . $i . '</a>';
            }
        }
        if ($page < $total_pages) {
            echo '<a href="profesor.php?page=doc_prof&p=' . ($page + 1) . '">Următor &raquo;</a>';
        }
        ?>
    </div>
</body>
</html>
