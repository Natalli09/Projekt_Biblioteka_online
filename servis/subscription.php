<?php
session_start();
if (!isset($_SESSION['logid'])) {
    header('location:index.php');
    exit();
}

require_once __DIR__ . '/../config/DatebaseConnector.php';

$logid = $_SESSION['logid'];
$message = "";

// Obsługa subskrypcji
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plan'])) {
    $plan = $_POST['plan'];

    if ($plan !== 'free') {
        // Sprawdź, czy użytkownik ma kartę
        $cardCheck = $conn->prepare("SELECT id_karta FROM karty WHERE id_user = ? LIMIT 1");
        $cardCheck->bind_param("i", $logid);
        $cardCheck->execute();
        $cardCheck->store_result();

        if ($cardCheck->num_rows === 0) {
            $cardCheck->close();
            // Przekieruj do formularza dodania karty
            header('Location: karta.php?redirect=subscription.php');
            exit();
        }

        $cardCheck->close();
    }

    // Zapisz subskrypcję
    $stmt = $conn->prepare("REPLACE INTO subscriptions (user_id, plan, subscribed_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $logid, $plan);
    if ($stmt->execute()) {
        $message = "Pomyślnie zasubskrybowano plan: <strong>" . htmlspecialchars($plan) . "</strong>!";
    } else {
        $message = "Błąd: " . $stmt->error;
    }
    $stmt->close();
}

include __DIR__ . '/../public/subscription_view.php';
?>
