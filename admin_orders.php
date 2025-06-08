<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

if ($_SESSION["user_id"] !== 1) {
  echo "<p>Доступ запрещён.</p>";
  include "includes/footer.php";
  exit;
}

$stmt = $pdo->query("
    SELECT o.id AS order_id, u.name AS user_name, o.total, o.created_at,
           p.name AS product_name, oi.quantity
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON p.id = oi.product_id
    ORDER BY o.created_at DESC
");
$orders = $stmt->fetchAll();
?>
<div style="padding-top: 80px;">
  <h2>Все заказы (админка)</h2>

  <?php if (!$orders): ?>
    <p>Заказов пока нет.</p>
  <?php else: ?>
    
    <table>
      <thead>
        <tr>
          <th>Заказ №</th>
          <th>Пользователь</th>
          <th>Дата</th>
          <th>Товар</th>
          <th>Кол-во</th>
          <th>Сумма</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $row): ?>
          <tr>
            <td data-label="Заказ №"><?= $row["order_id"] ?></td>
            <td data-label="Пользователь"><?= htmlspecialchars($row["user_name"]) ?></td>
            <td data-label="Дата"><?= $row["created_at"] ?></td>
            <td data-label="Товар"><?= htmlspecialchars($row["product_name"]) ?></td>
            <td data-label="Кол-во"><?= $row["quantity"] ?></td>
            <td data-label="Сумма"><?= $row["quantity"] * $row["total"] ?> ₽</td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
