<?php
require '../config/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["email"] = $user["email"];
        

        if ($user["role"] === "admin") {
            echo "<script>alert('Welcome Admin!'); window.location.href = '../admin/dashboard.php';</script>";
        } else {
            echo "<script>alert('Login successful!'); window.location.href = '../dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password'); window.history.back();</script>";
}
}
?>
