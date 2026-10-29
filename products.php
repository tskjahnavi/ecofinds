<?php
session_start();
include "db.php";

$q = isset($_GET['q']) ? $_GET['q'] : '';
$cat = isset($_GET['cat']) ? $_GET['cat'] : '';

$sql = "SELECT * FROM products WHERE 1";
if ($q) $sql .= " AND title LIKE '%$q%'";
if ($cat) $sql .= " AND category='$cat'";
$result = $conn->query($sql);

// Handle product deletion (only owner can delete)
if (isset($_GET['delete']) && isset($_SESSION['user_id'])) {
    $pid = intval($_GET['delete']);
    $uid = $_SESSION['user_id'];
    $conn->query("DELETE FROM products WHERE id=$pid AND user_id=$uid");
    header("Location: products.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>EcoFinds - Products</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    header { background: #2e7d32; color: white; padding: 15px; border-radius: 8px; }
    nav a { color: white; margin-right: 15px; text-decoration: none; }
    .product {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 10px;
      margin: 10px 0;
      background: #f9f9f9;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .product img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      margin-right: 15px;
    }
    .info { flex: 1; }
    .title { font-size: 18px; margin: 0; }
    .price { color: green; font-weight: bold; }
    .actions a {
      margin-left: 10px;
      text-decoration: none;
      font-weight: bold;
    }
    .remove { color: red; }
  </style>
</head>
<body>

<header>
  <h2>🛍️ EcoFinds Products</h2>
  <nav>
    <a href="index.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="my_listings.php">My Listings</a>
    <a href="add_product.php">Add Product</a>
    <a href="cart.php">Cart</a>
    <a href="orders.php">Orders</a>
    <a href="logout.php">Logout</a>
  </nav>
</header>

<h3>Browse Products</h3>
<form method="get">
  Search: <input type="text" name="q" value="<?php echo $q; ?>">
  Category: <input type="text" name="cat" value="<?php echo $cat; ?>">
  <button type="submit">Filter</button>
</form>

<?php
if ($result->num_rows == 0) {
    echo "<p>No products found.</p>";
}
while ($row = $result->fetch_assoc()) {
?>
  <div class="product">
    <img src="<?php echo $row['image_url']; ?>" alt="product">
    <div class="info">
      <p class="title"><a href="product.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></p>
      <p class="price">₹<?php echo $row['price']; ?></p>
    </div>
    <div class="actions">
      <a href="cart.php?add=<?php echo $row['id']; ?>">Add to Cart</a>
      <?php 
      if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row['user_id']) { 
      ?>
        <a href="products.php?delete=<?php echo $row['id']; ?>" 
           class="remove" 
           onclick="return confirm('Are you sure you want to delete this product?');">❌ Remove</a>
      <?php } ?>
    </div>
  </div>
<?php } ?>

</body>
</html>
