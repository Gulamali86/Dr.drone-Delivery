<?php
// Database connection
$host = "localhost";
$dbname = "p";  // ✅ Change this
$username = "root";              // Default for XAMPP
$password = "";                  // Default is blank

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Collect form data
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO contact_messages (first_name, last_name, email, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$firstName, $lastName, $email, $message]);

    echo "<script>alert('Message sent successfully!'); window.location.href='index.html';</script>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
