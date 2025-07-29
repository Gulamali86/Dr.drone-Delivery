<?php
session_start();

// Create a unique session ID
if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = session_id();
}

$session_id = $_SESSION['session_id'];

// Connect to DB
$conn = new mysqli("localhost", "root", "", "p");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get values
$medicine_id = intval($_POST['medicine_id']);
$quantity = intval($_POST['quantity']);

// Check if already in cart
$sql = "SELECT * FROM cart WHERE medicine_id = $medicine_id AND session_id = '$session_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Update quantity
    $conn->query("UPDATE cart SET quantity = quantity + $quantity WHERE medicine_id = $medicine_id AND session_id = '$session_id'");
} else {
    // Insert new
    $conn->query("INSERT INTO cart (medicine_id, quantity, session_id) VALUES ($medicine_id, $quantity, '$session_id')");
}

$conn->close();
header("Location: ../backend/cart.php"); // Redirect to cart
exit();
?>
