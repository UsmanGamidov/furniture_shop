<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

echo "<div>";

require_once "includes/db.php";

// Добавление товара
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['action']) && $_POST['action'] === 'add') {
    $id = (int) $_POST['product_id'];
    $qty = isset($_POST['quantity']) ? max(1, (int) $_POST['quantity']) : 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        echo 'ok';
        exit;
    }

    header("Location: cart.php");
    exit;
}

// Очистка корзины
if (isset($_POST['action']) && $_POST['action'] === 'clear') {
    $_SESSION['cart'] = [];
    header("Location: cart.php");
    exit;
}

include "includes/header.php";

if (empty($_SESSION['cart'])) {
    echo "<p>Корзина пуста.</p></div>";
    exit;
}

$cart = $_SESSION['cart'];
$total = 0;

echo "<form method='post' style='padding-top: 100px'>";
echo "<table>
  <thead>
    <tr>
      <th>Фото</th>
      <th>Товар</th>
      <th>Кол-во</th>
      <th>Цена</th>
      <th>Сумма</th>
    </tr>
  </thead>
  <tbody>";

foreach ($cart as $product_id => $quantity) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if ($product) {
        $sum = $product['price'] * $quantity;
        $total += $sum;

        echo "<tr>
          <td data-label='Фото'><img style='width: 80px;' src='./img/{$product['image']}'></td>
          <td data-label='Товар'>{$product['name']}</td>
          <td data-label='Кол-во'>{$quantity}</td>
          <td data-label='Цена'>{$product['price']} ₽</td>
          <td data-label='Сумма'>{$sum} ₽</td>
        </tr>";
    }
}

echo "<tr><td colspan='4'><strong>Итого:</strong></td><td><strong>{$total} ₽</strong></td></tr>
  </tbody></table><br>";

echo "
<div style='display: flex; gap: 15px; margin-top: 20px; flex-wrap: wrap;'>
  <form method='post'>
    <input type='hidden' name='action' value='clear'>
    <button type='submit' class='btn-red'>Очистить корзину</button>
  </form>

  <form method='post' action='order.php'>
    <button type='submit' class='btn-red'>Оформить заказ</button>
  </form>
</div>
</div>";
