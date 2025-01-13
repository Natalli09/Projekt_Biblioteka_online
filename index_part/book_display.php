<?php
// Połączenie z bazą danych
require_once 'app/core/DatabaseConnector.php'; // Upewnij się, że ten plik obsługuje połączenie z bazą

// Sprawdzenie, czy użytkownik jest zalogowany
if (isset($_SESSION['logid'])) {
    $userId = $_SESSION['logid'];

    // Zapytanie do bazy danych o książki
    $query = "SELECT title, author, genre, cover_image FROM books ORDER BY title ASC";
    $result = $db->query($query); // $db - obiekt połączenia z bazą danych

    // Wyświetlanie książek
    if ($result && $result->num_rows > 0) {
        echo '<div class="row">';
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-md-3 text-center" style="margin-bottom: 20px;">';
            echo '<div class="book-card">';
            echo '<img src="uploads/covers/' . htmlspecialchars($row['cover_image']) . '" alt="' . htmlspecialchars($row['title']) . '" style="width:100%; height:auto;">';
            echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
            echo '<p>Autor: ' . htmlspecialchars($row['author']) . '</p>';
            echo '<p>Gatunek: ' . htmlspecialchars($row['genre']) . '</p>';
            echo '<button class="btn btn-primary">Więcej</button>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>Brak książek w bazie danych.</p>';
    }
} else {
    echo '<p>Musisz się zalogować, aby zobaczyć książki.</p>';
}
?>
