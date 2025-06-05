<?php
session_start();

// Sprawdzenie logowania
if (!isset($_SESSION['logid'])) {
    header('location:index.php');
    exit();
}

require_once __DIR__ . '/../config/DatebaseConnector.php';

$logid = $_SESSION['logid'];

// Pobierz dane użytkownika
$user = getUserData($conn, $logid);
if (!$user) {
    header('location:index.php');
    exit();
}

// Przetwarzanie akcji
handleDelete($conn, $logid);
handleCategoryUpdate($conn, $logid);

// Pobranie danych książek z archiwum
$category = $_GET['category'] ?? 'all';
$books = getBooksFromArchive($conn, $logid, $category);

// Wczytaj widok
include __DIR__ . '/../public/archive_view.php';


// ==== FUNKCJE ====

function getUserData($conn, $logid) {
    $stmt = $conn->prepare("SELECT fname, lname, email FROM sign_up WHERE id_user = ?");
    $stmt->bind_param("i", $logid);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result && $result->num_rows > 0 ? $result->fetch_assoc() : null;
}

function handleDelete($conn, $logid) {
    if (isset($_GET['delete_id'])) {
        $deleteId = intval($_GET['delete_id']);
        $stmt = $conn->prepare("DELETE FROM archive WHERE id = ? AND id_user = ?");
        $stmt->bind_param("ii", $deleteId, $logid);
        if ($stmt->execute()) {
            echo "<script>alert('Książka została usunięta z archiwum.'); window.location.href='archive.php';</script>";
            exit();
        } else {
            echo "<script>alert('Błąd przy usuwaniu książki.');</script>";
        }
    }
}

function handleCategoryUpdate($conn, $logid) {
    if (isset($_POST['update_category_id'])) {
        $updateId = intval($_POST['update_category_id']);
        $newCategory = $_POST['new_category'];
        $allowed = ['Ulubione', 'Czytam teraz', 'Gotowe', 'W planach'];

        if (in_array($newCategory, $allowed)) {
            $stmt = $conn->prepare("UPDATE archive SET category = ? WHERE id = ? AND id_user = ?");
            $stmt->bind_param("sii", $newCategory, $updateId, $logid);
            if ($stmt->execute()) {
                echo "<script>alert('Kategoria została zaktualizowana.'); window.location.href='archive.php';</script>";
                exit();
            } else {
                echo "<script>alert('Błąd przy aktualizacji.');</script>";
            }
        }
    }
}

function getBooksFromArchive($conn, $logid, $category) {
    if ($category !== 'all') {
        $stmt = $conn->prepare(
            "SELECT books.title, books.author, books.cover_image, archive.category, archive.id, books.id_book
            FROM archive
            JOIN books ON archive.id_book = books.id_book
            WHERE archive.id_user = ? AND archive.category = ?"
        );
        $stmt->bind_param("is", $logid, $category);
    } else {
        $stmt = $conn->prepare(
            "SELECT books.title, books.author, books.cover_image, archive.category, archive.id, books.id_book
            FROM archive
            JOIN books ON archive.id_book = books.id_book
            WHERE archive.id_user = ?"
        );
        $stmt->bind_param("i", $logid);
    }

    $stmt->execute();
    return $stmt->get_result();
}
?>
