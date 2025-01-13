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

// Dodawanie książki do bazy danych
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'] ?? '';
    $description = $_POST['description'] ?? '';
    $published_year = $_POST['published_year'] ?? null;
    $cover_image = null;
    $book_file = null; // Для зберігання шляху до завантаженого файлу книги

    // Обробка завантаження зображення (окладки)
    if (!empty($_FILES['cover_image']['name'])) {
        $target_dir = "uploads/";
        $unique_name = uniqid() . "_" . basename($_FILES['cover_image']['name']);
        $cover_image = $target_dir . $unique_name;

        if (!move_uploaded_file($_FILES['cover_image']['tmp_name'], $cover_image)) {
            die("Błąd podczas przesyłania okładki!");
        }
    }

    // Обробка завантаження файлу книги (PDF/Word)
    if (!empty($_FILES['book_file']['name'])) {
        $target_dir = "uploads/";
        $unique_file_name = uniqid() . "_" . basename($_FILES['book_file']['name']);
        $book_file = $target_dir . $unique_file_name;

        // Перевірка типу файлу
        $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (!in_array($_FILES['book_file']['type'], $allowed_types)) {
            die("Nieprawidłowy format pliku! Akceptowane: PDF, DOC, DOCX.");
        }

        if (!move_uploaded_file($_FILES['book_file']['tmp_name'], $book_file)) {
            die("Błąd podczas przesyłania pliku książki!");
        }
    }

    // Перевірка обов'язкових полів
    if (!empty($title) && !empty($author)) {
        $sql = "INSERT INTO books (title, author, genre, description, cover_image, published_year, book_file) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssssis", $title, $author, $genre, $description, $cover_image, $published_year, $book_file);
        
            if ($stmt->execute()) {
                $success_message = "Książka została dodana pomyślnie!";
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

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Książkę</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Dodaj Książkę do Biblioteki</h2>

        <!-- Wyświetlanie komunikatów o sukcesie lub błędzie -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <?= $success_message; ?>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger">
                <?= $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Informacje o zalogowanym użytkowniku -->
        <div class="user-info">
            <h4>Witaj, <?= htmlspecialchars($_SESSION['fname']) . ' ' . htmlspecialchars($_SESSION['lname']); ?>!</h4>
            <p>Email: <?= htmlspecialchars($_SESSION['email']); ?></p>
        </div>

        <hr>

        <!-- Formularz dodawania książki -->
        <form action="add_books.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Tytuł</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Wprowadź tytuł książki" required>
            </div>
            <div class="form-group">
                <label for="author">Autor</label>
                <input type="text" name="author" id="author" class="form-control" placeholder="Wprowadź autora książki" required>
            </div>
            <div class="form-group">
                <label for="genre">Gatunek</label>
                <input type="text" name="genre" id="genre" class="form-control" placeholder="Wprowadź gatunek książki">
            </div>
            <div class="form-group">
                <label for="description">Opis</label>
                <textarea name="description" id="description" class="form-control" placeholder="Dodaj opis książki"></textarea>
            </div>
            <div class="form-group">
                <label for="published_year">Rok Wydania</label>
                <input type="number" name="published_year" id="published_year" class="form-control" placeholder="Wprowadź rok wydania">
            </div>
            <div class="form-group">
                <label for="cover_image">Okładka</label>
                <input type="file" name="cover_image" id="cover_image" class="form-control">
            </div>
            <div class="form-group">
                <label for="book_file">Plik książki (PDF/Word)</label>
                <input type="file" name="book_file" id="book_file" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Dodaj Książkę</button>
        </form>

    </div>
</body>
</html>
