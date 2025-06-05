<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Biblioteka online - Archiwum</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="../after_login/after_style.css" />
    <style>
        .book-cover {
            height: 300px;
            object-fit: contain;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php include '../components/header.php'; ?>

<main class="container">
    <section>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-3">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-book"></i> <?= $category === 'all' ? 'Wszystkie książki' : htmlspecialchars($category) ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="archive.php?category=all">Wszystkie</a></li>
                        <li><a href="archive.php?category=Ulubione">Ulubione</a></li>
                        <li><a href="archive.php?category=Czytam teraz">Czytam teraz</a></li>
                        <li><a href="archive.php?category=Gotowe">Gotowe</a></li>
                        <li><a href="archive.php?category=W planach">W planach</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section>
        <h2 class="text-center">Twoje Archiwum</h2>
        <div class="row">
            <?php if ($books->num_rows > 0): ?>
                <?php while ($row = $books->fetch_assoc()): ?>
                    <?php
                        $coverFile = basename($row['cover_image']);
                        $coverPath = '../uploads/' . $coverFile;
                        $exists = !empty($row['cover_image']) && file_exists(__DIR__ . "/../uploads/$coverFile");
                    ?>
                    <div class="col-md-3">
                        <div class="panel panel-default text-center">
                            <div class="panel-body">
                                <img src="<?= htmlspecialchars($exists ? $coverPath : '../uploads/default_cover.jpg') ?>" class="book-cover" alt="Okładka" />
                                <h4><?= htmlspecialchars($row['title']) ?></h4>
                                <p>Autor: <?= htmlspecialchars($row['author']) ?></p>
                                <p>Kategoria: <?= htmlspecialchars($row['category']) ?></p>
                                <form method="POST" action="archive.php">
                                    <input type="hidden" name="update_category_id" value="<?= $row['id'] ?>">
                                    <select name="new_category" class="form-control">
                                        <?php
                                        $categories = ['Ulubione', 'Czytam teraz', 'Gotowe', 'W planach'];
                                        foreach ($categories as $cat) {
                                            $selected = $row['category'] === $cat ? 'selected' : '';
                                            echo "<option value='$cat' $selected>$cat</option>";
                                        }
                                        ?>
                                    </select>
                                    <button type="submit" class="btn btn-warning btn-block" style="margin-top:10px;">Zaktualizuj</button>
                                </form>
                                <a href="archive.php?delete_id=<?= $row['id'] ?>" class="btn btn-danger btn-block" onclick="return confirm('Usunąć książkę?')">Usuń</a>
                                <a href="readBook.php?book_id=<?= $row['id_book'] ?>" class="btn btn-primary btn-block" style="margin-top:10px;">Czytaj</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">Nie masz książek w tej kategorii.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include '../components/footer.php'; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
