<?php
session_start();

if (!isset($_SESSION['logid'])) {
    header('location:index.php');
    exit();
}

require_once __DIR__ . '/../config/DatebaseConnector.php';

$logid = $_SESSION['logid'];

// Pobierz dane użytkownika
$stmt = $conn->prepare("SELECT fname, lname, email, profile_picture FROM sign_up WHERE id_user = ?");
$stmt->bind_param("i", $logid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Nie znaleziono użytkownika - wyloguj
    header('location:index.php');
    exit();
}

$user = $result->fetch_assoc();

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $profile_picture = $user['profile_picture']; // domyślnie stara nazwa pliku

    // Walidacja pól
    if (empty($fname) || empty($lname) || empty($email)) {
        $error_message = "Wszystkie pola są wymagane!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Niepoprawny format adresu email!";
    } else {
        // Obsługa uploadu zdjęcia
        if (!empty($_FILES['profile_picture']['name'])) {
            $allowed_types = ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'];
            $image_info = getimagesize($_FILES['profile_picture']['tmp_name']);

            if ($image_info === false) {
                $error_message = "Nieprawidłowy plik obrazu!";
            } elseif (!in_array($image_info['mime'], $allowed_types)) {
                $error_message = "Obsługiwane są tylko pliki JPG, PNG i GIF!";
            } else {
                $target_dir = "uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }

                // Unikalna nazwa pliku
                $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
                $unique_name = uniqid('profile_', true) . '.' . $ext;
                $upload_path = $target_dir . $unique_name;

                // Przenieś plik
                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
                    // Usuń stary plik, jeśli istnieje i jest inny niż domyślny
                    if (!empty($user['profile_picture']) && file_exists($target_dir . $user['profile_picture'])) {
                        unlink($target_dir . $user['profile_picture']);
                    }
                    $profile_picture = $unique_name; // zapisujemy tylko nazwę pliku
                } else {
                    $error_message = "Błąd podczas przesyłania zdjęcia profilowego!";
                }
            }
        }
    }

    if (empty($error_message)) {
        $update_stmt = $conn->prepare("UPDATE sign_up SET fname = ?, lname = ?, email = ?, profile_picture = ? WHERE id_user = ?");
        $update_stmt->bind_param("ssssi", $fname, $lname, $email, $profile_picture, $logid);

        if ($update_stmt->execute()) {
            $success_message = "Twój profil został zaktualizowany pomyślnie!";
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
            $_SESSION['email'] = $email;
            $user['fname'] = $fname;
            $user['lname'] = $lname;
            $user['email'] = $email;
            $user['profile_picture'] = $profile_picture;
        } else {
            $error_message = "Błąd podczas aktualizacji profilu: " . $update_stmt->error;
        }
        $update_stmt->close();
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <title>Edytuj Profil</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" />
</head>
<body>
<div class="container" style="max-width:600px; margin-top:40px;">
    <h2>Edytuj Profil</h2>

    <?php if ($success_message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
    <?php elseif ($error_message): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <?php if (!empty($user['profile_picture']) && file_exists('uploads/' . $user['profile_picture'])): ?>
        <div style="margin-bottom:20px;">
            <img src="uploads/<?= htmlspecialchars($user['profile_picture']) ?>" alt="Zdjęcie profilowe" style="max-width:150px; border-radius:5px;">
        </div>
    <?php else: ?>
        <div style="margin-bottom:20px;">
            <i class="glyphicon glyphicon-user" style="font-size:150px;color:#ccc;"></i>
        </div>
    <?php endif; ?>

    <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fname">Imię</label>
            <input type="text" name="fname" id="fname" class="form-control" value="<?= htmlspecialchars($user['fname']) ?>" required />
        </div>
        <div class="form-group">
            <label for="lname">Nazwisko</label>
            <input type="text" name="lname" id="lname" class="form-control" value="<?= htmlspecialchars($user['lname']) ?>" required />
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required />
        </div>
        <div class="form-group">
            <label for="profile_picture">Nowe zdjęcie profilowe (opcjonalnie)</label>
            <input type="file" name="profile_picture" id="profile_picture" class="form-control" accept="image/jpeg,image/png,image/gif" />
        </div>
        <button type="submit" class="btn btn-primary">Zaktualizuj Profil</button>
    </form>
</div>
</body>
</html>
