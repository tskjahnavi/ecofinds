<?php
include "db.php";
$id = $_GET['id'];
$res = $conn->query("SELECT * FROM products WHERE id=$id");
$row = $res->fetch_assoc();
?>
<h2><?php echo $row['title']; ?></h2>
<img src="<?php echo $row['image_url']; ?>" width="150"><br>
Category: <?php echo $row['category']; ?><br>
Price: ₹<?php echo $row['price']; ?><br>
<p><?php echo $row['description']; ?></p>
<a href="cart.php?add=<?php echo $row['id']; ?>">Add to Cart</a>
<br><a href="index.php">Back</a>
