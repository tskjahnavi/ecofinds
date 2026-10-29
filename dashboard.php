<?php
session_start();
include "db.php";
if (!isset($_SESSION['user_id'])) header("Location: login.php");

$uid = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $sql = "UPDATE users SET username='$username' WHERE id=$uid";
    $conn->query($sql);
    $_SESSION['username'] = $username;
    echo "Profile updated!";
}
?>
<h2>User Dashboard</h2>
<form method="post">
  Username: <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>"><br>
  <button type="submit">Update</button>
</form>
<a href="index.php">Home</a> | 
<a href="logout.php">Logout</a>
