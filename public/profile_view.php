<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Lobster&family=Oswald:wght@600&display=swap"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="../after_login/after_style.css" />
    <link rel="icon" href="hdimg/logo.png" />
    <title>Profil Użytkownika - Biblioteka online</title>

    <style>
        .profile-picture {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-picture img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        #edit-profile-form {
            display: none;
        }
    </style>

    <script>
        $(document).ready(function () {
            $('#editProfileBtn').click(function () {
                $('#edit-profile-form').slideToggle();
            });

            $('#cancelEditBtn').click(function () {
                $('#edit-profile-form').slideToggle();
            });

            $('#edit-profile-form').submit(function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: 'edit_profile.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#response-message').html('<div class="alert alert-info">' + response + '</div>');
                        if (response.includes("successfully")) {
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    },
                    error: function () {
                        $('#response-message').html('<div class="alert alert-danger">Wystąpił błąd podczas zapisywania danych.</div>');
                    }
                });
            });
        });
    </script>
</head>

<body>
    <?php include '../components/header.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mt-3">
                <h3>Dane użytkownika:</h3>

                <div class="profile-picture">
                    <?php
                    $profilePic = $_SESSION['profile_picture'] ?? '';
                    $profilePath = "../after_login/uploads/" . $profilePic;
                    if (!empty($profilePic) && file_exists($profilePath)) {
                        echo '<img src="' . htmlspecialchars($profilePath) . '" alt="Zdjęcie profilowe" />';
                    } else {
                        echo '<i class="fas fa-user" style="font-size: 150px; color: black;"></i>';
                    }
                    ?>
                </div>

                <p><strong>Imię: </strong><?php echo htmlspecialchars($_SESSION['fname']); ?></p>
                <p style="margin-bottom: 10px;"><strong>Nazwisko: </strong><?php echo htmlspecialchars($_SESSION['lname']); ?></p>
                <p style="margin-bottom: 20px;"><strong>Email: </strong><?php echo htmlspecialchars($_SESSION['email']); ?></p>

                <div class="text-center">
                    <?php if (isset($_SESSION['fname'])) : ?>
                        <a href="../after_login/edit_profile.php" class="btn btn-primary" style="margin-top: 20px;">
                            <i class="fas fa-edit"></i> Edytuj profil
                        </a>
                    <?php endif; ?>
                </div>
                <div class="text-center">
                    <?php if (isset($_SESSION['fname']) && $_SESSION['fname'] === 'Nataliia') : ?>
                        <a href="../servis/admin/add_books.php" class="btn btn-primary" style="margin-top: 20px;">
                            <i class="fas fa-plus"></i> Dodaj książkę
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include '../components/footer.php'; ?>
</body>

</html>
