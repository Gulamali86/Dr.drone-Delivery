<!-- User dashboard -->

<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome Page</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f1f5f9;
      color: #0f172a;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .welcome-box {
      background-color: #ffffff;
      padding: 2rem 3rem;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h2 {
      margin-bottom: 1.5rem;
    }

    .btn-group {
      margin-top: 1.5rem;
      display: flex;
      gap: 1rem;
      justify-content: center;
    }

    .btn {
      text-decoration: none;
      padding: 10px 20px;
      background-color: #0f172a;
      color: white;
      border-radius: 6px;
      font-weight: 600;
      transition: background-color 0.2s ease-in-out;
    }

    .btn:hover {
      background-color: #1e293b;
    }
  </style>
</head>
<body>
  <div class="welcome-box">
    <h2>Welcome, <?= htmlspecialchars($_SESSION["email"]) ?>!</h2>
    <div class="btn-group">
      <a class="btn" href="auth/logout.php">Logout</a>
      <a class="btn" href="index.html">Home</a>
    </div>
  </div>
</body>
</html>