<?php
// Include Composer's autoloader
require_once 'vendor/autoload.php';

// Include TCPDF library (if not installed via Composer)
// require_once 'path/to/tcpdf.php';

// Date de conectare la baza de date
$dbHost = 'localhost';
$dbName = 'login_db';
$dbUser = 'root';
$dbPass = '';

// Id-ul utilizatorului pentru care se generează PDF-ul
$userId = 1; // Acest ID ar trebui să fie furnizat dinamic, de exemplu prin $_GET sau $_POST

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Interogarea care face join între tabelele 'users' și 'documents'
    $stmt = $pdo->prepare("
        SELECT users.user_name, users.email, documents.tip_document, documents.data
        FROM users
        JOIN documents ON users.id = documents.id_user
        WHERE users.id = :userId
    ");
    
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        // Inițializăm TCPDF
        $pdf = new TCPDF();

        // Setări document
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Admin');
        $pdf->SetTitle('Raport Documente Utilizator');
        $pdf->SetSubject('Raport');
        
        // Adaugă o pagină
        $pdf->AddPage();

        // Construim HTML-ul pentru PDF
        $html = '<h1>Raport Documente</h1>';
        $html .= '<h2>Detalii Utilizator</h2>';
        $html .= '<ul>';
        
        // Adăugăm detaliile utilizatorului - presupunând că avem doar un rând pentru utilizator
        $user = $results[0]; // Presupunem că toate documentele aparțin aceluiași utilizator
        $html .= '<li>Nume: ' . htmlspecialchars($user['name']) . '</li>';
        $html .= '<li>Email: ' . htmlspecialchars($user['email']) . '</li>';
        $html .= '</ul>';

        // Adăugăm detalii despre documente
        $html .= '<h2>Documente</h2>';
        $html .= '<table border="1" cellpadding="4">';
        $html .= '<thead><tr><th>Titlu</th><th>Data Creării</th></tr></thead>';
        $html .= '<tbody>';
        
        foreach ($results as $row) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($row['tip_document']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['data']) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody>';
        $html .= '</table>';

        // Scriem HTML-ul în PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Încheiem și trimitem PDF-ul la browser
        $pdf->Output('user_documents.pdf', 'I');
    } else {
        echo "Nu există documente pentru utilizatorul specificat.";
    }
} catch (PDOException $e) {
    echo "Eroare la conectarea la baza de date: " . $e->getMessage();
}

// Închidem conexiunea la baza de date
$pdo = null;
?>
