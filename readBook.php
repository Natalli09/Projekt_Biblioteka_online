<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['logid'])) {
    header('location:index.php'); 
    exit();
}

// Połączenie z bazą danych
$conn = new mysqli('localhost', 'root', '', 'bookstore');
if ($conn->connect_error) {
    die("Połączenie z bazą danych nie powiodło się: " . $conn->connect_error);
}

// Pobranie ID książki z parametru URL
$bookId = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;

// Sprawdzenie, czy ID książki jest poprawne
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
$avgRating = 0; // Domyślnie brak ocen

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

$idUser = $_SESSION['logid'];

// Obsługa formularza oceny i komentarza
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
    $rating = intval($_POST['rating']);
    $comment = trim($conn->real_escape_string($_POST['comment']));

    if ($rating < 1 || $rating > 5) {
        echo "Ocena musi być w zakresie od 1 do 5.";
    } else {
        $sqlReview = "INSERT INTO reviews (id_user, id_book, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmtReview = $conn->prepare($sqlReview);
        $stmtReview->bind_param('iiis', $idUser, $bookId, $rating, $comment);

        if ($stmtReview->execute()) {
            // Przekierowanie po udanym zapisaniu recenzji
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit(); // Zatrzymanie dalszego przetwarzania
        } else {
            echo "Wystąpił problem podczas zapisywania opinii.";
        }
    }
}
// Pobieranie wszystkich recenzji dla książki
$sqlReviews = "SELECT r.rating, r.comment, r.created_at, u.fname FROM reviews r JOIN sign_up u ON r.id_user = u.id_user WHERE r.id_book = ? ORDER BY r.created_at DESC";
$stmtReviews = $conn->prepare($sqlReviews);
$stmtReviews->bind_param('i', $bookId);
$stmtReviews->execute();
$reviewsResult = $stmtReviews->get_result();

