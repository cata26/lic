<?php
include "db_conn.php";  // Include scriptul de conectare la baza de date

// Funcție pentru a prelua toți studenții din baza de date
$sql = "SELECT nr_matricol, name, user_name, email FROM users WHERE email LIKE '%@student.upt.ro'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista Studenți</title>
    <link rel="stylesheet" type="text/css" href="css/style5.css">
    <link rel="icon" href="upt.png" type="image/x-icon">
</head>
<body>
<?php 
if (isset($_SESSION['error'])) { ?>
    <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php } ?>

<?php if (isset($_SESSION['success'])) { ?>
    <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php } ?>
    <h2>Lista Studenți</h2>
    <table>
        <tr>
            <th>Număr Matricol</th>
            <th>Nume</th>
            <th>Username</th>
            <th>Email</th>
            <th></th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Afișează fiecare student într-un rând al tabelului
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nr_matricol']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>
                        <form method='post' action='delete.php' style='display:inline-block;'>
                            <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['nr_matricol']) . "'>
                            <button type='submit'>Șterge</button>
                        </form>
                        <form style='display:inline;' method='get' action='update.php'>
                            <input type='hidden' name='nr_matricol' value='" . htmlspecialchars($row['nr_matricol']) . "'>
                            <button type='submit' class='update-btn'>Actualizează</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nu există studenți în baza de date.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
