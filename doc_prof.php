<?php
include "db_conn.php";

function getDocuments($dir, $offset, $records_per_page) {
    $files = [];
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'pdf') {
                    $files[] = $file;
                }
            }
            closedir($dh);
        }
    }
    $total_records = count($files);
    $total_pages = ceil($total_records / $records_per_page);
    $files = array_slice($files, $offset, $records_per_page);

    return [$files, $total_records, $total_pages];
}

if (!isset($_SESSION['user_name'])) {
    echo "Numele de utilizator nu este disponibil în sesiune.";
    exit();
}

$username = $_SESSION['user_name'];

$records_per_page = 5;
$page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
$offset = ($page - 1) * $records_per_page;
$dir = "documents/" . $username;

list($documents, $total_records, $total_pages) = getDocuments($dir, $offset, $records_per_page);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Documente Generate</title>
    <link rel="stylesheet" href="css/style5.css">
</head>
<body>
<div class="container">
    <h1>Documente Generate</h1>
    <table>
        <tr>
            <th>Tip document</th>
            <th>Descarcare document</th>
        </tr>
        <?php
        if (count($documents) > 0) {
            foreach ($documents as $file) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($file) . "</td>";
                echo "<td><a href='$dir/$file' target='_blank'>PDF</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Nu există documente pentru acest utilizator.</td></tr>";
        }
        ?>
    </table>

    <div class="pagination-container">
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
    </div>
</div>
</body>
</html>
