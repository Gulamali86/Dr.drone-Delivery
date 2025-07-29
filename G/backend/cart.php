<?php
session_start();
$session_id = $_SESSION['session_id'] ?? session_id();

$conn = new mysqli("localhost", "root", "", "p");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT c.medicine_id, c.quantity, m.name, m.price, m.image 
        FROM cart c 
        JOIN medicines m ON c.medicine_id = m.id 
        WHERE c.session_id = '$session_id'";
$result = $conn->query($sql);

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f1f5f9;
      color: #0f172a;
      padding: 2rem;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: white;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 12px 16px;
      text-align: center;
      border-bottom: 1px solid #e2e8f0;
    }

    th {
      background-color: #0f172a;
      color: white;
    }

    td img {
      border-radius: 8px;
    }

    .total-row td {
      font-weight: bold;
      background-color: #f8fafc;
    }

    .empty {
      text-align: center;
      font-size: 1.2rem;
      margin-top: 2rem;
    }

    a.button {
      display: inline-block;
      margin-top: 1rem;
      padding: 10px 20px;
      background-color: #0f172a;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }

    a.button:hover {
      background-color: #1e293b;
    }

    .remove-btn {
      background-color: #e11d48;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
    }

    .remove-btn:hover {
      background-color: #be123c;
    }
  </style>
</head>
<body>

<h2>Your Cart</h2>

<?php
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Medicine</th><th>Qty</th><th>Price</th><th>Subtotal</th><th>Remove</th></tr>";
    while($row = $result->fetch_assoc()) {
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['quantity']}</td>
                <td>&#8377;{$row['price']}</td>
                <td>&#8377;$subtotal</td>
                <td>
                  <form action='remove_items.php' method='POST' onsubmit='return confirm(\"Remove this item?\");'>
                    <input type='hidden' name='medicine_id' value='{$row['medicine_id']}'>
                    <button type='submit' class='remove-btn'>Remove</button>
                  </form>
                </td>
              </tr>";
    }
    echo "<tr class='total-row'><td colspan='3'>Total</td><td colspan='2'>&#8377;$total</td></tr>";
    echo "</table>";
    echo "<div style='text-align:center;'>
            <a class='button' href='../payment.html'>Proceed to Payment</a>
            <a class='button' href='../medi.html'>Back to Store</a>
          </div>";
} else {
    echo "<p class='empty'>🛒 Your cart is empty.</p>";
}

$conn->close();
?>

</body>
</html>
