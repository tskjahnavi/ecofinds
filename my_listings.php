<?php
session_start();
include "db.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];

// Handle product deletion
if (isset($_GET['delete'])) {
    $pid = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id=$pid AND user_id=$uid");
    header("Location: my_listings.php");
    exit();
}

// Fetch user’s products
$sql = "SELECT * FROM products WHERE user_id=$uid";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Listings - EcoFinds</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    header { background: #2e7d32; color: white; padding: 15px; border-radius: 8px; }
    nav a { color: white; margin-right: 15px; text-decoration: none; }
    .product {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 10px;
      margin: 10px 0;
      display: flex;
      align-items: center;
      background: #f9f9f9;
    }
    .product img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      margin-right: 15px;
    }
    .product-title { font-size: 18px; margin: 0; }
    .price { color: green; font-weight: bold; }
    .actions a {
      margin-left: 10px;
      color: red;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>

<header>
  <h2>📦 My Listings</h2>
  <nav>
    <a href="index.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="add_product.php">+ Add Product</a>
    <a href="cart.php">Cart</a>
    <a href="orders.php">Orders</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<h3>Your Products</h3>

<?php
if ($result->num_rows == 0) {
    echo "<p>You haven't added any products yet.</p>";
}
while ($row = $result->fetch_assoc()) {
?>
  <div class="product">
    <img src="<?php echo $row['image_url']; ?>" alt="product">
    <div>
      <p class="product-title"><?php echo $row['title']; ?></p>
      <p class="price">₹<?php echo $row['price']; ?></p>
      <a href="my_listings.php?delete=<?php echo $row['id']; ?>" 
         onclick="return confirm('Are you sure you want to delete this product?');">
         ❌ Remove
      </a>
    </div>
  </div>
<?php } ?>

</body>
</html>
