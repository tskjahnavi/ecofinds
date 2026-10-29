<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>EcoFinds - Home</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f4f4f9; }
    header { background: #2e7d32; color: white; padding: 15px; border-radius: 8px; }
    nav a { color: white; margin-right: 15px; text-decoration: none; }
    .container { text-align: center; margin-top: 50px; }
    .btn {
      background: #2e7d32;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      cursor: pointer;
      text-decoration: none;
    }
    .btn:hover { background: #1b5e20; }
  </style>
</head>
<body>

<header>
  <h1>🌍 EcoFinds</h1>
  <nav>
    <?php if (isset($_SESSION['user_id'])) { ?>
      Welcome <?php echo $_SESSION['username']; ?> <br><br><br>
      <a href="dashboard.php">Dashboard</a>
      <a href="my_listings.php">My Listings</a>
      <a href="add_product.php">Add Product</a>
      <a href="products.php">View Products</a>
      <a href="cart.php">Cart</a>
      <a href="orders.php">Orders</a>
      <a href="logout.php">Logout</a>
    <?php } else { ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    <?php } ?>
  </nav>
</header>

<div class="container">
  <h2>Welcome to EcoFinds 🌱</h2>
  <p>A sustainable way to buy and sell second-hand products.</p>
  <a href="products.php" class="btn">Browse Products</a>
</div>

</body>
</html>
