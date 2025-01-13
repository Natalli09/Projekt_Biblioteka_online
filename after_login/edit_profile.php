<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['logid'])) {
    header('location:index.php'); 
    exit();
}

// Połączenie z bazą danych
$conn = mysqli_connect('localhost', 'root', '', 'bookstore');

// Pobranie danych użytkownika na podstawie sesji
$logid = $_SESSION['logid'];
$query = "SELECT fname, lname, email FROM sign_up WHERE id_user = '$logid'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['fname'] = $user['fname'];
    $_SESSION['lname'] = $user['lname'];
    $_SESSION['email'] = $user['email'];
} else {
    header('location:index.php'); 
    exit();
}

// Edytowanie profilu użytkownika
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $profile_picture = $user['profile_picture']; // Domyślnie zachowujemy starą fotografię profilu

    // Obrobienie przesyłania nowego zdjęcia profilowego
    if (!empty($_FILES['profile_picture']['name'])) {
        $target_dir = "uploads/";
        $unique_name = uniqid() . "_" . basename($_FILES['profile_picture']['name']);
        $profile_picture = $target_dir . $unique_name;

        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture)) {
            die("Błąd podczas przesyłania zdjęcia profilowego!");
        }
    }

    // Aktualizacja danych użytkownika w bazie danych
    if (!empty($fname) && !empty($lname) && !empty($email)) {
        $sql = "UPDATE sign_up 
                SET fname = ?, lname = ?, email = ?, profile_picture = ? 
                WHERE id_user = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssssi", $fname, $lname, $email, $profile_picture, $logid);

            if ($stmt->execute()) {
                $success_message = "Twój profil został zaktualizowany pomyślnie!";
                $_SESSION['fname'] = $fname;  // Zaktualizowanie sesji z nowymi danymi
                $_SESSION['lname'] = $lname;
                $_SESSION['email'] = $email;
            } else {
                $error_message = "Błąd podczas aktualizacji profilu: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error_message = "Błąd podczas przygotowywania zapytania: " . $conn->error;
        }
    } else {
        $error_message = "Wszystkie pola są wymagane!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj Profil</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Edytuj Profil</h2>

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

        <!-- Formularz edytowania profilu -->
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fname">Imię</label>
                <input type="text" name="fname" id="fname" class="form-control" value="<?= htmlspecialchars($user['fname']) ?>" required>
            </div>
            <div class="form-group">
                <label for="lname">Nazwisko</label>
                <input type="text" name="lname" id="lname" class="form-control" value="<?= htmlspecialchars($user['lname']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="profile_picture">Nowe zdjęcie profilowe (opcjonalnie)</label>
                <input type="file" name="profile_picture" id="profile_picture" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Zaktualizuj Profil</button>
        </form>
    </div>
</body>
</html>
