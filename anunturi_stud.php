<?php
include "db_conn.php";  // Asigură-te că ai un script de conectare la baza de date

$query = "SELECT * FROM news ORDER BY data DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Anunțuri</title>
    <link rel="stylesheet" href="css/style6.css">
</head>
<body>
    <form>
    <h1>Anunțuri</h1>
    <div class="announcements">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $date = date("d", strtotime($row["data"]));
                $month = date("M", strtotime($row["data"]));
                $year = date("Y", strtotime($row["data"]));
                ?>
                <div class="announcement">
                    <div class="date">
                        <span class="day"><?php echo $date; ?></span>
                        <span class="month-year"><?php echo strtoupper($month) . " " . $year; ?></span>
                    </div>
                    <h2><?php echo htmlspecialchars($row["title"]); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($row["content"])); ?></p>
                </div>
                <?php
            }
        } else {
            echo "Nu există anunțuri.";
        }
        $conn->close();
        ?>
    </div>
    </form>
</body>
</html>
