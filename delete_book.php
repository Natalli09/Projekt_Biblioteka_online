<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['logid'])) {
    header('location:index.php'); 
    exit();
}

// Połączenie z bazą danych
$conn = mysqli_connect('localhost', 'root', '', 'bookstore');

// Pobranie danych użytkownika na podstawie sesji
$logid = $_SESSION['logid'];
$query = "SELECT fname, lname, email FROM sign_up WHERE id_user = '$logid'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
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

// Pobranie ID książki z parametru URL
$bookId = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;

// Sprawdzenie, czy ID książki jest poprawne
if ($bookId <= 0) {
    echo "Nieprawidłowy identyfikator książki.";
    exit();
}

// Usunięcie książki z bazy danych
$sqlDeleteBook = "DELETE FROM books WHERE id_book = ?";
$stmtDeleteBook = $conn->prepare($sqlDeleteBook);
$stmtDeleteBook->bind_param('i', $bookId);

// Wykonanie zapytania
if ($stmtDeleteBook->execute()) {
    // Przekierowanie po udanym usunięciu
    header('Location: genre.php'); // Przekierowanie do listy książek
    exit();
} else {
    echo "Wystąpił problem podczas usuwania książki.";
}

?>
