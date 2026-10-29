<?php
session_start();
include "db.php";
if (!isset($_SESSION['user_id'])) header("Location: login.php");

$uid = $_SESSION['user_id'];

// Add item to cart
if (isset($_GET['add'])) {
    $pid = $_GET['add'];
    $conn->query("INSERT INTO cart (user_id, product_id, quantity) VALUES ($uid, $pid, 1)");
    header("Location: cart.php");
    exit();
}

// Remove item from cart
if (isset($_GET['remove'])) {
    $cid = $_GET['remove'];
    $conn->query("DELETE FROM cart WHERE id=$cid AND user_id=$uid");
    header("Location: cart.php");
    exit();
}

// Fetch cart items
$res = $conn->query("SELECT c.id AS cart_id, p.title, p.price, c.quantity 
                     FROM cart c 
                     JOIN products p ON c.product_id=p.id 
                     WHERE c.user_id=$uid");

$total = 0;
echo "<h2>My Cart</h2>";

if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        echo $row['title']." - ₹".$row['price']." x ".$row['quantity']." 
              <a href='cart.php?remove=".$row['cart_id']."'>Remove</a><br>";
        $total += $row['price'] * $row['quantity'];
    }
    echo "<strong>Total: ₹$total</strong><br>";
    echo "<a href='checkout.php'>Checkout</a>";
} else {
    echo "<p>Cart is empty!</p>";
}
?>
<a href="index.php"><br>Back to Marketplace</a>
