<?php
session_start();
include "db_conn.php";

function validate($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function detalii($conn, $params) {
    
    $sql = "SELECT * FROM users WHERE user_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $params['user_name']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Numele de utilizator nu există în baza de date.";
        return false;
    }

    // Check if user_name already exists in the medii table
    $sql = "SELECT * FROM medii WHERE user_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $params['user_name']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Numele de utilizator este deja folosit în medii. Încearcă altceva!";
        return false;
    } else {
        $fields = [
            'user_name' => 's',
            'nota_admitere' => 'd',
            'an_admitere' => 'i',
            'primul_an' => 's',
            'primul_an_medie' => 'd',
            'primul_an_credite' => 'i',
            'an_2' => 's',
            'an_2_medie' => 'd',
            'an_2_credite' => 'i',
            'an_3' => 's',
            'an_3_medie' => 'd',
            'an_3_credite' => 'i',
            'an_4' => 's',
            'an_4_medie' => 'd',
            'an_4_credite' => 'i',
            'an_5' => 's',
            'an_5_medie' => 'd',
            'an_5_credite' => 'i',
            'an_6' => 's',
            'an_6_medie' => 'd',
            'an_6_credite' => 'i',
            'bursa' => 'i',
            'nr_semestre_bursa' => 'i'
        ];

        $bind_types = '';
        $bind_values = [];
        foreach ($fields as $field => $type) {
            if (isset($params[$field])) {
                $bind_types .= $type;
                $bind_values[] = $params[$field];
            } else {
                $bind_types .= $type;
                $bind_values[] = null;
            }
        }

        $sql2 = "INSERT INTO medii(user_name, nota_admitere, an_admitere, primul_an, primul_an_medie, primul_an_credite, an_2, an_2_medie, an_2_credite, an_3, an_3_medie, an_3_credite, an_4, an_4_medie, an_4_credite, an_5, an_5_medie, an_5_credite, an_6, an_6_medie, an_6_credite,bursa,nr_semestre_bursa) VALUES(" . implode(',', array_fill(0, count($fields), '?')) . ")";
        $stmt2 = $conn->prepare($sql2);
        if (!$stmt2) {
            error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            return false;
        }

        $stmt2->bind_param($bind_types, ...$bind_values);

        if ($stmt2->execute()) {
            $_SESSION['success'] = "Datele au fost introduse cu succes!";
            return true;
        } else {
            error_log("Execute failed: (" . $stmt2->errno . ") " . $stmt2->error);
            $_SESSION['error'] = "A apărut o eroare necunoscută.";
            return false;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['user_name']) || empty($_POST['user_name'])) {
        $_SESSION['error'] = "Numele de utilizator este obligatoriu.";
        header("Location: admin.php?page=detalii");
        exit();
    }

    $params = [];
    $params['user_name'] = validate($_POST['user_name']);
    $params['nota_admitere'] = isset($_POST['nota_admitere']) ? validate($_POST['nota_admitere']) : null;
    $params['an_admitere'] = isset($_POST['an_admitere']) ? validate($_POST['an_admitere']) : null;
    $params['primul_an'] = isset($_POST['primul_an']) ? validate($_POST['primul_an']) : null;
    $params['primul_an_medie'] = isset($_POST['primul_an_medie']) ? validate($_POST['primul_an_medie']) : null;
    $params['primul_an_credite'] = isset($_POST['primul_an_credite']) ? validate($_POST['primul_an_credite']) : null;
    $params['an_2'] = isset($_POST['an_2']) ? validate($_POST['an_2']) : null;
    $params['an_2_medie'] = isset($_POST['an_2_medie']) ? validate($_POST['an_2_medie']) : null;
    $params['an_2_credite'] = isset($_POST['an_2_credite']) ? validate($_POST['an_2_credite']) : null;
    $params['an_3'] = isset($_POST['an_3']) ? validate($_POST['an_3']) : null;
    $params['an_3_medie'] = isset($_POST['an_3_medie']) ? validate($_POST['an_3_medie']) : null;
    $params['an_3_credite'] = isset($_POST['an_3_credite']) ? validate($_POST['an_3_credite']) : null;
    $params['an_4'] = isset($_POST['an_4']) ? validate($_POST['an_4']) : null;
    $params['an_4_medie'] = isset($_POST['an_4_medie']) ? validate($_POST['an_4_medie']) : null;
    $params['an_4_credite'] = isset($_POST['an_4_credite']) ? validate($_POST['an_4_credite']) : null;
    $params['an_5'] = isset($_POST['an_5']) ? validate($_POST['an_5']) : null;
    $params['an_5_medie'] = isset($_POST['an_5_medie']) ? validate($_POST['an_5_medie']) : null;
    $params['an_5_credite'] = isset($_POST['an_5_credite']) ? validate($_POST['an_5_credite']) : null;
    $params['an_6'] = isset($_POST['an_6']) ? validate($_POST['an_6']) : null;
    $params['an_6_medie'] = isset($_POST['an_6_medie']) ? validate($_POST['an_6_medie']) : null;
    $params['an_6_credite'] = isset($_POST['an_6_credite']) ? validate($_POST['an_6_credite']) : null;
    $params['bursa'] = isset($_POST['bursa']) ? validate($_POST['bursa']) : null;
    $params['nr_semestre_bursa'] = isset($_POST['nr_semestre_bursa']) ? validate($_POST['nr_semestre_bursa']) : null;

    if (detalii($conn, $params)) {
        header("Location: admin.php?page=detalii");
        exit();
    } else {
        header("Location: admin.php?page=detalii");
        exit();
    }
} else {
    header("Location: admin.php?page=detalii");
    exit();
}
?>
