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

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?= $success_message; ?></div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message; ?></div>
        <?php endif; ?>

        <div class="user-info">
            <h4>Witaj, <?= htmlspecialchars($_SESSION['fname']) . ' ' . htmlspecialchars($_SESSION['lname']); ?>!</h4>
            <p>Email: <?= htmlspecialchars($_SESSION['email']); ?></p>
        </div>

        <hr>

        <form action="../admin/add_books.php" method="POST" enctype="multipart/form-data">
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