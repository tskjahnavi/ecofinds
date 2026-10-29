<?php
session_start();
include "db.php";
$uid = $_SESSION['user_id'];

$res = $conn->query("SELECT c.product_id,p.price,c.quantity FROM cart c 
                     JOIN products p ON c.product_id=p.id 
                     WHERE c.user_id=$uid");

$total = 0; $items = [];
while ($row = $res->fetch_assoc()) {
    $items[] = $row;
    $total += $row['price'] * $row['quantity'];
}

$conn->query("INSERT INTO orders (user_id,total) VALUES ($uid,$total)");
$orderId = $conn->insert_id;

foreach ($items as $i) {
    $pid = $i['product_id']; $q = $i['quantity']; $price = $i['price'];
    $conn->query("INSERT INTO order_items (order_id,product_id,quantity,price)
                  VALUES ($orderId,$pid,$q,$price)");
}

$conn->query("DELETE FROM cart WHERE user_id=$uid");

echo "Order placed! <a href='orders.php'>View Orders</a>";
?>
