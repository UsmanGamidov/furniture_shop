<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Интернет-магазин мебели</title>
  <link rel="stylesheet" href="/furniture_shop/css/style.css">
  <link rel="stylesheet" href="/furniture_shop/css/header.css">
  <link rel="stylesheet" href="/furniture_shop/css/products.css">
  <link rel="stylesheet" href="/furniture_shop/css/footer.css">
  <link rel="stylesheet" href="/furniture_shop/css/forms.css">

</head>

<body>

  <header class="overlay-header">
    <div class="container header-line">
      <button class="burger" onclick="toggleMenu()" aria-label="Меню">☰</button>
      <a href="/furniture_shop/index.php">
        <div class="logo">SK Mebel</div>
      </a>
      <div class="nav-wrapper">
        <nav class="main-nav">
          <a href="/furniture_shop/index.php"
            class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">Главная</a>
          <a href="/furniture_shop/products.php"
            class="<?= basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : '' ?>">Каталог</a>
          <?php if (isset($_SESSION["user_id"])): ?>
            <a href="/furniture_shop/cart.php"
              class="<?= basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'active' : '' ?>">Корзина</a>
            <a href="/furniture_shop/my_orders.php"
              class="<?= basename($_SERVER['PHP_SELF']) == 'my_orders.php' ? 'active' : '' ?>">Мои заказы</a>
          <?php endif; ?>
          <?php if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == 1): ?>
            <a href="/furniture_shop/admin_orders.php">Админка</a>
          <?php endif; ?>
          <?php if (isset($_SESSION["user_id"])): ?>
            <a href="/furniture_shop/logout.php">Выход</a>
          <?php else: ?>
            <a href="/furniture_shop/login.php"
              class="<?= basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : '' ?>">Вход</a>
            <a href="/furniture_shop/register.php"
              class="<?= basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : '' ?>">Регистрация</a>
          <?php endif; ?>
        </nav>
      </div>
    </div>
  </header>

  <script>
    function toggleMenu() {
      const nav = document.querySelector('.main-nav');
      nav.classList.toggle('show');
    }

    document.addEventListener('click', function (e) {
      if (!e.target.closest('.main-nav') && !e.target.closest('.burger')) {
        document.querySelector('.main-nav')?.classList.remove('show');
      }
    });
  </script>