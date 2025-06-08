<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if ($name && $email && $password) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $message = "Пользователь с таким email уже существует.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashedPassword]);
            $message = "Регистрация прошла успешно. <a href='login.php'>Войти</a>";
        }
    } else {
        $message = "Пожалуйста, заполните все поля.";
    }
}
?>

<div class="container">
  <div class="auth-form">
    <h2>Регистрация</h2>

    <?php if ($message): ?>
      <p class="<?= strpos($message, 'успешно') !== false ? 'success-message' : 'error-message' ?>">
        <?= $message ?>
      </p>
    <?php endif; ?>

    <form method="post" action="">
      <input type="text" name="name" placeholder="Ваше имя" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button type="submit">Зарегистрироваться</button>
    </form>

    <p class="auth-link">Уже есть аккаунт? <a href="login.php">Войти</a></p>
  </div>
</div>

