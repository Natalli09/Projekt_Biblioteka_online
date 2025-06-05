<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Powiadomienia</title>
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
        /* Podświetlenie nieprzeczytanych */
        .notification-unread {
            background-color: #d9edf7; /* jasnoniebieski */
        }
        .notification-message {
            cursor: pointer;
        }
        .notification-timestamp {
            font-size: 0.85em;
            color: #777;
            margin-top: 5px;
        }
    </style>
</head>

<body>
<?php include '../components/header.php'; ?>

<div class="container">
    <div class="form-container">
        <h3><i class="fas fa-bell"></i> Twoje powiadomienia</h3>

        <?php if ($result->num_rows === 0): ?>
            <div class="alert alert-info">Brak powiadomień.</div>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div 
                    class="alert alert-<?= htmlspecialchars($row['type']) ?> notification-message <?= $row['is_read'] ? '' : 'notification-unread' ?>" 
                    data-id="<?= (int)$row['id'] ?>"
                    role="alert"
                >
                    <?= htmlspecialchars($row['message']) ?>
                    <div class="notification-timestamp"><?= date("d.m.Y H:i", strtotime($row['created_at'])) ?></div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.notification-message').click(function() {
        var el = $(this);
        var id = el.data('id');

        $.post('../servis/notifications.php', { read_id: id }, function() {
            el.removeClass('notification-unread');
        });
    });
});
</script>

<?php include '../components/footer.php'; ?>

</body>
</html>
