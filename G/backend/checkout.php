<?php
session_start();
$session_id = $_SESSION['session_id'] ?? session_id();

$conn = new mysqli("localhost", "root", "", "p");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$address = $_POST['address'];
$payment_method = $_POST['payment_method'];

// Generate unique tracking ID
$tracking_id = "DRONE" . strtoupper(bin2hex(random_bytes(4)));

// Insert into orders table
$conn->query("INSERT INTO orders (session_id, fullname, email, address, payment_method, tracking_id, status)
              VALUES ('$session_id', '$fullname', '$email', '$address', '$payment_method', '$tracking_id', 'Processing')");

// Get order ID
$order_id = $conn->insert_id;

// Move items from cart to order_items
$cart_items = $conn->query("SELECT * FROM cart WHERE session_id = '$session_id'");
while ($item = $cart_items->fetch_assoc()) {
    $conn->query("INSERT INTO order_items (order_id, medicine_id, quantity)
                  VALUES ($order_id, {$item['medicine_id']}, {$item['quantity']})");
}

// Clear cart
$conn->query("DELETE FROM cart WHERE session_id = '$session_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Confirmation</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f1f5f9;
      color: #0f172a;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .confirmation-box {
      background: #ffffff;
      padding: 2rem 2.5rem;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 500px;
    }

    h2 {
      color: #0f172a;
      margin-bottom: 1rem;
    }

    p {
      font-size: 1.05rem;
      margin: 0.5rem 0;
      color: #334155;
    }

    strong {
      color: #1e293b;
    }

    a {
      display: inline-block;
      margin-top: 1.5rem;
      padding: 10px 20px;
      background-color: #0f172a;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }

    a:hover {
      background-color: #1e293b;
    }
  </style>
</head>
<body>
  <div class="confirmation-box">
    <h2>Thank you for your order, <?= htmlspecialchars($fullname) ?>!</h2>
    <p>Your drone tracking ID: <strong><?= htmlspecialchars($tracking_id) ?></strong></p>
    <p>You will receive updates via email at <strong><?= htmlspecialchars($email) ?></strong></p>
    <a href="../track.html">🚀 Track Your Order</a>
  </div>
</body>
</html>

<?php
$conn->close();
?>
