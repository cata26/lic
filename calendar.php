<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="stylesheet" href="style2.css"> <!-- Asigurați-vă că aveți acest fișier CSS -->
</head>
<body>
    <h2><?php echo $numeLuna . " " . date("Y"); ?></h2>
    <table>
        <tr>
            <?php foreach ($zileSaptamana as $zi) { echo "<th>$zi</th>"; } ?>
        </tr>
        <tr>
        <?php
            for ($i = 0; $i < $ziStart; $i++, $cnt++) { echo "<td></td>"; } // Spații goale pentru zilele dinaintea începutului lunii
            for ($zi = 1; $zi <= $numarZile; $zi++, $cnt++) {
                if ($cnt % 7 == 0) { echo "<td>$zi</td></tr><tr>"; } // La fiecare a șaptea celulă, începe un nou rând
                else { echo "<td>$zi</td>"; }
            }
            while ($cnt % 7 != 0) { echo "<td></td>"; $cnt++; } // Completează restul rândului cu celule goale, dacă este necesar
        ?>
        </tr>
    </table>
</body>
</html>
