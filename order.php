<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

echo "<div style='padding-top: 80px;'>";


// Проверка авторизации
if (!isset($_SESSION["user_id"])) {
    echo "<p>Для оформления заказа нужно <a href='login.php'>войти</a>.</p>";
    include "includes/footer.php";
    exit;
}

// Проверка корзины
if (empty($_SESSION['cart'])) {
    echo "<p>Корзина пуста. <a href='products.php'>Перейти в каталог</a></p>";
    include "includes/footer.php";
    exit;
}

$userId = $_SESSION["user_id"];
$cart = $_SESSION["cart"];
$total = 0;

// Получаем товары
$ids = implode(",", array_keys($cart));
$stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
$products = $stmt->fetchAll();

foreach ($products as $product) {
    $qty = $cart[$product["id"]];
    $total += $product["price"] * $qty;
}

// Сохраняем заказ
$stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
$stmt->execute([$userId, $total]);
$orderId = $pdo->lastInsertId();

// Сохраняем товары заказа
$stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
foreach ($products as $product) {
    $stmtItem->execute([$orderId, $product["id"], $cart[$product["id"]]]);
}

// Очищаем корзину
$_SESSION["cart"] = [];
echo "<h2>Спасибо за заказ!</h2>";
echo "<p>Ваш заказ №$orderId на сумму $total ₽ успешно оформлен.</p>";
echo "<a href='products.php'>Вернуться в каталог</a>";
echo "</div>";

