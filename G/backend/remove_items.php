<?php
session_start();
$session_id = $_SESSION['session_id'] ?? session_id();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['medicine_id'])) {
    $medicine_id = intval($_POST['medicine_id']);

    $conn = new mysqli("localhost", "root", "", "p");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->query("DELETE FROM cart WHERE session_id = '$session_id' AND medicine_id = $medicine_id");
    $conn->close();
}

header("Location: cart.php");
exit();
