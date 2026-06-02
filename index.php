<?php
session_start();
require_once 'db.php'; // Включваме връзката с БД

// Вземаме продуктите от базата данни
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();

// Брой продукти в количката
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="bg">
<head>
<meta charset="UTF-8">
<title>My Shop</title>
<link rel="icon" href="img/cart.ico" type="image/x-icon">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="img/cart.ico" alt="Logo" height="40" class="me-2"> My Shop
    </a>
    <a href="cart.php" class="btn btn-warning position-relative">
      <i class="bi bi-cart-fill"></i>
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        <?php echo $cartCount; ?>
      </span>
    </a>
  </div>
</nav>

<div class="container mt-5">
  <div class="row g-4">
    <?php foreach($products as $product): ?>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="img/<?php echo $product['image']; ?>" class="card-img-top p-3" alt="<?php echo $product['name']; ?>" style="height:250px; object-fit:contain;">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo $product['name']; ?></h5>
            <p class="card-text fw-bold"><?php echo number_format($product['price'], 2); ?> $</p>
            <a href="add.php?id=<?php echo $product['id']; ?>" class="btn btn-success mt-auto">
              <i class="bi bi-cart-plus"></i> Add to Cart
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

</body>
</html>