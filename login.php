<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            header("Location: index.php");
            exit;
        } else {
            $message = "Неверный email или пароль.";
        }
    } else {
        $message = "Пожалуйста, заполните все поля.";
    }
}
?>

<div class="container">
  <div class="auth-form">
    <h2>Вход в систему</h2>

    <?php if ($message): ?>
      <p class="error-message"><?= $message ?></p>
    <?php endif; ?>

    <form method="post" action="">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button type="submit">Войти</button>
    </form>

    <p class="auth-link">Нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
  </div>
</div>

