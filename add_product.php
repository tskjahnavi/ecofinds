<?php
session_start();
include "db.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $cat = $_POST['category'];
    $img = $_POST['image_url'];

    $uid = $_SESSION['user_id'];
    $sql = "INSERT INTO products (title, price, category, image_url, user_id) 
            VALUES ('$title', '$price', '$cat', '$img', '$uid')";
    if ($conn->query($sql)) {
        $msg = "✅ Product added successfully!";
    } else {
        $msg = "❌ Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Product - EcoFinds</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    header { background: #2e7d32; color: white; padding: 15px; border-radius: 8px; }
    nav a { color: white; margin-right: 15px; text-decoration: none; }
    form {
      background: #f9f9f9;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      max-width: 400px;
    }
    input, button {
      display: block;
      width: 100%;
      margin-bottom: 10px;
      padding: 8px;
    }
    button { background: #2e7d32; color: white; border: none; cursor: pointer; }
    button:hover { background: #1b5e20; }
    .msg { margin-bottom: 15px; color: blue; font-weight: bold; }
  </style>
</head>
<body>

<header>
  <h2>➕ Add Product</h2>
  <nav>
    <a href="index.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="my_listings.php">My Listings</a>
    <a href="cart.php">Cart</a>
    <a href="orders.php">Orders</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<?php if ($msg) echo "<p class='msg'>$msg</p>"; ?>

<form method="post">
  <label>Product Title:</label>
  <input type="text" name="title" required>

  <label>Price (₹):</label>
  <input type="number" step="0.01" name="price" required>

  <label>Category:</label>
  <input type="text" name="category" placeholder="e.g. Electronics, Books">

  <label>Image URL:</label>
  <input type="text" name="image_url" placeholder="http://example.com/image.jpg">

  <button type="submit">Add Product</button>
</form>

</body>
</html>
