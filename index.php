<?php include "includes/header.php"; ?>
<div class="slider">
    <a href="/furniture_shop/products.php" class="slide slide1 active">
        <img class="main-photo" src="./img/slide1.jpg" alt="">
    </a>
    <a href="/furniture_shop/products.php" class="slide slide2">
        <img class="main-photo" src="./img/slide2.jpg" alt="">
    </a>
</div>
<div class="container">
    <div class="products">
        <?php
        require_once "includes/db.php";
        $stmt = $pdo->query("SELECT * FROM products LIMIT 8");
        $products = $stmt->fetchAll();

        foreach ($products as $product):
            ?>
            <div class="product-card">
                <img src="img/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <strong><?= $product['price'] ?> ₽</strong><br>
                <a href="product.php?id=<?= $product['id'] ?>">
                    <button>Подробнее</button>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>




<script>
    let current = 0;
    const slides = document.querySelectorAll('.slide');

    setInterval(() => {
        slides[current].classList.remove('active');
        current = (current + 1) % slides.length;
        slides[current].classList.add('active');
    }, 7000);
</script>




<?php include "includes/footer.php"; ?>