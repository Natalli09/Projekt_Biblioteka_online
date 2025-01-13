<?php
session_start();
if (!isset($_SESSION['logid'])) {
    header('location:index.php'); 
    exit();
}

// Połączenie z bazą danych
$conn = mysqli_connect('localhost', 'root', '', 'bookstore');

$logid = $_SESSION['logid'];
$query = "SELECT fname, lname, email, profile_picture FROM sign_up WHERE id_user = '$logid'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['fname'] = $user['fname'];
    $_SESSION['lname'] = $user['lname'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['profile_picture'] = $user['profile_picture'];
} else {
    header('location:index.php'); 
    exit();
}
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
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="after_login/after_style.css">
    <link rel="icon" href="hdimg/logo.png">
    <title>Profil Użytkownika - Biblioteka online</title>

    <style>
        .profile-picture {
            text-align: center;
        }

        #edit-profile-form {
            display: none; 
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#editProfileBtn').click(function() {
                $('#edit-profile-form').slideToggle(); 
            });

            $('#cancelEditBtn').click(function() {
                $('#edit-profile-form').slideToggle(); 
            });

            // Obsługa przesyłania formularza edycji za pomocą AJAX
            $('#edit-profile-form').submit(function(e) {
                e.preventDefault(); // Zapobiega przeładowaniu strony

                var formData = new FormData(this); // Pobierz dane z formularza

                $.ajax({
                    url: 'edit_profile.php', // Ścieżka do pliku obsługującego zapis w bazie
                    type: 'POST',
                    data: formData,
                    processData: false, // Nie przetwarzaj danych jako ciąg tekstowy
                    contentType: false, // Nie ustawiaj typu danych
                    success: function(response) {
                        // Wyświetlamy komunikat z odpowiedzi
                        $('#response-message').html('<div class="alert alert-info">' + response + '</div>');
                        if (response.includes("successfully")) {
                            setTimeout(function() {
                                location.reload(); // Przeładuj stronę po sukcesie
                            }, 2000);
                        }
                    },
                    error: function() {
                        // Obsługuje błędy, jeśli wystąpią
                        $('#response-message').html('<div class="alert alert-danger">Wystąpił błąd podczas zapisywania danych.</div>');
                    }
                });
            });
        });
    </script>
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

            <div class="col-md-3" id="dropdown">
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

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mt-3">
                <h3>Dane użytkownika:</h3>

                <div class="profile-picture">
                    <?php if ($_SESSION['profile_picture']) { ?>
                        <img src="uploads/<?php echo $_SESSION['profile_picture']; ?>" alt="Profile Picture" style="width:150px; height:150px; border-radius:50%;">
                    <?php } else { ?>
                        <i class="fas fa-user" style="font-size: 150px; color: black;"></i>
                    <?php } ?>
                </div>

                <p><strong>Imię: </strong><?php echo $_SESSION['fname']; ?></p>
                <p style="margin-bottom: 10px;"><strong>Nazwisko: </strong><?php echo $_SESSION['lname']; ?></p>
                <p style="margin-bottom: 20px;"><strong>Email: </strong><?php echo $_SESSION['email']; ?></p>

                <div class="text-center">
                    <?php if (isset($_SESSION['fname'])): ?>
                        <a href="after_login/edit_profile.php" class="btn btn-primary" style="margin-top: 20px;">
                            <i class=></i> Edytuj profil
                        </a>
                    <?php endif; ?>
                </div>
                <div class="text-center">
                    <?php if (isset($_SESSION['fname']) && $_SESSION['fname'] === 'Nataliia'): ?>
                        <a href="admin/add_books.php" class="btn btn-primary" style="margin-top: 20px;">
                            <i class="fas fa-plus"></i> Dodaj książkę
                        </a>
                    <?php endif; ?>
                </div>
        </div>
    </div>

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

</body>

</html>
