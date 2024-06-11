<?php
session_start();
include "db_conn.php";
require_once('vendor/tecnickcom/tcpdf/tcpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_name'])) {
        $username = $_SESSION['user_name'];

        // Preluarea detaliilor studentului din baza de date
        $sql = "SELECT nr_matricol, name, year, facultate, sectia, tip_invatamant, localitate_dom, judet_dom, data_nasterii FROM users_1 WHERE user_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nr_matricol = $row['nr_matricol'];
            $name = $row['name'];
            $year = $row['year'];
            $facultate = $row['facultate'];
            $sectia = $row['sectia'];
            $tip_invatamant = $row['tip_invatamant'];
            $localitate_dom = $row['localitate_dom'];
            $judet_dom = $row['judet_dom'];
            $data_nasterii = $row['data_nasterii'];

            $document_reason = isset($_POST['document_reason']) ? $conn->real_escape_string($_POST['document_reason']) : '';

            if (!$document_reason) {
                $_SESSION['error'] = "Câmpul e obligatoriu.";
            } else {
                // Preluarea datelor din a doua tabelă, 'medii'
                $sql2 = "SELECT nota_admitere, an_admitere, primul_an, primul_an_medie, primul_an_credite, 
                                2_an, 2_an_medie, 2_an_credite, 
                                3_an, 3_an_medie, 3_an_credite, 
                                4_an, 4_an_medie, 4_an_credite, 
                                5_an, 5_an_medie, 5_an_credite, 
                                6_an, 6_an_medie, 6_an_credite 
                         FROM medii WHERE user_name = ?";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bind_param("s", $username);
                $stmt2->execute();
                $result2 = $stmt2->get_result();

                if ($result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();

                    // Inițializarea unui obiect TCPDF
                    $pdf = new TCPDF();
                    $pdf->AddPage();

                    // Încărcare template HTML
                    $html = file_get_contents('adeverinta_student.html');
                    $current_date = date('d.m.Y');

                    // Înlocuire placeholder-uri cu date reale
                    $placeholders = [
                        '{{name}}' => $row['name'],
                        '{{year}}' => $row['year'],
                        '{{facultate}}' => $row['facultate'],
                        '{{sectia}}' => $row['sectia'],
                        '{{tip}}' => $row['tip_invatamant'],
                        '{{loc}}' => $row['localitate_dom'],
                        '{{judet}}' => $row['judet_dom'],
                        '{{data_nasterii}}' => $row['data_nasterii'],
                        '{{document_reason}}' => $document_reason,
                        '{{data}}' => $current_date,
                        // Placeholder-uri pentru datele din tabela 'medii'
                        '{{nota_admitere}}' => $row2['nota_admitere'],
                        '{{an_admitere}}' => $row2['an_admitere'],
                        '{{primul_an}}' => $row2['primul_an'],
                        '{{primul_an_medie}}' => $row2['primul_an_medie'],
                        '{{primul_an_credite}}' => $row2['primul_an_credite'],
                        '{{2_an}}' => $row2['2_an'],
                        '{{2_an_medie}}' => $row2['2_an_medie'],
                        '{{2_an_credite}}' => $row2['2_an_credite'],
                        '{{3_an}}' => $row2['3_an'],
                        '{{3_an_medie}}' => $row2['3_an_medie'],
                        '{{3_an_credite}}' => $row2['3_an_credite'],
                        '{{4_an}}' => $row2['4_an'],
                        '{{4_an_medie}}' => $row2['4_an_medie'],
                        '{{4_an_credite}}' => $row2['4_an_credite'],
                        '{{5_an}}' => $row2['5_an'],
                        '{{5_an_medie}}' => $row2['5_an_medie'],
                        '{{5_an_credite}}' => $row2['5_an_credite'],
                        '{{6_an}}' => $row2['6_an'],
                        '{{6_an_medie}}' => $row2['6_an_medie'],
                        '{{6_an_credite}}' => $row2['6_an_credite'],
                    ];

                    foreach ($placeholders as $key => $value) {
                        $html = str_replace($key, htmlspecialchars($value), $html);
                    }

                    // Scrie HTML-ul în PDF
                    $pdf->writeHTML($html, true, false, true, false, '');

                    // Definește calea către directorul 'pdf'
                    $pdf_dir = __DIR__ . '/pdf/';
                    $pdf_file_path = $pdf_dir . 'Adeverinta_' . $name . '_' . $current_date . '.pdf';

                    // Verifică și creează folderul pdf dacă nu există
                    if (!file_exists($pdf_dir)) {
                        mkdir($pdf_dir, 0777, true);
                    }

                    // Salvare PDF pe server în folderul 'pdf'
                    $pdf->Output($pdf_file_path, 'F');
                    $_SESSION['success'] = "Cererea a fost trimisă cu succes!";
                } else {
                    $_SESSION['error'] = "Nu s-au găsit detalii suplimentare pentru acest utilizator.";
                }
            }

            header("Location: student.php?page=adv");
            exit();
        } else {
            $_SESSION['error'] = "Nu s-a găsit un utilizator cu acest nume.";
        }
    } else {
        $_SESSION['error'] = "Numele de utilizator nu este disponibil în sesiune.";
    }
}
?>
