<?php
include "includes/header.php";
require_once "includes/db.php";

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<style>
  a { text-decoration: none; }
</style>

<div class="products">
  <?php foreach ($products as $product): ?>
    <div class="product-card-wrapper">
      <a href="product.php?id=<?= $product['id'] ?>" class="product-link">
        <div class="product-card">
          <div class="product-img-wrap">
            <img src="img/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
          </div>
          <h3><?= mb_strtoupper($product['name']) ?></h3>
          <p><?= htmlspecialchars($product['description']) ?></p>
        </div>
      </a>

      <div class="product-bottom">
        <div class="price-info">
          <span class="price-label">цена</span>
          <span class="price-value"><?= number_format($product['price'], 0, ',', ' ') ?> ₽</span>
        </div>

        <?php if (isset($_SESSION["user_id"])): ?>
        <button
          class="btn-orange add-to-cart"
          data-id="<?= $product['id'] ?>"
        >Купить</button>
        <?php else: ?>
        <a href="login.php" class="btn-orange">купить</a>
        <?php endif; ?>

      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php if (isset($_SESSION["user_id"])): ?>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".add-to-cart");
    buttons.forEach(button => {
      button.addEventListener("click", (e) => {
        e.stopPropagation();
        const productId = button.dataset.id;
        fetch("cart.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `product_id=${productId}&action=add`
        }).then(res => {
          if (res.ok) {
            button.textContent = "В корзине";
            button.classList.remove("btn-orange");
            button.classList.add("btn-in-cart");
            button.disabled = true;
          }
        });
      });
    });
  });
</script>
<?php endif; ?>
<?php include "includes/footer.php"; ?>
