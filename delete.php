<?php
include "db_conn.php";  // Include scriptul de conectare la baza de date

// Funcție pentru a șterge utilizatorul din baza de date
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $nr_matricol = $_POST['delete_id'];

    // Pregătește declarația SQL pentru a preveni SQL injection
    $sql = "DELETE FROM users WHERE nr_matricol = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Eroare la pregătirea interogării SQL: " . $conn->error);
    }
    
    // Utilizează "s" dacă nr_matricol este de tip text, altfel folosește "i" dacă este integer
    $stmt->bind_param("s", $nr_matricol);

    if ($stmt->execute()) {
        echo "Utilizatorul cu numărul matricol $nr_matricol a fost șters cu succes.";
    } else {
        echo "A apărut o eroare la ștergerea utilizatorului: " . $stmt->error;
    }

    $stmt->close();
}

// Funcție pentru a prelua toți studenții din baza de date
$sql = "SELECT nr_matricol, name, user_name, email FROM users WHERE email LIKE '%@student.upt.ro'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista Studenți</title>
    <link rel="stylesheet" type="text/css" href="css/style5.css">
</head>
<body>
    <h2>Lista Studenți</h2>
    <table>
        <tr>
            <th>Număr Matricol</th>
            <th>Nume</th>
            <th>Nume Utilizator</th>
            <th>Email</th>
            <th>Acțiune</th>
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
                        <form method='post' style='display:inline-block;'>
                            <input type='hidden' name='delete_id' value='" . htmlspecialchars($row['nr_matricol']) . "'>
                            <button type='submit'>Șterge</button>
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
