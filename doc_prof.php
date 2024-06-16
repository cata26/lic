<?php
include "db_conn.php";

function getUserMatricol($conn, $username) {
    $sql = "SELECT nr_matricol FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $nr_matricol = null;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nr_matricol = $row['nr_matricol'];
    }
    $stmt->close();

    return $nr_matricol;
}

function getTotalRecords($dir) {
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
    }

    return $total_records;
}

function listDocuments($dir, $offset, $records_per_page) {
    $documents = [];
    $document_count = 0;
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != "." && $file != ".." && strtolower(substr($file, strrpos($file, '.') + 1)) == 'pdf') {
                    if ($document_count >= $offset && $document_count < $offset + $records_per_page) {
                        $documents[] = $file;
                    }
                    $document_count++;
                }
            }
            closedir($dh);
        }
    }

    return $documents;
}

if (!isset($_SESSION['user_name'])) {
    echo "Numele de utilizator nu este disponibil în sesiune.";
    exit();
}

$username = $_SESSION['user_name'];
$nr_matricol = getUserMatricol($conn, $username);

if (!$nr_matricol) {
    echo "Nu s-a găsit un număr de matricol pentru utilizatorul $username.";
    exit();
}

$records_per_page = 5;
$page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
$offset = ($page - 1) * $records_per_page;
$dir = "student_documents/" . $nr_matricol;
$total_records = getTotalRecords($dir);
$total_pages = ceil($total_records / $records_per_page);
$documents = listDocuments($dir, $offset, $records_per_page);
?>
