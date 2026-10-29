<?php
session_start();
include "db.php";
if (!isset($_SESSION['user_id'])) header("Location: login.php");

$uid = $_SESSION['user_id'];
$res = $conn->query("SELECT * FROM orders WHERE user_id=$uid ORDER BY created_at DESC");

echo "<h2>My Orders</h2>";
while ($o = $res->fetch_assoc()) {
    echo "Order #".$o['id']." | Total: ₹".$o['total']." | ".$o['created_at']."<br>";
}
?>
<a href="index.php">Back to Home</a>
