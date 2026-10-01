<?php
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

$pdo = new PDO('mysql:host=db;dbname=konference;charset=utf8mb4', 'app', 'app', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);
echo 'Web i databáze fungují.';