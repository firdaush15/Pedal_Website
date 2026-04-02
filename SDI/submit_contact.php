<?php
require 'mysql_connect.php'; // Make sure this connects to your DB

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $message);
$stmt->execute();

echo "Message sent successfully!";
?>
