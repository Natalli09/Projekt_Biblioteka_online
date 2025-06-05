<?php
session_start();
if (!isset($_SESSION['logid'])) {
    header('location:index.php');
    exit();
}

// Połączenie z bazą danych
require_once __DIR__ . '/config/DatebaseConnector.php';

// Pobranie wszystkich książek w losowej kolejności
$sql = "SELECT * FROM books ORDER BY RAND()";
$result = $conn->query($sql);

// Kategorie
$editor_choice = [];
$popular_books = [];
$classics = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $random_category = rand(1, 3);
        switch ($random_category) {
            case 1:
                $editor_choice[] = $row;
                break;
            case 2:
                $popular_books[] = $row;
                break;
            case 3:
                $classics[] = $row;
                break;
        }
    }
}

// Ograniczenie do 8 książek na kategorię
$editor_choice = array_slice($editor_choice, 0, 8);
$popular_books = array_slice($popular_books, 0, 8);
$classics = array_slice($classics, 0, 8);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Biblioteka online</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Oswald:wght@600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="after_login/after_style.css" />
    <link rel="icon" href="../hdimg/logo.png" />
    <style>

        /* Kontener całej strony pomiędzy header a footer */
        .page-wrapper {
            display: flex;
            flex: 1;
            gap: 20px;
            padding-top: 20px;
            padding-bottom: 0;
            background: #fff;
        }

        /* Tło po bokach - pełna wysokość */
        .side-bg {
            flex: 1;
            background-image: url('hdimg/tlo.jpg');
            background-size: cover;
            background-repeat: repeat;
            background-position: center;
            min-height: 100vh; /* pełna wysokość widoku */
            border-radius: 8px;
            position: sticky;
            top: 0;
        }

        /* Główna zawartość */
        .books-container {
            flex: 6; /* szersza środkowa część */
            padding: 0 15px;
            background: transparent;
        }

        .panel-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 400px;
            text-align: center;
        }

        .panel-body img {
            height: 200px;
            margin: 0 auto 15px;
            display: block;
            object-fit: contain;
        }
    </style>
</head>
<body>

<?php include __DIR__ . '/components/header.php'; ?>

<div class="page-wrapper">
    <div class="side-bg"></div>

    <div class="books-container container main-content">

        <!-- Wybór Redakcji -->
        <h1 class="text-center">Wybór Redakcji</h1>
        <div class="row">
            <?php if (!empty($editor_choice)): ?>
                <?php foreach ($editor_choice as $book): ?>
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="Okładka książki" />
                                <h4><?= htmlspecialchars($book['title']) ?></h4>
                                <p>Autor: <?= htmlspecialchars($book['author']) ?></p>
                                <a href="servis/readBook.php?book_id=<?= htmlspecialchars($book['id_book']) ?>" class="btn btn-primary">Czytaj książkę</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Brak książek w tej kategorii.</p>
            <?php endif; ?>
        </div>

        <!-- Popularne Książki -->
        <h1 class="text-center">Popularne Książki</h1>
        <div class="row">
            <?php if (!empty($popular_books)): ?>
                <?php foreach ($popular_books as $book): ?>
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="Okładka książki" />
                                <h4><?= htmlspecialchars($book['title']) ?></h4>
                                <p>Autor: <?= htmlspecialchars($book['author']) ?></p>
                                <a href="servis/readBook.php?book_id=<?= htmlspecialchars($book['id_book']) ?>" class="btn btn-primary">Czytaj książkę</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Brak książek w tej kategorii.</p>
            <?php endif; ?>
        </div>

        <!-- Top dnia -->
        <h1 class="text-center">Top dnia</h1>
        <div class="row">
            <?php if (!empty($classics)): ?>
                <?php foreach ($classics as $book): ?>
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="Okładka książki" />
                                <h4><?= htmlspecialchars($book['title']) ?></h4>
                                <p>Autor: <?= htmlspecialchars($book['author']) ?></p>
                                <a href="servis/readBook.php?book_id=<?= htmlspecialchars($book['id_book']) ?>" class="btn btn-primary">Czytaj książkę</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Brak książek w tej kategorii.</p>
            <?php endif; ?>
        </div>

    </div>

    <div class="side-bg"></div>
</div>

<?php include __DIR__ . '/components/footer.php'; ?>

</body>
</html>
