# Biblioteka Online
Nasz projekt na GitHub: https://github.com/Natalli09/Projekt_Biblioteka_online/

Projekt Biblioteka Online to system biblioteczny open-source, który umożliwia użytkownikom przeglądanie, wyszukiwanie i dostęp do cyfrowych zasobów, takich jak książki, dokumenty i materiały edukacyjne. Naszym celem jest stworzenie przyjaznego narzędzia, które może być wykorzystywane przez różne organizacje – szkoły, uczelnie czy indywidualnych użytkowników.

## Opis Projektu

Biblioteka Online to aplikacja webowa stworzona w oparciu o PHP, HTML, CSS, JavaScript oraz bazę danych MySQL. Umożliwia ona zarządzanie cyfrową kolekcją książek, zapewniając użytkownikom możliwość przeszukiwania zasobów, pobierania materiałów oraz współdzielenia wiedzy. Projekt obsługuje wiele ról użytkowników, takich jak czytelnicy i administratorzy, z różnymi poziomami dostępu.

## Kluczowe Funkcje:

1. Interfejs użytkownika – intuicyjny i łatwy w obsłudze, zapewniający przyjazne doświadczenie zarówno dla nowych, jak i zaawansowanych użytkowników.
2. System logowania i rejestracji – umożliwia bezpieczne tworzenie kont użytkowników oraz logowanie do systemu, z opcją odzyskiwania zapomnianych haseł.
3. Przesyłanie zasobów – administratorzy mogą dodawać nowe materiały, w tym tytuł, autora, rok wydania, opis, gatunek, oraz inne metadane, w celu pełnego zdefiniowania zasobu.
4. Wyszukiwanie zasobów – użytkownicy mogą przeszukiwać bibliotekę na podstawie różnych kryteriów, takich jak tytuł, autor, gatunek, rok wydania czy oceny użytkowników. Wyszukiwanie wspiera także filtry zaawansowane (np. wg ratingu, dostępności).
5. Panel administratora – interaktywne narzędzie pozwalające administratorom na łatwe zarządzanie zawartością biblioteki, z opcjami edytowania, usuwania oraz dodawania nowych materiałów.
6. Pobieranie plików – użytkownicy mają możliwość zapisania zasobów na urządzeniu lokalnym, by móc je wykorzystać offline.
7. Komentarze – użytkownicy mogą dodawać komentarze do materiałów, dzieląc się opiniami, doświadczeniami i sugestiami, co tworzy interaktywną społeczność.
8. Oceny – użytkownicy mogą oceniać materiały na podstawie własnych doświadczeń, umożliwiając innym użytkownikom łatwiejszą ocenę jakości zasobów na podstawie średniej ocen.
9. Dodawanie do archiwum – możliwość tworzenia list materiałów, które użytkownicy mogą zachować w swoich "archiwach" do późniejszego użytku, zarządzając swoją kolekcją.
10. Podział na gatunki – zasoby są podzielone na kategorie/tematyczne grupy, aby użytkownicy mogli łatwo przeszukiwać bibliotekę według określonego gatunku (np. literackiego, naukowego, edukacyjnego).
11. Subskrypcija - użytkownicy mogą wybrac plan subskrypciji (Drmowy, Standart i Premium) i zrealizować subskrypcjęю
12. Karty płatniczej - możliwość dodania karty dla subskrypcji. 
13. Powiadomienia – system obsługuje powiadomienia dla użytkowników, informujące o nowych książkach.

## Instalacja

1. Sklonuj repozytorium:

    git clone https://github.com/Natalli09/Projekt_Biblioteka_online/
    cd online-library

2. Skonfiguruj bazę danych:
    - Utwórz nową bazę danych w MySQL.
    - Zaimportuj plik SQL dostarczony w folderze database/ (np. bookstore.sql) do swojej bazy danych.
    - Skonfiguruj połączenie z bazą danych w pliku DatebaseConnector.php.

