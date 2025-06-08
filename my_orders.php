<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

if (!isset($_SESSION["user_id"])) {
  echo "<p>Пожалуйста, <a href='login.php'>войдите</a>, чтобы увидеть свои заказы.</p>";
  include "includes/footer.php";
  exit;
}

$userId = $_SESSION["user_id"];

$stmt = $pdo->prepare("
    SELECT o.id AS order_id, o.total, o.created_at, p.name, p.price, oi.quantity
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON p.id = oi.product_id
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll();
?>

<div style="padding-top: 80px;">
  <?php if (!$orders): ?>
    <p>У вас пока нет заказов.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Заказ №</th>
          <th>Дата</th>
          <th>Товар</th>
          <th>Цена</th>
          <th>Кол-во</th>
          <th>Сумма</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $row): ?>
          <tr>
            <td data-label="Заказ №"><?= $row["order_id"] ?></td>
            <td data-label="Дата"><?= $row["created_at"] ?></td>
            <td data-label="Товар"><?= htmlspecialchars($row["name"]) ?></td>
            <td data-label="Цена"><?= $row["price"] ?> ₽</td>
            <td data-label="Кол-во"><?= $row["quantity"] ?></td>
            <td data-label="Сумма"><?= $row["price"] * $row["quantity"] ?> ₽</td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
