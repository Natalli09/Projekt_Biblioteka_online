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
                <input type="text" name="query" placeholder="Szukaj po tytule lub autorze" id="align-search" class="form-control" value="<?= htmlspecialchars($query) ?>">
                <button type="submit" class="btn btn-primary" id="btn"><i class="fa fa-search" aria-hidden="true"></i></button>
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

<main>
    <section id="search-results">
        <div class="container">
            <h2>Wyniki wyszukiwania dla: <?= htmlspecialchars($query ? $query : 'Wszystkie książki') ?></h2>

            <?php
            if ($result->num_rows > 0) {
                echo "<div class='row'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-3'>";
                    echo "<div class='book-card'>";
                    echo "<img src='" . htmlspecialchars($row['cover_image']) . "' alt='Okładka książki' class='img-responsive' style='height: 200px; display: block; margin: 0 auto;'>";
                    echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
                    echo "<p>Autor: " . htmlspecialchars($row['author']) . "</p>";
                    echo "<p>Gatunek: " . htmlspecialchars($row['genre']) . "</p>";
                    echo "<a href='readBook.php?book_id=" . htmlspecialchars($row['id_book']) . "' class='btn btn-primary'>Czytaj książkę</a>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>Brak wyników dla zapytania: <strong>" . htmlspecialchars($query) . "</strong>.</p>";
            }
            $conn->close();
            ?>
        </div>
    </section>
</main>

</body>
</html>
