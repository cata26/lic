<?php
include "db_conn.php";
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

$nr_matricol = isset($_POST['nr_matricol']) ? $conn->real_escape_string($_POST['nr_matricol']) : '';
$document_type = isset($_POST['document_type']) ? $conn->real_escape_string($_POST['document_type']) : '';
$document_reason = isset($_POST['document_reason']) ? $conn->real_escape_string($_POST['document_reason']) : '';


if (!$nr_matricol || !$document_type || !$document_reason) {
    die("Toate câmpurile sunt obligatorii.");
} 

$sql = "SELECT name, year, facultate, sectia, tip_invatamant FROM users WHERE nr_matricol = '$nr_matricol'";
$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
  
    $pdf = new TCPDF();
    $pdf->AddPage();
    
    // Încărcare template HTML
    $html = file_get_contents('adeverinta_student.html');
    
    // Înlocuire placeholder-uri cu date reale
    $placeholders = [
        '{{name}}' => $row['name'],
        '{{year}}' => $row['year'],
        '{{facultate}}' => $row['facultate'],
        '{{sectia}}' => $row['sectia'],
        '{{tip}}' => $row['tip_invatamant'],
        '{{document_type}}' => $document_type,
        '{{document_reason}}' => $document_reason
    ];
    foreach ($placeholders as $key => $value) {
        $html = str_replace($key, htmlspecialchars($value), $html);
    }

    // Scrie HTML-ul în PDF
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Definește calea absolută către directorul 'pdf'
    $pdf_dir = __DIR__ . '/pdf/';
    $current_date = date('Ymd');
    $pdf_file_path = $pdf_dir . 'Adeverinta_' . $name . '_'.$current_date. '.pdf';

    // Verifică și creează folderul pdf dacă nu există
    if (!file_exists($pdf_dir)) {
        mkdir($pdf_dir, 0777, true);
    }

    // Salvare PDF pe server în folderul 'pdf'
    $pdf->Output($pdf_file_path, 'F');

 
}
?>
