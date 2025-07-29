<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.html");
    exit;
}
?>

<h2>Welcome, Admin (<?php echo $_SESSION["email"]; ?>)</h2>
<a href="../auth/logout.php">Logout</a>