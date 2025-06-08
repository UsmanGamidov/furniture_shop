<?php
require_once "includes/db.php";
include "includes/header.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
  echo "<p>Товар не найден.</p>";
  include "includes/footer.php";
  exit;
}
?>

<div class="container">
  <div class="product-page">
    <div class="product-gallery">
      <img class="main-photo" src="img/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
      <div class="thumbs">
        <img src="img/<?= htmlspecialchars($product['image']) ?>" alt="" onclick="document.querySelector('.main-photo').src=this.src;">
        <img src="img/<?= htmlspecialchars($product['image']) ?>" alt="" onclick="document.querySelector('.main-photo').src=this.src;">
        <img src="img/<?= htmlspecialchars($product['image']) ?>" alt="" onclick="document.querySelector('.main-photo').src=this.src;">
      </div>
    </div>

    <div class="product-info">
      <h2><?= htmlspecialchars($product['name']) ?></h2>
      <div class="price"><?= number_format($product['price'], 0, ',', ' ') ?> ₽</div>

      <div class="quantity-control">
        <button onclick="changeQty(-1)">-</button>
        <input type="number" id="qty" value="1" min="1">
        <button onclick="changeQty(1)">+</button>
      </div>

      <?php if (isset($_SESSION["user_id"])): ?>
        <button class="btn-orange" onclick="addToCart(<?= $product['id'] ?>)">В корзину</button>
      <?php else: ?>
        <a href="login.php" class="btn-orange">Войдите, чтобы купить</a>
      <?php endif; ?>

      <div class="extra-info">
        <p><strong>На складе:</strong> много</p>
        <p><strong>Доставка:</strong> от 990 ₽</p>
        <p><strong>Описание:</strong> <?= htmlspecialchars($product['description']) ?></p>
        <p><strong>Код товара:</strong> <?= $product['id'] ?></p>
      </div>
    </div>
  </div>

  <div class="product-specs">
    <h3>Характеристики</h3>
    <div class="specs-grid">
      <div>
        <p><strong>Ширина</strong><br>50 см</p>
        <p><strong>Глубина</strong><br>65 см</p>
        <p><strong>Высота</strong><br>88 см</p>
        <p><strong>Высота сидения</strong><br>49 см</p>
        <p><strong>Материалы:</strong><br>металл, экозамша</p>
      </div>
      <div>
        <p><strong>Особенность:</strong><br>Поворотное сиденье</p>
        <p><strong>Вес</strong><br>7.7 кг</p>
        <p><strong>Объём в упаковке</strong><br>0.076 м³</p>
        <p><strong>Гарантия</strong><br>1 год</p>
      </div>
    </div>
  </div>
</div>

<?php if (isset($_SESSION["user_id"])): ?>
<script>
  function changeQty(delta) {
    const input = document.getElementById('qty');
    const newVal = Math.max(1, parseInt(input.value) + delta);
    input.value = newVal;
  }

  function addToCart(productId) {
    const qty = document.getElementById('qty').value;
    fetch("cart.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `product_id=${productId}&action=add&quantity=${qty}`
    }).then(res => {
      if (res.ok) alert("Товар добавлен в корзину!");
    });
  }
</script>
<?php endif; ?>

<?php include "includes/footer.php"; ?>
