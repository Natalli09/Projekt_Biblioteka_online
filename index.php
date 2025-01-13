<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Oswald:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="ebook_style.css">
    <link rel="icon" href="hdimg/logo.png">
    <title>Biblioteka online</title>
</head>

<body>
    <header>
        <div class="row" id="nav">
            <div class="col-md-8 text-left" id="logo">
                <a href="index.php">
                    <img src="hdimg/logo.png" alt="logo" style="width: 70px; height: auto;">
                    <span style="font-size: 28px; font-weight: bold; font-family: 'Oswald', sans-serif;">Biblioteka online</span>
                </a>
            </div>
        </div>
    </header>
    <?php include 'index_part/signup.php'; ?>
    <br><br>

    <!-- Sekcja informacyjna -->
    <section id="about" class="container">
        <h1 style="text-align: center; font-family: 'Oswald', sans-serif;">O Bibliotece Online</h1>
        <p style="text-align: justify; font-size: 18px; line-height: 1.6;">
        Biblioteka Online to nowoczesna platforma cyfrowa, która umożliwia użytkownikom dostęp do szerokiego zakresu książek w formie elektronicznej. 
        Naszym celem jest promowanie czytelnictwa i zapewnienie wygodnego sposobu korzystania z literatury. 
        Platforma umożliwia łatwe wyszukiwanie, pobieranie oraz czytanie książek na komputerach, tabletach i smartfonach. 
        Dzięki intuicyjnemu interfejsowi oraz funkcji personalizacji każdy użytkownik może dopasować swoje doświadczenie czytelnicze do własnych potrzeb. 
        Biblioteka Online to idealne rozwiązanie dla miłośników książek, którzy cenią sobie wygodę i szeroki wybór literatury w jednym miejscu.
        </p>
        <?php include 'index_part/Browse_genres.php'; ?>
        <br><br>
        <h3 style="margin-top: 30px; font-family: 'Oswald', sans-serif;">Jak działa nasz serwis?</h3>
        <ul style="font-size: 16px; line-height: 2.0; padding-left: 30px;">
            <li>Użytkownicy mogą zarejestrować się i zalogować, aby uzyskać dostęp do pełnej funkcjonalności serwisu.</li>
            <li>Przeglądaj dostępne gatunki i znajdź swoje ulubione książki.</li>
            <li>Pobieraj książki na swoje urządzenia w wygodnym formacie.</li>
            <li>Utwórz listę ulubionych książek i zarządzaj swoimi zasobami wirtualnej biblioteki.</li>
        </ul>
        <h3 style="margin-top: 30px; font-family: 'Oswald', sans-serif;">Główne funkcjonalności</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="feature-box text-center">
                    <i class="fa fa-search fa-3x" aria-hidden="true"></i>
                    <h4>Wyszukiwanie książek</h4>
                    <p>Szybko znajdź interesujące Cię pozycje według tytułu, autora lub gatunku.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box text-center">
                    <i class="fa fa-book fa-3x" aria-hidden="true"></i>
                    <h4>Szeroka baza książek</h4>
                    <p>Dostęp do tysięcy tytułów w wielu kategoriach tematycznych.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box text-center">
                    <i class="fa fa-user fa-3x" aria-hidden="true"></i>
                    <h4>Personalizacja</h4>
                    <p>Każdy użytkownik może tworzyć własne archiwum książek, organizując je w kategorie takie jak „Gotowe”, 
                        „Ulubione”, „Czytam teraz” oraz „W planach”.</p>
                </div>
            </div>
        </div>
        <h3 style="margin-top: 30px; font-family: 'Oswald', sans-serif;">Jak zacząć?</h3>
        <p style="font-size: 18px; line-height: 1.6;">
            Aby rozpocząć korzystanie z naszej biblioteki online, wykonaj następujące kroki:
        </p>
        <ol style="font-size: 16px; line-height: 1.8;padding-left: 30px;">
            <li>Zarejestruj się w serwisie, klikając przycisk "login/singup" w menu głównym.</li>
            <li>Zaloguj się na swoje konto, aby uzyskać dostęp do pełnej funkcjonalności.</li>
            <li>Przeglądaj dostępne książki i pobieraj je na swoje urządzenie.</li>
        </ol>

        <!-- Dodanie dodatkowego tekstu -->
        <h3 style="margin-top: 30px; font-family: 'Oswald', sans-serif;">Dlaczego warto korzystać z naszej biblioteki?</h3>
        <p style="text-align: justify; font-size: 18px; line-height: 1.6;">
            Nasza biblioteka to nie tylko wygodny dostęp do książek, ale także możliwość rozwoju intelektualnego i kulturalnego. 
            Dzięki szerokiej ofercie literackiej użytkownicy mają możliwość poznawania nowych gatunków literackich, rozwijania swoich zainteresowań oraz zwiększania swojej wiedzy. 
            Dodatkowo, nasza platforma jest dostępna 24/7, co umożliwia korzystanie z niej w dowolnym miejscu i czasie. 
            Z naszą biblioteką nie tylko rozwijasz się, ale także tworzysz własną przestrzeń czytelniczą, która dopasowuje się do Twoich indywidualnych potrzeb i preferencji.
        </p>
        
    </section>

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
    <br><br>
</body>

</html>
<?php
    if (isset($_SESSION['logid'])) {
        echo "<script>window.open('index_after.php')</script>";
    }
    ?>