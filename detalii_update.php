<?php
session_start();
include "db_conn.php";

function validate($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function detalii($conn, $params) {
    $user_name = $params['user_name'];

    $sql = "SELECT * FROM users WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Numele de utilizator nu există în baza de date.";
        return false;
    }

    $sql = "SELECT * FROM medii WHERE user_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Numele de utilizator este deja folosit în medii. Încearcă altceva!";
        return false;
    }

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
        $bind_types .= $type;
        $bind_values[] = $params[$field] ?? null;
    }

    $sql2 = "INSERT INTO medii(" . implode(',', array_keys($fields)) . ") VALUES(" . implode(',', array_fill(0, count($fields), '?')) . ")";
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['user_name'])) {
        $_SESSION['error'] = "Numele de utilizator este obligatoriu.";
        header("Location: admin.php?page=detalii");
        exit();
    }

    $params = array_map('validate', $_POST);

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
