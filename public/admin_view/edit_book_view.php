<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Książkę</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Edytuj Książkę w Bibliotece</h2>

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

        <!-- Formularz edytowania książki -->
        <form action="edit_book.php?book_id=<?= $book_id ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Tytuł</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($book['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="author">Autor</label>
                <input type="text" name="author" id="author" class="form-control" value="<?= htmlspecialchars($book['author']) ?>" required>
            </div>
            <div class="form-group">
                <label for="genre">Gatunek</label>
                <input type="text" name="genre" id="genre" class="form-control" value="<?= htmlspecialchars($book['genre']) ?>">
            </div>
            <div class="form-group">
                <label for="description">Opis</label>
                <textarea name="description" id="description" class="form-control"><?= htmlspecialchars($book['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="published_year">Rok Wydania</label>
                <input type="number" name="published_year" id="published_year" class="form-control" value="<?= htmlspecialchars($book['published_year']) ?>">
            </div>
            <div class="form-group">
                <label for="cover_image">Nowa Okładka (opcjonalnie)</label>
                <input type="file" name="cover_image" id="cover_image" class="form-control">
            </div>
            <div class="form-group">
                <label for="book_file">Nowy Plik Książki (opcjonalnie, PDF/Word)</label>
                <input type="file" name="book_file" id="book_file" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Zaktualizuj Książkę</button>
        </form>

    </div>
</body>
</html>
