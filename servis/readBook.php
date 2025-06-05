<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['logid'])) {
    header('location:index.php');
    exit();
}

// Połączenie z bazą danych
require_once __DIR__ . '/../config/DatebaseConnector.php';

// Pobranie ID książki z parametru URL
$bookId = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;

if ($bookId <= 0) {
    echo "Nieprawidłowy identyfikator książki.";
    exit();
}

// Pobranie szczegółów książki z bazy danych
$sql = "SELECT title, author, genre, cover_image, book_file, description, published_year, created_at FROM books WHERE id_book = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $bookId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $book = $result->fetch_assoc();
} else {
    echo "Książka nie została znaleziona.";
    exit();
}

// Obliczanie średniej oceny dla książki
$sqlAvgRating = "SELECT AVG(rating) AS avg_rating FROM reviews WHERE id_book = ?";
$stmtAvgRating = $conn->prepare($sqlAvgRating);
$stmtAvgRating->bind_param('i', $bookId);
$stmtAvgRating->execute();
$resultAvgRating = $stmtAvgRating->get_result();
$avgRating = 0;

if ($row = $resultAvgRating->fetch_assoc()) {
    $avgRating = $row['avg_rating'];
}

// Sprawdzenie, czy książka jest już w archiwum
$idUser = $_SESSION['logid'];
$sqlCheck = "SELECT * FROM archive WHERE id_user = ? AND id_book = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param('ii', $idUser, $bookId);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();
$isBookInArchive = $resultCheck->num_rows > 0;

// Obsługa formularza oceny i komentarza
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
    $rating = intval($_POST['rating']);
    $comment = trim($conn->real_escape_string($_POST['comment']));

    if ($rating < 1 || $rating > 5) {
        echo "<p style='color:red;'>Ocena musi być w zakresie od 1 do 5.</p>";
    } else {
        $sqlReview = "INSERT INTO reviews (id_user, id_book, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmtReview = $conn->prepare($sqlReview);
        $stmtReview->bind_param('iiis', $idUser, $bookId, $rating, $comment);

        if ($stmtReview->execute()) {
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        } else {
            echo "<p style='color:red;'>Wystąpił problem podczas zapisywania opinii.</p>";
        }
    }
}

// Obsługa formularza dodania do archiwum
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['category']) && !isset($_POST['submit_review'])) {
    $category = $_POST['category'];

    $sqlAdd = "INSERT INTO archive (id_user, id_book, category) VALUES (?, ?, ?)";
    $stmtAdd = $conn->prepare($sqlAdd);
    $stmtAdd->bind_param('iis', $idUser, $bookId, $category);
    if ($stmtAdd->execute()) {
        echo "<p class='alert alert-success'>Książka została dodana do archiwum w kategorii '" . htmlspecialchars($category) . "'.</p>";
        $isBookInArchive = true;
    } else {
        echo "<p class='alert alert-danger'>Wystąpił problem przy dodawaniu książki do archiwum.</p>";
    }
}

// Pobieranie wszystkich recenzji dla książki
$sqlReviews = "SELECT r.rating, r.comment, r.created_at, u.fname FROM reviews r JOIN sign_up u ON r.id_user = u.id_user WHERE r.id_book = ? ORDER BY r.created_at DESC";
$stmtReviews = $conn->prepare($sqlReviews);
$stmtReviews->bind_param('i', $bookId);
$stmtReviews->execute();
$reviewsResult = $stmtReviews->get_result();

$conn->close();

// Ścieżki do plików - folder uploads jest w katalogu głównym projektu,
// a ten skrypt jest w katalogu "servis", więc musimy dać '../uploads/'
$coverPath = '../uploads/' . basename($book['cover_image']);
$bookFilePath = '../uploads/' . basename($book['book_file']);

include __DIR__ . '/../public/readBook_view.php';
?>

