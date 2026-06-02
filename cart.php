<?php
session_start();
require_once 'db.php';

$cartProducts = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    // Създаваме плейсхолдъри (?, ?, ?) за сигурност срещу SQL инжекции
    $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($_SESSION['cart']);
    $dbProducts = $stmt->fetchAll();

    // Пренареждаме продуктите в масив с ключове ID-тата им, за по-лесно извеждане
    foreach ($dbProducts as $prod) {
        $cartProducts[$prod['id']] = $prod;
    }

    // Почистваме сесията, ако има останало ID на изтрит от БД продукт
    $validCart = [];
    foreach ($_SESSION['cart'] as $id) {
        if (isset($cartProducts[$id])) {
            $validCart[] = $id;
            $total += $cartProducts[$id]['price'];
        }
    }
    $_SESSION['cart'] = $validCart;
}

$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="bg">
<head>
<meta charset="UTF-8">
<title>My Cart</title>
<link rel="icon" href="img/cart.ico" type="image/x-icon">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="img/cart.ico" alt="My Shop" height="40" class="me-2"> My Shop
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
  <h2 class="mb-4">Your Shopping Cart</h2>

  <?php if(!empty($_SESSION['cart'])): ?>
    <div class="table-responsive">
      <table class="table table-hover align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>Product</th>
            <th>Image</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($_SESSION['cart'] as $id): 
            if(!isset($cartProducts[$id])) continue;
            $product = $cartProducts[$id]; 
          ?>
            <tr>
              <td><?php echo $product['name']; ?></td>
              <td><img src="img/<?php echo $product['image']; ?>" height="60" alt="<?php echo $product['name']; ?>"></td>
              <td><?php echo number_format($product['price'], 2); ?> $</td>
              <td>
                <a href="remove.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">
                  <i class="bi bi-trash"></i> Remove
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <h4 class="text-end mt-3">Total: <span class="fw-bold"><?php echo number_format($total, 2); ?> $</span></h4>
    <div class="d-flex justify-content-between mt-4">
      <a href="index.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Continue Shopping</a>
      <button class="btn btn-success"><i class="bi bi-credit-card"></i> Checkout</button>
    </div>

  <?php else: ?>
    <div class="alert alert-info">Your cart is empty.</div>
  <?php endif; ?>
</div>

</body>
</html>