<?php
$dir = "pdf/"; 

// Numărul de înregistrări pe pagină
$records_per_page = 10;

// Determinarea paginii curente
$page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
$offset = ($page - 1) * $records_per_page;

// Obținerea listei de fișiere
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

// Obținerea numărului total de înregistrări
$total_records = count($files);
$total_pages = ceil($total_records / $records_per_page);

// Filtrarea fișierelor pentru pagina curentă
$files = array_slice($files, $offset, $records_per_page);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Adeverințe</title>
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
    <h1>Adeverințe</h1>
    <table>
        <tr>
            <th>Tip document</th>
            <th>Descărcare document</th>
        </tr>
        <?php
        if (count($files) > 0) {
            foreach ($files as $file) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($file) . "</td>";
                echo "<td><a href='$dir$file' target='_blank'>PDF</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Nu există adeverințe disponibile.</td></tr>";
        }
        ?>
    </table>

    <div class="pagination">
        <?php
        if ($page > 1) {
            echo '<a href="secretar.php?page=doc_secretar&p=' . ($page - 1) . '">&laquo; Anterior</a>';
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<a href="secretar.php?page=doc_secretar&p=' . $i . '" class="active">' . $i . '</a>';
            } else {
                echo '<a href="secretar.php?page=doc_secretar&p=' . $i . '">' . $i . '</a>';
            }
        }
        if ($page < $total_pages) {
            echo '<a href="secretar.php?page=doc_secretar&p=' . ($page + 1) . '">Următor &raquo;</a>';
        }
        ?>
    </div>
</div>
</body>
</html>