// Zamknięcie połączenia z bazą danych
$conn->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['category'])) {
    // Po kliknięciu przycisku dodajemy książkę do odpowiedniej kategorii w archiwum
    $category = $_POST['category'];

    // Ponowne połączenie z bazą danych, aby dodać książkę do archiwum
    $conn = new mysqli('localhost', 'root', '', 'bookstore');
    if ($conn->connect_error) {
        die("Połączenie z bazą danych nie powiodło się: " . $conn->connect_error);
    }

    // Dodanie książki do archiwum
    $sqlAdd = "INSERT INTO archive (id_user, id_book, category) VALUES (?, ?, ?)";
    $stmtAdd = $conn->prepare($sqlAdd);
    $stmtAdd->bind_param('iis', $idUser, $bookId, $category);
    if ($stmtAdd->execute()) {
        echo "Książka została dodana do archiwum w kategorii '$category'.";
    } else {
        echo "Wystąpił problem przy dodawaniu książki do archiwum.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Czytaj książkę: <?= htmlspecialchars($book['title']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
            background-color: #f4f4f9;
        }

        .book-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .book-header h1 {
            font-size: 28px;
            color: #333;
        }

        .book-content {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            background: #fff;
        }

        .book-cover img {
            width: 100%;
            max-width: 300px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .back-button {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .archive-buttons {
            margin-top: 20px;
            text-align: center;
        }

        .archive-buttons .btn {
            margin: 5px;
        }

        .download-button {
            margin-top: 20px;
            text-align: center;
        }
        .reviews-section {
            margin-top: 30px;
        }

        .review {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .review:last-child {
            border-bottom: none;
        }

        .rating {
            color: #f39c12;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="back-button">
        <a href="archive.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Powrót</a>
    </div>

    <div class="book-header">
        <div class="book-cover">
            <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="Okładka książki">
        </div>
        <h1><?= htmlspecialchars($book['title']) ?></h1>
        <p>Autor: <?= htmlspecialchars($book['author']) ?></p>
        <p>Gatunek: <?= htmlspecialchars($book['genre']) ?></p>
        <p>Opis: <?= !empty($book['description']) ? htmlspecialchars($book['description']) : 'Brak opisu.' ?></p>
        <p>Data publikacji: <?= !empty($book['published_year']) ? htmlspecialchars($book['published_year']) : 'Brak daty publikacji.' ?></p>
        <p>Średnia ocena: 
        <?php if ($avgRating): ?>
            <?php 
                $roundedRating = round($avgRating); // Zaokrąglamy średnią ocenę do najbliższej liczby całkowitej
                for ($i = 1; $i <= 5; $i++): 
                    if ($i <= $roundedRating): 
            ?>
                        <i class="fas fa-star" style="color: #f39c12;"></i> <!-- Wypełniona gwiazdka -->
                    <?php else: ?>
                        <i class="far fa-star" style="color: #f39c12;"></i> <!-- Pusta gwiazdka -->
                    <?php endif; ?>
                <?php endfor; ?>
            <?php else: ?>
                Brak ocen
            <?php endif; ?>
        </p>
    </div>

    <div class="text-center">
        <?php if (isset($_SESSION['fname']) && $_SESSION['fname'] === 'Nataliia'): ?>
            <a href="edit_book.php?book_id=<?= $bookId ?>" class="btn btn-primary" style="margin-top: 20px;">
                <i class=></i> Edytuj książkę
            </a>
        <?php endif; ?>
    </div>

    <div class="text-center">
        <?php if (isset($_SESSION['fname']) && $_SESSION['fname'] === 'Nataliia'): ?>
            <a href="delete_book.php?book_id=<?= $bookId ?>" class="btn btn-primary" style="margin-top: 20px;">
                <i class="fas fa-trash"></i> Usuń książkę
            </a>
        <?php endif; ?>
    </div>

    <div class="book-content">
        <?php if ($book['book_file']) { ?>
            <iframe src="<?= htmlspecialchars($book['book_file']) ?>" width="100%" height="1500px" frameborder="0"></iframe>
        <?php } else { ?>
            <p>Plik z treścią książki nie jest dostępny.</p>
        <?php } ?>
    </div>

    <!-- Button to download the book -->
    <?php if ($book['book_file']) { ?>
        <div class="download-button">
            <a href="<?= htmlspecialchars($book['book_file']) ?>" download class="btn btn-success">Pobierz książkę</a>
        </div>
    <?php } ?>

    <?php if (!$isBookInArchive) { ?>
        <div class="archive-buttons">
            <form method="POST">
                <button type="submit" name="category" value="Ulubione" class="btn btn-success">Dodaj do Ulubionych</button>
                <button type="submit" name="category" value="Gotowe" class="btn btn-warning">Dodaj do Gotowych</button>
                <button type="submit" name="category" value="Czytam teraz" class="btn btn-info">Dodaj do Czytam teraz</button>
                <button type="submit" name="category" value="W planach" class="btn btn-danger">Dodaj do W planach</button>
            </form>
        </div>
    <?php } else { ?>
        <p>Książka jest już w archiwum.</p>
    <?php } ?>

    <div class="reviews-section">
        <h3>Opinie użytkowników</h3>
        <?php if ($reviewsResult->num_rows > 0): ?>
            <?php while ($review = $reviewsResult->fetch_assoc()): ?>
                <div class="review">
                    <p><strong><?= htmlspecialchars($review['fname']) ?></strong></p>
                    <p class="rating">Ocena: <?= str_repeat('★', $review['rating']) ?></p>
                    <p><?= htmlspecialchars($review['comment']) ?></p>
                    <small><?= htmlspecialchars($review['created_at']) ?></small>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Brak opinii. Bądź pierwszą osobą, która oceni tę książkę!</p>
        <?php endif; ?>
    </div>

    <div class="add-review">
        <h3>Dodaj swoją opinię</h3>
        <form method="POST">
            <div class="form-group">
                <label for="rating">Ocena (1-5):</label>
                <input type="number" id="rating" name="rating" class="form-control" min="1" max="5" required>
            </div>
            <div class="form-group">
                <label for="comment">Komentarz:</label>
                <textarea id="comment" name="comment" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" name="submit_review" class="btn btn-primary">Dodaj opinię</button>
        </form>
    </div>
</div>

</body>
</html>