3. Zainstaluj serwer lokalny:
    - Zainstaluj i uruchom lokalny serwer, taki jak XAMPP, WAMP lub MAMP.
    - Skopiuj pliki projektu do folderu htdocs (lub innego folderu obsługiwanego przez Twój serwer).

4. Uruchom aplikację:
    Otwórz przeglądarkę i przejdź pod adres:


## Korzystanie z Aplikacji 
1. Utwórz konto w systemie jako użytkownik biblioteki lub zaloguj się, jeśli już posiadasz konto. 
2. Wyszukuj książki i dokumenty za pomocą kategorii lub opcji wyszukiwania, aby znaleźć materiały, które Cię interesują. 
3. Możesz czytać książki bezpośrednio w aplikacji albo pobierz książki. 
4. Możesz pisać komentarze i dzielić się swoimi przemyśleniami na temat przeczytanych książek z innymi użytkownikami.Dodaj interesujące Cię książki do archiwum lub listy ulubionych, aby łatwo wrócić do nich w przyszłości. Jako administrator masz możliwość zarządzania zawartością biblioteki, w tym dodawania, edytowania lub usuwania książek.
5. Subskrypcja – użytkownicy mogą wybrać jeden z dostępnych planów subskrypcyjnych (Darmowy, Standard, Premium) i zrealizować subskrypcję zgodnie ze swoimi potrzebami.
6. Dodanie karty płatniczej – w celu aktywacji płatnej subskrypcji, użytkownicy mogą dodać dane swojej karty płatniczej do systemu.
7. Powiadomienia – system automatycznie wysyła powiadomienia o nowych książkach lub zmianach w bibliotece, dzięki czemu użytkownicy są na bieżąco z aktualizacjami.

## Wymagania systemowe

- PHP 7.4 lub nowszy
- MySQL 5.7 lub nowszy
- Serwer lokalny (np. XAMPP, WAMP, MAMP)
- Przeglądarka internetowa

## Struktura projektu

after_login/
•	edit_profile.php – Edycja profilu użytkownika.
•	logout.php – Wylogowanie użytkownika.
•	after_style.css – Stylizacja dla zalogowanych użytkowników.
•	uploads/ – Folder na przesłane pliki (np. zdjęcia profilowe).

browser/
•	Zasoby graficzne do przeglądania gatunków książek.

components/
•	header.php i footer.php – Wspólne komponenty interfejsu strony.

config/
•	config.php – Definicja stałej ścieżki bazowej (Base URL).
•	DatebaseConnector.php – Główna obsługa połączenia z MySQL.

database/
•	bookstore.sql – Plik z bazą danych (struktura i dane testowe).

font-awesome-4.7.0/
•	Ikony używane w interfejsie (czcionki, style, pliki źródłowe).

hdimg/
•	Obrazy graficzne strony, np. logo.png, tlo.jpg, homeback.png.

index_part/
•	book_display.php – Widok książek.
•	Browse_genres.php – Przeglądanie książek wg gatunków.
•	signup.php – Formularz rejestracji.

public/
    admin_view/
    •	add_book_view.php, edit_book_view.php - Widok dla administratora.
• archive_view.php, profile_view.php itd. - Widok dla wszystkich iżytkowników.

servis/
    admin/
    •	add_books.php, edit_book.php, delete_book.php – Logika dla administratora.
•	archive.php, karta.php, notifications.php, subscription.php – Logika dla wszystkich użytkowników.

uploads/
•	Folder do przechowywania plików przesłanych przez użytkowników.


Główne pliki projektu :
•	index.php – Strona główna.
•	index_after.php – Widok po zalogowaniu.
•	genre.php, search.php, readBook.php – Obsługa funkcji przeglądania i czytania książek.
•	ebook_style.css – Stylizacja e-booków.
•	LICENSE, README.md – Licencja i dokumentacja projektu.
