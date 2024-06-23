<?php

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Adeverințe</title>
    <link rel="stylesheet" type="text/css" href="css/style5.css">
</head>
<body>
<div class="container list">
    <h1>Adeverințe</h1>
    <table>
        <tr>
            <th>Tip document</th>
            <th>Descărcare document</th>
        </tr>
        <?php
        include "db_conn.php";
        
        function getPdfFiles($dir, $offset, $records_per_page) {
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

        $dir = "pdf/";
        $records_per_page = 10;
        $page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($page - 1) * $records_per_page;

        list($files, $total_records, $total_pages) = getPdfFiles($dir, $offset, $records_per_page);

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

<?php
} else {
   header("Location: index.php");
   exit();
}
?>