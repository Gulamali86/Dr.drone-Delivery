<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "p"; 

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// ✅ Check if tracking_id is set via POST
if (isset($_POST['tracking_id']) && !empty($_POST['tracking_id'])) {
  $tracking_id = $conn->real_escape_string($_POST['tracking_id']);

  $sql = "SELECT tracking_id, status FROM orders WHERE tracking_id = '$tracking_id'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <title>Tracking Result</title>
      <style>
        body {
          font-family: Arial, sans-serif;
          background-color: #f1f5f9;
          text-align: center;
          padding: 2rem;
        }
        .card {
          background: white;
          padding: 2rem;
          max-width: 500px;
          margin: auto;
          border-radius: 10px;
          box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
          color: #1e293b;
        }
        p {
          font-size: 1.1rem;
          color: #334155;
        }
        a {
          display: inline-block;
          margin-top: 1rem;
          text-decoration: none;
          background-color: #0f172a;
          color: white;
          padding: 0.5rem 1rem;
          border-radius: 5px;
        }
        a:hover {
          background-color: #1e293b;
        }
      </style>
    </head>
    <body>
      <div class="card">
        <h2>Tracking ID: <?= htmlspecialchars($order['tracking_id']) ?></h2>
        <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
        <a href="../track.html">🔙 Back to Tracking Page</a>
      </div>
    </body>
    </html>
    <?php
  } else {
    // Tracking ID not found
    echo "<script>alert('Tracking ID not found.'); window.location.href='../track.html';</script>";
  }
} else {
  // Tracking ID not provided
  echo "<script>alert('No tracking ID provided.'); window.location.href='../track.html';</script>";
  exit();
}

$conn->close();
?>
