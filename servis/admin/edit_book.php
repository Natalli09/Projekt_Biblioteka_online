<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['logid'])) {
    header('location:index.php'); 
    exit();
}

// Połączenie z bazą danych
require_once __DIR__ . '/../../config/DatebaseConnector.php';

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
    echo "Access denied: Only the librarian can edit books.";
    exit;
}

// Sprawdź, czy mamy ID książki do edytowania
if (!isset($_GET['book_id'])) {
    header('location:index.php'); 
    exit();
}

$book_id = $_GET['book_id'];

// Pobierz dane książki z bazy danych
$query = "SELECT * FROM books WHERE id_book = '$book_id'";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $book = mysqli_fetch_assoc($result);
} else {
    echo "Książka nie istnieje!";
    exit();
}

// Edytowanie książki
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'] ?? '';
    $description = $_POST['description'] ?? '';
    $published_year = $_POST['published_year'] ?? null;
    $cover_image = $book['cover_image']; // Domyślnie zachowujemy starą okładkę
    $book_file = $book['book_file']; // Domyślnie zachowujemy stary plik książki

    // Obrobienie przesyłania nowej okładki
    if (!empty($_FILES['cover_image']['name'])) {
        $target_dir = "../uploads/";
        $unique_name = uniqid() . "_" . basename($_FILES['cover_image']['name']);
        $cover_image = $target_dir . $unique_name;

        if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $cover_image)) {
            die("Błąd podczas przesyłania okładki!");
        }
    }

    // Obrobienie przesyłania nowego pliku książki
    if (!empty($_FILES['book_file']['name'])) {
        $target_dir = "../uploads/";
        $unique_file_name = uniqid() . "_" . basename($_FILES['book_file']['name']);
        $book_file = $target_dir . $unique_file_name;

        // Sprawdzanie typu pliku
        $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (!in_array($_FILES['book_file']['type'], $allowed_types)) {
            die("Nieprawidłowy format pliku! Akceptowane: PDF, DOC, DOCX.");
        }

        if (!move_uploaded_file($_FILES['book_file']['tmp_name'], $book_file)) {
            die("Błąd podczas przesyłania pliku książki!");
        }
    }

    // Aktualizacja książki w bazie danych
    if (!empty($title) && !empty($author)) {
        $sql = "UPDATE books 
                SET title = ?, author = ?, genre = ?, description = ?, cover_image = ?, published_year = ?, book_file = ? 
                WHERE id_book = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssssisi", $title, $author, $genre, $description, $cover_image, $published_year, $book_file, $book_id);
        
            if ($stmt->execute()) {
                $success_message = "Książka została zaktualizowana pomyślnie!";
            } else {
                $error_message = "Błąd podczas aktualizacji książki: " . $stmt->error;
            }
        
            $stmt->close();
        } else {
            $error_message = "Błąd podczas przygotowywania zapytania: " . $conn->error;
        }
    } else {
        $error_message = "Tytuł i autor są wymagane!";
    }
}
include __DIR__ . '/../../public/admin_view/edit_book_view.php';

?>