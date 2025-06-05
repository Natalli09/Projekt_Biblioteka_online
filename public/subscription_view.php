<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Subskrypcje</title>
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
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 15px;
            background-color: #f9f9f9;
        }
        .plan-box {
            padding: 20px;
            border: 2px solid #ddd;
            border-radius: 10px;
            margin-bottom: 20px;
            background-color: #fcfcfc;
            transition: 0.3s ease-in-out;
        }
        .plan-box:hover {
            border-color: #337ab7;
            background-color: #f5f5f5;
        }
        .plan-header {
            font-size: 20px;
            font-weight: bold;
        }
        .plan-price {
            font-size: 24px;
            color: #5cb85c;
            margin-top: 10px;
        }
        .plan-features {
            margin-top: 10px;
            list-style-type: none;
            padding-left: 0;
        }
    </style>
</head>
<body>

<?php include '../components/header.php'; ?>

<div class="container">
    <div class="form-container">
        <h3><i class="fas fa-gem"></i> Wybierz plan subskrypcji</h3>

        <?php if ($message): ?>
            <div class="alert alert-info"><?= $message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="plan-box">
                <div class="plan-header">Darmowy</div>
                <div class="plan-price">0 zł / miesiąc</div>
                <ul class="plan-features">
                    <li>✅ Przeglądanie książek</li>
                    <li>❌ Pobieranie plików</li>
                    <li>❌ Powiadomienia</li>
                </ul>
                <button type="submit" name="plan" value="free" class="btn btn-default">Subskrybuj</button>
            </div>

            <div class="plan-box">
                <div class="plan-header">Standard</div>
                <div class="plan-price">19 zł / miesiąc</div>
                <ul class="plan-features">
                    <li>✅ Przeglądanie</li>
                    <li>✅ Pobieranie PDF</li>
                    <li>✅ E-mailowe powiadomienia</li>
                </ul>
                <button type="submit" name="plan" value="standard" class="btn btn-success">Subskrybuj</button>
            </div>

            <div class="plan-box">
                <div class="plan-header">Premium</div>
                <div class="plan-price">39 zł / miesiąc</div>
                <ul class="plan-features">
                    <li>✅ Wszystkie funkcje</li>
                    <li>✅ Dostęp do nowych książek przedpremierowo</li>
                    <li>✅ Wsparcie premium 24/7</li>
                </ul>
                <button type="submit" name="plan" value="premium" class="btn btn-warning">Subskrybuj</button>
            </div>
        </form>
    </div>
</div>

<?php include '../components/footer.php'; ?>
</body>
</html>
