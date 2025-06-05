<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Czytaj książkę: <?= htmlspecialchars($book['title']) ?></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Oswald:wght@600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="../after_login/after_style.css" />

    <style>
        .book-header h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .book-header {
        margin-bottom: 30px;
    }

        .book-content {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            background: #fff;
        }


        
        .book-cover img {
            width: 100%;
            max-width: 300px;
            height: auto;
            display: block;
            margin: 0 auto 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


    </style>
</head>
<body>
<?php include '../components/header.php'; ?>

<div class="container">

    <div class="back-button">
        <a href="archive.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Powrót</a>
    </div>

    <div class="book-header">
        <div class="book-cover">
            <?php if (!empty($book['cover_image']) && file_exists(__DIR__ . '/../uploads/' . basename($book['cover_image']))): ?>
                <img src="<?= htmlspecialchars($coverPath) ?>" alt="Okładka książki" />
            <?php else: ?>
                <p>Okładka nie jest dostępna.</p>
            <?php endif; ?>
        </div>

        <h1><?= htmlspecialchars($book['title']) ?></h1>
        <p>Autor: <?= htmlspecialchars($book['author']) ?></p>
        <p>Gatunek: <?= htmlspecialchars($book['genre']) ?></p>
        <p>Opis: <?= !empty($book['description']) ? nl2br(htmlspecialchars($book['description'])) : 'Brak opisu.' ?></p>
        <p>Data publikacji: <?= !empty($book['published_year']) ? htmlspecialchars($book['published_year']) : 'Brak daty publikacji.' ?></p>

        <p>Średnia ocena:
            <?php if ($avgRating): 
                $roundedRating = round($avgRating);
                for ($i = 1; $i <= 5; $i++):
                    if ($i <= $roundedRating): ?>
                        <i class="fas fa-star" style="color: #f39c12;"></i>
                    <?php else: ?>
                        <i class="far fa-star" style="color: #f39c12;"></i>
                    <?php endif;
                endfor;
            else: ?>
                Brak ocen
            <?php endif; ?>
        </p>
    </div>

    <div class="text-center">
        <?php if (isset($_SESSION['fname']) && $_SESSION['fname'] === 'Nataliia'): ?>
            <a href="../servis/admin/edit_book.php?book_id=<?= $bookId ?>" class="btn btn-primary" style="margin-top: 20px;">
                <i class="fas fa-edit"></i> Edytuj książkę
            </a>
        <?php endif; ?>
    </div>

    <div class="text-center">
        <?php if (isset($_SESSION['fname']) && $_SESSION['fname'] === 'Nataliia'): ?>
            <a href="../servis/admin/delete_book.php?book_id=<?= $bookId ?>" class="btn btn-primary" style="margin-top: 20px;">
                <i class="fas fa-trash"></i> Usuń książkę
            </a>
        <?php endif; ?>
    </div>

    <div class="book-content">
        <?php if (!empty($book['book_file']) && file_exists(__DIR__ . '/../uploads/' . basename($book['book_file']))): ?>
            <iframe src="<?= htmlspecialchars($bookFilePath) ?>" width="100%" height="1500px" frameborder="0"></iframe>
        <?php else: ?>
            <p>Plik z treścią książki nie jest dostępny.</p>
        <?php endif; ?>
    </div>

    <?php if (!empty($book['book_file']) && file_exists(__DIR__ . '/../uploads/' . basename($book['book_file']))): ?>
        <div class="download-button">
            <a href="<?= htmlspecialchars($bookFilePath) ?>" download class="btn btn-success">Pobierz książkę</a>
        </div>
    <?php endif; ?>

    <?php if (!$isBookInArchive): ?>
        <div class="archive-buttons">
            <form method="POST">
                <button type="submit" name="category" value="Ulubione" class="btn btn-success">Dodaj do Ulubionych</button>
                <button type="submit" name="category" value="Gotowe" class="btn btn-warning">Dodaj do Gotowych</button>
                <button type="submit" name="category" value="Czytam teraz" class="btn btn-info">Dodaj do Czytam teraz</button>
                <button type="submit" name="category" value="W planach" class="btn btn-warning">Dodaj do W planach</button>

            </form>
        </div>
    <?php else: ?>
        <p class="text-success" style="margin-top: 15px;">Książka jest już w Twoim archiwum.</p>
    <?php endif; ?>

    <div class="reviews-section">
        <h3>Opinie o książce</h3>

        <?php if ($reviewsResult->num_rows > 0): ?>
            <?php while ($review = $reviewsResult->fetch_assoc()): ?>
                <div class="review">
                    <p><strong><?= htmlspecialchars($review['fname']) ?></strong> - <?= date('d-m-Y', strtotime($review['created_at'])) ?></p>
                    <p class="rating">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $review['rating']
                                ? '<i class="fas fa-star" style="color:#f39c12;"></i>'
                                : '<i class="far fa-star" style="color:#f39c12;"></i>';
                        }
                        ?>
                    </p>
                    <p><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Brak opinii o tej książce.</p>
        <?php endif; ?>

        <h4>Dodaj swoją opinię</h4>
        <form method="POST" action="">
            <div class="form-group">
                <label for="rating">Ocena (1-5):</label>
                <select id="rating" name="rating" class="form-control" required>
                    <option value="">Wybierz ocenę</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="comment">Komentarz:</label>
                <textarea id="comment" name="comment" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" name="submit_review" class="btn btn-primary">Dodaj opinię</button>
        </form>
    </div>
</div>

<?php include '../components/footer.php'; ?>

</body>
</html>
