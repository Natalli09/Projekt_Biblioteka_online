<?php
session_start();

// Połączenie z bazą danych
require_once __DIR__ . '/config/DatebaseConnector.php';

// Pobranie gatunku z URL i filtrowanie danych wejściowych
$genre = isset($_GET['genre']) ? trim($_GET['genre']) : '';

// Przygotowanie zapytania z prepared statement
if (!empty($genre)) {
    $stmt = $conn->prepare("SELECT * FROM books WHERE genre = ? ORDER BY RAND()");
    $stmt->bind_param('s', $genre);
} else {
    $stmt = $conn->prepare("SELECT * FROM books ORDER BY RAND()");
}


$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Biblioteka online - Archiwum</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Oswald:wght@600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="after_login/after_style.css" />
    <link rel="icon" href="hdimg/logo.png" />
</head>
<body>
<?php include __DIR__ . '/components/header.php'; ?>

<main>
    <!-- Sekcja kategorii -->
    <section id="categories-section">
        <div class="container">
            <div class="row">
                <div class="col-md-2" id="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" id="categories-btn">
                        <i class="fas fa-book"></i> Gatunki książek
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="genre.php"><i class="fas fa-book"></i> Wszystkie książki</a></li>
                        <li><a href="genre.php?genre=poezja"><i class="fas fa-book"></i> Poezja</a></li>
                        <li><a href="genre.php?genre=kryminal"><i class="fas fa-user-secret"></i> Kryminał</a></li>
                        <li><a href="genre.php?genre=fantasy"><i class="fas fa-dragon"></i> Fantasy</a></li>
                        <li><a href="genre.php?genre=romance"><i class="fas fa-heart"></i> Romans</a></li>
                        <li><a href="genre.php?genre=sci-fi"><i class="fas fa-space-shuttle"></i> Science Fiction</a></li>
                        <li><a href="genre.php?genre=dla dzieci"><i class="fas fa-lightbulb"></i> Dla dzieci</a></li>
                        <li><a href="genre.php?genre=history"><i class="fas fa-landmark"></i> Historia</a></li>
                        <li><a href="genre.php?genre=biography"><i class="fas fa-user"></i> Biografia</a></li>
                        <li><a href="genre.php?genre=horror"><i class="fas fa-ghost"></i> Horror</a></li>
                        <li><a href="genre.php?genre=przygody"><i class="fas fa-map"></i> Przygoda</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="genre">
        <div class="container">
            <h2 class="text-center">Książki w gatunku: <?= htmlspecialchars($genre ? $genre : 'Wszystkie') ?></h2>

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
                                        <a href="index.php" class="btn btn-default" title="Zaloguj się, aby czytać">Zaloguj się, aby czytać</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">Brak książek w tym gatunku.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include 'components/footer.php'; ?>
</body>
</html>
