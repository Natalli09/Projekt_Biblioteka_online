<?php
if (!defined('BASE_URL')) {
    include_once dirname(__DIR__) . '/config/config.php';
}
?>
<footer class="footer" id="footer" style="margin-top: 150px; padding: 40px 20px; background-color: #f8f9fa; font-family: Arial, sans-serif; color: #333;">
  <div class="container" style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; padding-left: 0; padding-right: 0;">

    <!-- Logo po lewej -->
    <div id="logofoot" style="flex: 0 0 auto; margin-left: 0;">
      <a href="<?= BASE_URL ?>index_after.php" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 15px;">
        <img src="<?= BASE_URL ?>hdimg/logo.png" alt="Biblioteka online logo" style="width: 120px; height: auto; display: block;">
        <span style="font-weight: bold; font-size: 1.8rem;">Biblioteka online</span>
      </a>
    </div>
        
    <!-- Informacje kontaktowe po prawej -->
    <div id="footelement" style="flex: 0 0 auto; text-align: right; min-width: 900px;">
      <h2 style="font-size: 1.5rem; margin-bottom: 15px;">Informacje o produkcie</h2>
      <p style="margin: 5px 0;">Kontakt niedostępny: <a href="tel:+48321123321" style="color:rgb(255, 255, 255); text-decoration: none;">+48 321 123 321</a></p>
      <p style="margin: 5px 0;">Email: <a href="mailto:elibrary2k24@gmail.com" style="color:rgb(255, 255, 255); text-decoration: none;">elibrary2k24@gmail.com</a></p>
      <p style="margin: 5px 0;">Adres: Polska, Gorzów Wlkp.</p>
    </div>

  </div>

  <hr style="border-color: #ddd; margin: 20px 0;">

  <div class="credit" id="footelement" style="text-align: center; font-size: 0.9rem; color: #666;">
    <i class="fa fa-copyright" aria-hidden="true"></i>
    Copyright &copy; 2026 Biblioteka online | All rights reserved
  </div>
</footer>
