<!DOCTYPE html>
<html lang="ro">
<body>
    <h1>Documente Generate</h1>
    <table>
        <tr>
            <th>Tip document</th>
            <th>Descarcare document</th>
        </tr>

        <?php
$dir = "pdf/"; 
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'pdf') {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($file) . "</td>";
                echo "<td><a href='$dir$file' target='_blank'>PDF</a></td>";
                echo "</tr>";
            }
        }
        closedir($dh);
    }
}
?>
    </table>
</body>
</html>
