<?php
            $target_dir = "student_documents/";
            $nr_matricol = isset($_POST['nr_matricol']) ? $_POST['nr_matricol'] : null;
            $fileName = isset($_FILES['fileToUpload']['name']) ? $_FILES['fileToUpload']['name'] : null;
            $fileTmpName = isset($_FILES['fileToUpload']['tmp_name']) ? $_FILES['fileToUpload']['tmp_name'] : null;

            if ($nr_matricol && $fileName && $fileTmpName) {
                $target_dir .= $nr_matricol . '/';
                $target_file = $target_dir . basename($fileName);

                // Creează directorul dacă nu există
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                // Verifică dacă fișierul există deja
                if (file_exists($target_file)) {
                    echo "<p>Ne pare rău, fișierul există deja.</p>";
                } else {
                    // Încearcă să încarce fișierul
                    if (move_uploaded_file($fileTmpName, $target_file)) {
                        echo "<p>Fișierul ". htmlspecialchars($fileName) . " a fost încărcat.</p>";
                    } else {
                        echo "<p>Ne pare rău, a fost o eroare la încărcarea fișierului tău.</p>";
                    }
                }
            }

?>