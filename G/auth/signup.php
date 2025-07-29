<?php
include('../config/db.php');

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
$stmt->bind_param("ss", $email, $password);

if ($stmt->execute()) {
    echo "Signup successful. <a href='../login.html'>Login here</a>";
} else {
    echo "Signup failed: " . $conn->error;
}
?>