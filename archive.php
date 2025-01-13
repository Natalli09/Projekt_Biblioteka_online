<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['logid'])) {
    header('location:index.php'); 
    exit();
}

// Połączenie z bazą danych
$conn = mysqli_connect('localhost', 'root', '', 'bookstore');
if (!$conn) {
    die("Połączenie z bazą danych nie powiodło się: " . mysqli_connect_error());
}

// Pobranie danych użytkownika
$logid = $_SESSION['logid'];
$query = "SELECT fname, lname, email FROM sign_up WHERE id_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $logid);
$stmt->execute();
$result = $stmt->get_result();

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['fname'] = $user['fname'];
    $_SESSION['lname'] = $user['lname'];
    $_SESSION['email'] = $user['email'];
} else {
    header('location:index.php');
    exit();
}

// Obsługa usuwania książki z archiwum
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM archive WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $deleteId);
    if ($stmt->execute()) {
        echo "<script>alert('Książka została usunięta z archiwum.');</script>";
    } else {
        echo "<script>alert('Wystąpił problem przy usuwaniu książki z archiwum.');</script>";
    }
}

// Obsługa zmiany kategorii książki
if (isset($_POST['update_category_id'])) {
    $updateId = $_POST['update_category_id'];
    $newCategory = $_POST['new_category'];
    $updateQuery = "UPDATE archive SET category = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $newCategory, $updateId);
    if ($stmt->execute()) {
        echo "<script>alert('Kategoria została zaktualizowana.');</script>";
    } else {
        echo "<script>alert('Wystąpił problem przy aktualizacji kategorii.');</script>";
    }
}

// Domyślna kategoria to "Wszystkie książki"
$category = isset($_GET['category']) ? $_GET['category'] : 'all';

// Zmodyfikuj zapytanie SQL w zależności od wybranej kategorii
$queryArchive = "SELECT books.title, books.author, books.cover_image, archive.category, archive.id 
                 FROM archive 
                 JOIN books ON archive.id_book = books.id_book 
                 WHERE archive.id_user = ?";

if ($category !== 'all') {
    $queryArchive .= " AND archive.category = ?";
}

$stmt = $conn->prepare($queryArchive);
if ($category !== 'all') {
    $stmt->bind_param("is", $logid, $category);
} else {
    $stmt->bind_param("i", $logid);
}
$stmt->execute();
$archiveResult = $stmt->get_result();
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
    <link rel="stylesheet" type="text/css" href="after_login/after_style.css">
    <link rel="icon" href="hdimg/logo.png">
    <title>Biblioteka online - Archiwum</title>
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
                        <li><a href="after_login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section id="categories-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-2" id="dropdown">
                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" id="categories-btn"><i class="fas fa-book"></i> Wszystkie książki
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="archive.php"><i class="fas fa-book"></i> Wszystkie książki</a></li>
                            <li><a href="archive.php?category=Ulubione"><i class="fas fa-heart"></i> Ulubione</a></li>
                            <li><a href="archive.php?category=Czytam teraz"><i class="fas fa-clock"></i> Czytam teraz</a></li>
                            <li><a href="archive.php?category=Gotowe"><i class="fas fa-check-circle"></i> Gotowe</a></li>
                            <li><a href="archive.php?category=W planach"><i class="fas fa-clock"></i> W planach</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="archiwum">
            <div class="container">
                <h2 class="text-center">Twoje Archiwum</h2>
                <div class="row">
                    <?php if (mysqli_num_rows($archiveResult) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($archiveResult)): ?>
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body text-center">
                                        <img src="<?= htmlspecialchars($row['cover_image']) ?>" class="img-responsive" alt="Okładka książki" style="height: 200px; display: block; margin: 0 auto;">
                                        <h4><?= htmlspecialchars($row['title']) ?></h4>
                                        <p>Autor: <?= htmlspecialchars($row['author']) ?></p>
                                        <p>Kategoria: <?= htmlspecialchars($row['category']) ?></p>

                                        <form action="archive.php" method="POST">
                                            <input type="hidden" name="update_category_id" value="<?= $row['id'] ?>">
                                            <select name="new_category" class="form-control" style="width: 100%;">
                                                <option value="Ulubione" <?= $row['category'] == 'Ulubione' ? 'selected' : '' ?>>Ulubione</option>
                                                <option value="Czytam teraz" <?= $row['category'] == 'Czytam teraz' ? 'selected' : '' ?>>Czytam teraz</option>
                                                <option value="Gotowe" <?= $row['category'] == 'Gotowe' ? 'selected' : '' ?>>Gotowe</option>
                                                <option value="W planach" <?= $row['category'] == 'W planach' ? 'selected' : '' ?>>W planach</option>
                                            </select>
                                            <button type="submit" class="btn btn-warning" style="margin-top: 10px;">Zaktualizuj kategorię</button>
                                        </form><br>

                                        <a href="?delete_id=<?= $row['id'] ?>" class="btn btn-danger">Usuń</a><br><br>
                                        <a href="readBook.php?book_id=<?= $row['id'] ?>" class="btn btn-primary mt-3">Czytaj książkę</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>Nie masz żadnych książek w tej kategorii.</p>
                    <?php endif; ?>
                </div>
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
