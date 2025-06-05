<?php
session_start();
if (!isset($_SESSION['logid'])) {
    header('location:index.php'); 
    exit();
}

require_once __DIR__ . '/../config/DatebaseConnector.php';

$logid = $_SESSION['logid'];

// AJAX: oznacz powiadomienie jako przeczytane
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['read_id'])) {
    $note_id = (int)$_POST['read_id'];
    $stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $note_id, $logid);
    $stmt->execute();
    $stmt->close();
    exit();
}

// Pobierz powiadomienia użytkownika
$stmt = $conn->prepare("SELECT id, message, type, is_read, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $logid);
$stmt->execute();
$result = $stmt->get_result();

include __DIR__ . '/../public/notifications_view.php';
?>
