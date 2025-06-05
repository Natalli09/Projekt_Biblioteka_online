<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['logid'])) {
    header('location:index.php'); 
    exit();
}

// Połączenie z bazą danych
require_once __DIR__ . '/../../config/DatebaseConnector.php';

// Pobranie danych użytkownika
$logid = $_SESSION['logid'];
$query = "SELECT fname, lname, email FROM sign_up WHERE id_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $logid);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['fname'] = $user['fname'];
    $_SESSION['lname'] = $user['lname'];
    $_SESSION['email'] = $user['email'];
} else {
    header('location:index.php'); 
    exit();
}

// Sprawdź, czy użytkownik ma uprawnienia
if (!$user || $user['fname'] !== 'Nataliia') {
    header("HTTP/1.1 403 Forbidden");
    echo "Access denied: Only the librarian can add books.";
    exit;
}

// Pobranie ID książki
$bookId = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;

if ($bookId <= 0) {
    echo "Nieprawidłowy identyfikator książki.";
    exit();
}

// Usuń recenzje powiązane z książką
$sqlDeleteReviews = "DELETE FROM reviews WHERE id_book = ?";
$stmtDeleteReviews = $conn->prepare($sqlDeleteReviews);
$stmtDeleteReviews->bind_param('i', $bookId);
$stmtDeleteReviews->execute();

// Usuń książkę
$sqlDeleteBook = "DELETE FROM books WHERE id_book = ?";
$stmtDeleteBook = $conn->prepare($sqlDeleteBook);
$stmtDeleteBook->bind_param('i', $bookId);

if ($stmtDeleteBook->execute()) {
    header('Location: genre.php');
    exit();
} else {
    echo "Wystąpił problem podczas usuwania książki.";
}
?>
