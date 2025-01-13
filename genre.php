<?php
session_start();
if (!isset($_SESSION['logid'])) {
    header('location:index.php'); 
    exit();
}

// Połączenie z bazą danych
$conn = new mysqli('localhost', 'root', '', 'bookstore');
if ($conn->connect_error) {
    die("Połączenie z bazą danych nie powiodło się: " . $conn->connect_error);
}

// Pobranie gatunku z URL i filtrowanie danych wejściowych
$genre = isset($_GET['genre']) ? $conn->real_escape_string($_GET['genre']) : '';

// Zapytanie SQL do pobrania książek (losowo sortowane)
if (!empty($genre)) {
    $sql = "SELECT * FROM books WHERE genre = '$genre' ORDER BY RAND()";
} else {
    $sql = "SELECT * FROM books ORDER BY RAND()";
}

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
    <title>Biblioteka online - Archiwum</title>
    <style>
        .panel {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 400px;
        }
        .equal-height {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .panel-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 400px
        }
    </style>
</head>
<body>
<header>
    <div class="row" id="nav">
        <div class="col-md-2" id="logo">
            <a href="index_after.php">
            <img src="hdimg/logo.png" alt="logo" style="width: 70px; height: auto;">
                <span style="font-size: 18px; font-weight: bold; font-family: 'Oswald', sans-serif;">Biblioteka online</span>
            </a>
        </div>

        <div class="col-md-6" id="search">
            <form action="search.php" method="GET" class="form-inline">
                    <input type="text" name="query" placeholder="Search by title or author" class="form-control" id="align-search">
                    <button type="submit" class="btn btn-primary" id="btn">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
            </form>
        </div>

        <div class="col-md-2" id="dropdown">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" id="but"><i class="fas fa-bars"></i>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <h3>Menu</h3>
                    <li><a href="profile.php"><i class="fas fa-user"></i> Profil użytkownika</a></li>
                    <li><a href="archive.php"><i class="fas fa-archive"></i> Archiwum</a></li>
                    <li><a href="genre.php"><i class="fas fa-book"></i> Gatunek</a></li>
                    <li><a href="after_login/logout.php"><i class="fas fa-sign-out-alt"></i> Wyloguj</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

<main>
    <!-- Sekcja kategorii -->
    <section id="categories-section">
        <div class="container">
            <div class="row">
                <div class="col-md-2" id="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" id="categories-btn"><i class="fas fa-book"></i> Gatunki książek
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
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-3">
                    <div class="panel panel-default equal-height">
                        <div class="panel-body text-center">
                            <img src="<?= htmlspecialchars($row['cover_image']) ?>" class="img-responsive" alt="Okładka książki" style="height: 200px; display: block; margin: 0 auto;">
                            <h4><?= htmlspecialchars($row['title']) ?></h4>
                            <p>Autor: <?= htmlspecialchars($row['author']) ?></p>
                            <p>Gatunek: <?= htmlspecialchars($row['genre']) ?></p>
                            <a href="readBook.php?book_id=<?= htmlspecialchars($row['id_book']) ?>" class="btn btn-primary">Czytaj książkę</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Brak książek w tym gatunku.</p>
        <?php endif; ?>
    </div>

    </section>

</main>

<footer>
<section class="footer" id="footer" style="margin-top:150px;">
        <div class="row">
            <div class="col-md-3" id="logofoot" style="margin-top:30px;">
                <a href="index_after.php">
                    <img src="hdimg/logo.png" alt="logo" style="width: 70px; height: auto;"><br> Biblioteka online
                </a>
            </div>
            
            <div class="col-md-3 ml-auto" id="footelement">
                <h2>Informacje o produkcie</h2>
                <span>Kontakt niedostępny : +48 321123321</span><br>
                <span>Email : elibrary2k24@gmail.com</span><br>
                <span>Address: Polska, Gorzów Wlkp.</span>
            </div>

        </div><br>
        <hr>
        <div class="credit" id="footelement"><i class="fa fa-copyright" aria-hidden="true"> Copyright @ 2024 Biblioteka online | All rights reserved </i></div>
    </section>
</footer>
</body>
</html>
