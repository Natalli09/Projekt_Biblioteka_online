<?php
session_start();


// Połączenie z bazą danych
require_once __DIR__ . '/config/DatebaseConnector.php';

// Pobranie zapytania wyszukiwania z formularza
$query = isset($_GET['query']) ? $conn->real_escape_string(trim($_GET['query'])) : '';

// Przygotowanie zapytania SQL
$sql = $query 
    ? "SELECT id_book, title, author, genre, cover_image FROM books WHERE title LIKE '%$query%' OR author LIKE '%$query%'"
    : "SELECT id_book, title, author, genre, cover_image FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Oswald:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="after_login/after_style.css">
    <link rel="icon" href="hdimg/logo.png">
    <title>Wyniki wyszukiwania - Biblioteka online</title> 
</head>
<body>
<?php include 'components/header.php'; ?>

<main>
    <section id="search-results">
        <div class="container">
            <h2 class="text-center">Wyniki wyszukiwania dla: <?= htmlspecialchars($query ?: 'Wszystkie książki') ?></h2>

            <div class="row">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-md-3">
                            <div class="panel panel-default equal-height">
                                <div class="panel-body text-center">
                                    <?php
                                        $coverPath = htmlspecialchars($row['cover_image']);
                                        $coverFullPath = __DIR__ . '/' . $row['cover_image'];
                                    ?>
                                    <?php if (!empty($row['cover_image']) && file_exists($coverFullPath)): ?>
                                        <img src="<?= $coverPath ?>" alt="Okładka książki" class="book-cover img-responsive" />
                                    <?php else: ?>
                                        <img src="default_cover.png" alt="Brak okładki" class="book-cover img-responsive" />
                                    <?php endif; ?>
                                    <h4><?= htmlspecialchars($row['title']) ?></h4>
                                    <p>Autor: <?= htmlspecialchars($row['author']) ?></p>
                                    <p>Gatunek: <?= htmlspecialchars($row['genre']) ?></p>
                                    <?php if (isset($_SESSION['logid'])): ?>
                                        <a href="servis/readBook.php?book_id=<?= htmlspecialchars($row['id_book']) ?>" class="btn btn-primary">Czytaj książkę</a>
                                    <?php else: ?>
                                        <a href="index.php" class="btn btn-default" title="Zaloguj się, aby czytać książki">Zaloguj się, aby czytać</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="col-md-12">
                        <p class="text-center">Brak wyników dla zapytania: <strong><?= htmlspecialchars($query) ?></strong>.</p>
                    </div>
                <?php endif; ?>
            </div>
</div>
        
    </section>
</main>
<?php include 'components/footer.php'; ?>
</body>
</html>
