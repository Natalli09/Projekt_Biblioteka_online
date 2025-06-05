</html>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Dodaj kartę płatniczą</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Oswald:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../after_login/after_style.css">
    <style>
        .form-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 15px;
            background-color: #f9f9f9;
        }
        .form-container h3 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include '../components/header.php'; ?>

<div class="container">
    <div class="form-container">
        <h3><i class="fas fa-credit-card"></i> Dodaj kartę płatniczą</h3>
        <?php echo $wiadomosc; ?>
        <form method="post" action="">
            <div class="form-group">
                <label>Numer karty</label>
                <input type="text" name="numer_karty" id="numer_karty" class="form-control" maxlength="19" placeholder="1234 5678 9012 3456" required>
            </div>
            <div class="form-group">
                <label>Data ważności (MM/YY)</label>
                <input type="text" name="waznosc" id="waznosc" class="form-control" placeholder="MM/YY" maxlength="5" pattern="^(0[1-9]|1[0-2])\/\d{2}$" required>
            </div>
            <div class="form-group">
                <label>CVV</label>
                <input type="text" name="cvv" class="form-control" maxlength="3" required>
            </div>
            <div class="form-group">
                <label>Imię i nazwisko właściciela</label>
                <input type="text" name="imie_nazwisko" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-plus-circle"></i> Dodaj kartę</button>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#numer_karty').on('input', function(e) {
        let value = $(this).val();
        // Usuwamy wszystko poza cyframi
        value = value.replace(/\D/g, '');
        // Grupujemy co 4 cyfry dodając spację
        value = value.match(/.{1,4}/g);
        if(value) {
            value = value.join(' ');
            if(value.length > 19) value = value.substr(0, 19);
            $(this).val(value);
        } else {
            $(this).val('');
        }
    });
    $('#waznosc').on('input', function(e) {
        let value = $(this).val();

        // Usuwamy wszystko poza cyframi
        value = value.replace(/\D/g, '');

        if(value.length > 2) {
            // Dodajemy slash po dwóch cyfrach
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }

        $(this).val(value);
    });
});
</script>


<?php include '../components/footer.php'; ?>

</body>
</html>