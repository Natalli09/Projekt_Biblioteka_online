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
    echo "Access denied: Only the librarian can add books.";
    exit;
}

// Dodawanie książki do bazy danych
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'] ?? '';
    $description = $_POST['description'] ?? '';
    $published_year = $_POST['published_year'] ?? null;
    $cover_image = null;
    $book_file = null;

    // Upload okładki
    if (!empty($_FILES['cover_image']['name'])) {
        $target_dir = "../uploads/";
        $unique_name = uniqid() . "_" . basename($_FILES['cover_image']['name']);
        $cover_image = $target_dir . $unique_name;

        if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $cover_image)) {
            die("Błąd podczas przesyłania okładki!");
        }
    }

    // Upload pliku książki
    if (!empty($_FILES['book_file']['name'])) {
        $target_dir = "../uploads/";
        $unique_file_name = uniqid() . "_" . basename($_FILES['book_file']['name']);
        $book_file = $target_dir . $unique_file_name;

        $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (!in_array($_FILES['book_file']['type'], $allowed_types)) {
            die("Nieprawidłowy format pliku! Akceptowane: PDF, DOC, DOCX.");
        }

        if (!move_uploaded_file($_FILES['book_file']['tmp_name'], $book_file)) {
            die("Błąd podczas przesyłania pliku książki!");
        }
    }

    // Dodanie książki do bazy
    if (!empty($title) && !empty($author)) {
        $sql = "INSERT INTO books (title, author, genre, description, cover_image, published_year, book_file) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssssis", $title, $author, $genre, $description, $cover_image, $published_year, $book_file);
        
            if ($stmt->execute()) {
                $success_message = "Książka została dodana pomyślnie!";

                // 🔔 Wysłanie powiadomień do wszystkich użytkowników
                $notification_message = "Nowa książka \"" . $title . "\" została dodana do biblioteki!";
                $users_result = $conn->query("SELECT id_user FROM sign_up");

                if ($users_result && $users_result->num_rows > 0) {
                    $notify_stmt = $conn->prepare("INSERT INTO notifications (user_id, message, type) VALUES (?, ?, 'info')");

                    while ($user_row = $users_result->fetch_assoc()) {
                        $user_id = $user_row['id_user'];
                        $notify_stmt->bind_param("is", $user_id, $notification_message);
                        $notify_stmt->execute();
                    }

                    $notify_stmt->close();
                }

            } else {
                $error_message = "Błąd podczas dodawania książki: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error_message = "Błąd podczas przygotowywania zapytania: " . $conn->error;
        }
    } else {
        $error_message = "Tytuł i autor są wymagane!";
    }
}
include __DIR__ . '/../../public/admin_view/add_book_view.php';

?>

