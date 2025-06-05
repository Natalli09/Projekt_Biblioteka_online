<?php
if (!defined('BASE_URL')) {
    include_once dirname(__DIR__) . '/config/config.php';
}
?>

<header style="background-color: #f8f9fa; padding: 20px 0; font-family: Arial, sans-serif; border-bottom: 1px solid #ddd;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div class="row" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">

            <!-- Logo -->
            <div id="logo" style="flex: 0 0 auto;">
                <a href="<?= BASE_URL ?>index_after.php" style="display: flex; align-items: center; text-decoration: none; color: inherit; gap: 10px;">
                    <img src="<?= BASE_URL ?>hdimg/logo.png" alt="logo" style="width: 60px; height: auto;" />
                    <span style="font-size: 1.6rem; font-weight: bold;">Biblioteka online</span>
                </a>
            </div>

            <!-- Search -->
            <div id="search" style="flex: 1 1 400px; display: flex; justify-content: center; margin-top: 10px; margin-bottom: 10px;">
                <form action="<?= BASE_URL ?>search.php" method="GET" style="display: flex; width: 100%; max-width: 300px;">
                    <input type="text" name="query" placeholder="Szukaj po tytule lub autorze"
                        style="flex: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px 0 0 4px; color: #000; background-color: #fff;">
                    <button type="submit"
                        style="padding: 8px 12px; background-color: #007bff; border: none; color: white; border-radius: 0 4px 4px 0;">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form>
            </div>

            <!-- Dropdown menu -->
             <?php if (isset($_SESSION['logid'])): ?>
            <div id="dropdown" style="flex: 0 0 auto;">
                <div class="dropdown" style="position: relative;">
                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"
                        style="padding: 8px 12px; border: 1px solid #ccc; background: white;">
                        <i class="fas fa-bars"></i> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right"
                        style="right: 0; left: auto; min-width: 200px; padding: 10px;">
                        <li><strong>Menu</strong></li>
                        <li><a href="<?= BASE_URL ?>servis/profile.php"><i class="fas fa-user"></i> Profil użytkownika</a></li>
                        <li><a href="<?= BASE_URL ?>servis/archive.php"><i class="fas fa-archive"></i> Archiwum</a></li>
                        <li><a href="<?= BASE_URL ?>genre.php"><i class="fas fa-book"></i> Gatunek</a></li>
                        <li><a href="<?= BASE_URL ?>servis/karta.php"><i class="fas fa-credit-card"></i> Dodaj kartę płatniczą</a></li>
                        <li><a href="<?= BASE_URL ?>servis/notifications.php"><i class="fas fa-bell"></i> Powiadomienia</a></li>
                        <li><a href="<?= BASE_URL ?>servis/subscription.php"><i class="fas fa-gem"></i> Subskrypcja</a></li>
                        <li><a href="<?= BASE_URL ?>after_login/logout.php"><i class="fas fa-sign-out-alt"></i> Wyloguj się</a></li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</header>
