<?php
session_start();
if (isset($_SESSION['logid'])) {
    // echo "<script>alert('login successful')</script>";
} else {
    header('location:index.php');
}
// Połączenie z bazą danych
$conn = new mysqli('localhost', 'root', '', 'bookstore');
if ($conn->connect_error) {
    die("Połączenie z bazą danych nie powiodło się: " . $conn->connect_error);
}
// Zapytanie SQL do pobrania wszystkich książek w losowej kolejności
$sql = "SELECT * FROM books ORDER BY RAND()";
$result = $conn->query($sql);

// Przygotowanie tablic na różne kategorie
$editor_choice = [];
$popular_books = [];
$classics = [];

if ($result->num_rows > 0) {
    // Iteracja przez wyniki i przypisanie do losowych kategorii
    while ($row = $result->fetch_assoc()) {
        $random_category = rand(1, 3); // Losowy numer kategorii
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
// Ograniczenie liczby książek w każdej kategorii do 8–12
$editor_choice = array_slice($editor_choice, 0, rand(8, 8));
$popular_books = array_slice($popular_books, 0, rand(8, 8));
$classics = array_slice($classics, 0, rand(8, 8));
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Oswald:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="after_login/after_style.css">
    <link rel="icon" href="hdimg/logo.png">
    <title>Biblioteka online</title>
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
                    <span style="font-size: 18px; font-weight: bold; font-family: 'Oswald', sans-serif;">Biblioteka onliney</span>
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
                        <li><a href="after_login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <div class="container">

        <div class="container">
            <!-- Sekcja Wybór Redakcji -->
            <h2 class="text-center">Wybór Redakcji</h2>
            <div class="row">
                <?php if (!empty($editor_choice)): ?>
                    <?php foreach ($editor_choice as $book): ?>
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    <img src="<?= htmlspecialchars($book['cover_image']) ?>" class="img-responsive" alt="Okładka książki" style="height: 200px; display: block; margin: 0 auto;">
                                    <h4><?= htmlspecialchars($book['title']) ?></h4>
                                    <p>Autor: <?= htmlspecialchars($book['author']) ?></p>
                                    <a href="readBook.php?book_id=<?= htmlspecialchars($book['id_book']) ?>" class="btn btn-primary">Czytaj książkę</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Brak książek w tej kategorii.</p>
                <?php endif; ?>
            </div>

            <!-- Sekcja Popularne Książki -->
            <h2 class="text-center">Popularne Książki</h2>
            <div class="row">
                <?php if (!empty($popular_books)): ?>
                    <?php foreach ($popular_books as $book): ?>
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    <img src="<?= htmlspecialchars($book['cover_image']) ?>" class="img-responsive" alt="Okładka książki" style="height: 200px; display: block; margin: 0 auto;">
                                    <h4><?= htmlspecialchars($book['title']) ?></h4>
                                    <p>Autor: <?= htmlspecialchars($book['author']) ?></p>
                                    <a href="readBook.php?book_id=<?= htmlspecialchars($book['id_book']) ?>" class="btn btn-primary">Czytaj książkę</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Brak książek w tej kategorii.</p>
                <?php endif; ?>
            </div>

            <!-- Sekcja Klasyka Literacka -->
            <h2 class="text-center">Top dnia</h2>
            <div class="row">
                <?php if (!empty($classics)): ?>
                    <?php foreach ($classics as $book): ?>
                        <div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body text-center">
                                    <img src="<?= htmlspecialchars($book['cover_image']) ?>" class="img-responsive" alt="Okładka książki" style="height: 200px; display: block; margin: 0 auto;">
                                    <h4><?= htmlspecialchars($book['title']) ?></h4>
                                    <p>Autor: <?= htmlspecialchars($book['author']) ?></p>
                                    <a href="readBook.php?book_id=<?= htmlspecialchars($book['id_book']) ?>" class="btn btn-primary">Czytaj książkę</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Brak książek w tej kategorii.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

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
</body>
</html>
