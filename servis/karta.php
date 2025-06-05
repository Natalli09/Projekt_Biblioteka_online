<?php
session_start();
if (!isset($_SESSION['logid'])) {
    header('location:index.php'); 
    exit();
}

// Połączenie z bazą danych
require_once __DIR__ . '/../config/DatebaseConnector.php';

$logid = $_SESSION['logid'];

$wiadomosc = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobranie i zabezpieczenie danych
    $numer_karty = mysqli_real_escape_string($conn, $_POST["numer_karty"]);
    $waznosc = mysqli_real_escape_string($conn, $_POST["waznosc"]);
    $cvv = mysqli_real_escape_string($conn, $_POST["cvv"]);
    $imie_nazwisko = mysqli_real_escape_string($conn, $_POST["imie_nazwisko"]);

    // Zapytanie SQL – UWAGA: powinno być z użyciem prepared statement!
    $sql = "INSERT INTO karty (numer_karty, waznosc, cvv, imie_nazwisko, id_user)
            VALUES ('$numer_karty', '$waznosc', '$cvv', '$imie_nazwisko', '$logid')";

    if (mysqli_query($conn, $sql)) {
        $wiadomosc = "<div class='alert alert-success'>Karta została dodana pomyślnie.</div>";
    } else {
        $wiadomosc = "<div class='alert alert-danger'>Błąd podczas dodawania: " . mysqli_error($conn) . "</div>";
    }
}
include __DIR__ . '/../public/karta_view.php';
?>
