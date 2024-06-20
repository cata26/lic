<?php
session_start();
include "db_conn.php";
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

function userInfo($conn, $uname) {
    $sql = "SELECT nr_matricol, name, an, facultate, sectia, tip_invatamant, localitate_dom, judet_dom, data_nasterii FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result->fetch_assoc();
}

function userextraInfo($conn, $uname) {
    $sql = "SELECT nota_admitere, an_admitere, primul_an, primul_an_medie, primul_an_credite, 
                   an_2, an_2_medie, an_2_credite, 
                   an_3, an_3_medie, an_3_credite, 
                   an_4, an_4_medie, an_4_credite, 
                   an_5, an_5_medie, an_5_credite, 
                   an_6, an_6_medie, an_6_credite,bursa,nr_semestre_bursa
            FROM medii WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result->fetch_assoc();
}

function generatePDF($userData, $userdetails, $document_reason, $html_template) {
    $pdf = new TCPDF();
    $pdf->AddPage();
    $html = file_get_contents($html_template);
    $current_date = date('d.m.Y');
    $current_date_time = date('d.m.Y_H-i-s');

    $placeholders = [
        '{{name}}' => $userData['name'],
        '{{year}}' => $userData['an'],
        '{{facultate}}' => $userData['facultate'],
        '{{sectia}}' => $userData['sectia'],
        '{{tip}}' => $userData['tip_invatamant'],
        '{{loc}}' => $userData['localitate_dom'],
        '{{judet}}' => $userData['judet_dom'],
        '{{data_nasterii}}' => $userData['data_nasterii'],
        '{{document_reason}}' => $document_reason,
        '{{data}}' => $current_date,
        '{{nota_admitere}}' => $userdetails['nota_admitere'] ?? '',
        '{{an_admitere}}' => $userdetails['an_admitere'] ?? '',
        '{{primul_an}}' => $userdetails['primul_an'] ?? '',
        '{{primul_an_medie}}' => $userdetails['primul_an_medie'] ?? '',
        '{{primul_an_credite}}' => $userdetails['primul_an_credite'] ?? '',
        '{{2_an}}' => $userdetails['an_2'] ?? '',
        '{{2_an_medie}}' => $userdetails['an_2_medie'] ?? '',
        '{{2_an_credite}}' => $userdetails['an_2_credite'] ?? '',
        '{{3_an}}' => $userdetails['an_3'] ?? '',
        '{{3_an_medie}}' => $userdetails['an_3_medie'] ?? '',
        '{{3_an_credite}}' => $userdetails['an_3_credite'] ?? '',
        '{{4_an}}' => $userdetails['an_4'] ?? '',
        '{{4_an_medie}}' => $userdetails['an_4_medie'] ?? '',
        '{{4_an_credite}}' => $userdetails['an_4_credite'] ?? '',
        '{{5_an}}' => $userdetails['an_5'] ?? '',
        '{{5_an_medie}}' => $userdetails['an_5_medie'] ?? '',
        '{{5_an_credite}}' => $userdetails['an_5_credite'] ?? '',
        '{{6_an}}' => $userdetails['an_6'] ?? '',
        '{{6_an_medie}}' => $userdetails['an_6_medie'] ?? '',
        '{{6_an_credite}}' => $userdetails['an_6_credite'] ?? '',
        '{{bursa}}' => $userdetails['bursa'] ?? '',
        '{{nr_semestre_bursa}}' => $userdetails['nr_semestre_bursa'] ?? '',
    ];

    foreach ($placeholders as $key => $value) {
        $html = str_replace($key, htmlspecialchars($value), $html);
    }

    $pdf->writeHTML($html);

    $pdf_dir = __DIR__ . '/pdf/';
    $pdf_name = $pdf_dir . 'Adeverinta_' . $userData['name'] . '_' . $current_date_time . '.pdf';

    if (!file_exists($pdf_dir)) {
        mkdir($pdf_dir, 0777, true);
    }

    $pdf->Output($pdf_name, 'F');

    return $pdf_name;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_name'])) {
        $username = $_SESSION['user_name'];
        $userData = userInfo($conn, $username);
        $document_reason = isset($_POST['document_reason']) ? $conn->real_escape_string($_POST['document_reason']) : '';

        if (!$document_reason) {
            $_SESSION['error'] = "Câmpul e obligatoriu.";
            header("Location: student.php?page=adv");
            exit();
        }

        $html_template = $document_reason === 'alta facultate' ? 'adeverinta_student2.html' : 'adeverinta_student.html';

        if ($userData) {
            $userGrades = userextraInfo($conn, $username);
            $pdf_file_path = generatePDF($userData, $userGrades ?? [], $document_reason, $html_template);
            $_SESSION['success'] = "Cererea a fost trimisă cu succes!";
            header("Location: student.php?page=adv");
            exit();
        } else {
            $_SESSION['error'] = "Nu s-a găsit un utilizator cu acest nume.";
            header("Location: student.php?page=adv");
            exit();
        }
    } else {
        $_SESSION['error'] = "Numele de utilizator nu este disponibil în sesiune.";
        header("Location: student.php?page=adv");
        exit();
    }
}
?>
