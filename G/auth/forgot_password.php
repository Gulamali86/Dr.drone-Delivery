<?php
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Reset link sent to your email (simulation)'); window.location.href = '../logo.html';</script>";
        // In real life: Send email with secure reset token
    } else {
        echo "<script>alert('Email not found'); window.history.back();</script>";
}
}
?>