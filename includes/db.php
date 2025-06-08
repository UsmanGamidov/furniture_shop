<?php
$host = 'localhost';
$db   = 'furniture_shop';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// $host = 'localhost';
// $db   = 'u98822ez_main';
// $user = 'u98822ez';
// $pass = '17Osma17';
// $charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     die("Ошибка подключения к БД: " . $e->getMessage());
}
?>
