<?php
session_start();
require_once 'db.php';

if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// Проверка дали продуктът съществува в БД
$stmt = $pdo->prepare("SELECT id FROM products WHERE id = ?");
$stmt->execute([$id]);
if(!$stmt->fetch()){
    // Ако продуктът не съществува, връщаме към индекса
    header("Location: index.php");
    exit();
}

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

if(!in_array($id, $_SESSION['cart'])){
    $_SESSION['cart'][] = $id;
}

header("Location: index.php");
exit();
?>