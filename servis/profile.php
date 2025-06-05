<?php
session_start();
if (!isset($_SESSION['logid'])) {
    header('location:index.php');
    exit();
}

// Połączenie z bazą danych
require_once __DIR__ . '/../config/DatebaseConnector.php';

$logid = $_SESSION['logid'];
$query = "SELECT fname, lname, email, profile_picture FROM sign_up WHERE id_user = '$logid' LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['fname'] = $user['fname'];
    $_SESSION['lname'] = $user['lname'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['profile_picture'] = $user['profile_picture']; // to ma być nazwa pliku, np. 'avatar.jpg' lub NULL
} else {
    header('location:index.php');
    exit();
}
include __DIR__ . '/../public/profile_view.php';
?>
