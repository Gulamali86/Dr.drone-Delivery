<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "p"; // Change if your DB name is different

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Validate tracking_id
if (isset($_GET['tracking_id']) && !empty($_GET['tracking_id'])) {
  $tracking_id = $conn->real_escape_string($_GET['tracking_id']);

  $sql = "SELECT * FROM orders WHERE tracking_id = '$tracking_id'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
  } else {
    echo "<script>alert('Tracking ID not found.'); window.location.href='track.html';</script>";
    exit();
  }
} else {
  echo "<script>alert('Please enter a tracking ID.'); window.location.href='track.html';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tracking Result</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f1f5f9;
      color: #0f172a;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .card {
      background-color: #ffffff;
      border-radius: 1rem;
      box-shadow: 0 10px 15px rgba(0,0,0,0.1);
      padding: 2rem;
      max-width: 500px;
      width: 100%;
      text-align: center;
    }

    h2 {
      font-size: 1.75rem;
      margin-bottom: 1rem;
    }

    p {
      font-size: 1rem;
      color: #475569;
      margin: 0.5rem 0;
    }

    .back {
      margin-top: 2rem;
    }

    .back a {
      color: #1e3a8a;
      text-decoration: none;
      font-weight: 600;
    }

    .progress-bar {
      background-color: #e2e8f0;
      border-radius: 1rem;
      height: 20px;
      overflow: hidden;
      margin: 1rem 0;
    }

    .progress {
      height: 100%;
      background-color: #3b82f6;
      transition: width 0.5s ease-in-out;
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>Tracking ID: <?= htmlspecialchars($order['tracking_id']) ?></h2>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    <p><strong>Estimated Delivery:</strong> <?= htmlspecialchars($order['estimated_time']) ?></p>
    <p><strong>Last Updated:</strong> <?= htmlspecialchars($order['last_updated']) ?></p>

    <?php
      // Progress map
      $progressMap = [
        "Processing" => 20,
        "Packed" => 40,
        "In Transit" => 70,
        "Out for Delivery" => 90,
        "Delivered" => 100
      ];
      $progress = $progressMap[$order['status']] ?? 10;
    ?>

    <p><strong>Progress:</strong></p>
    <div class="progress-bar">
      <div class="progress" style="width: <?= $progress ?>%;"></div>
    </div>
    <p><?= $progress ?>% Complete</p>

    <div class="back">
      <a href="track.html">🔙 Back to Tracking Page</a>
    </div>
  </div>
</body>
</html>
