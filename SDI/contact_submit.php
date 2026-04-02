<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db.php'; // $conn

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $inquiry_type = $_POST['inquiry_type'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    $filename = null;

    if (!empty($_FILES['attachment']['name'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $filename = uniqid() . '_' . basename($_FILES['attachment']['name']);
        $targetFile = $uploadDir . $filename;

        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileType, $allowedTypes)) {
            header("Location: contact.php?error=Invalid file type.");
            exit();
        }

        if (!move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
            header("Location: contact.php?error=Failed to upload file.");
            exit();
        }
    }

    $stmt = $conn->prepare("INSERT INTO contact_messages (fullname, email, phone, inquiry_type, subject, message, attachment) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $fullname, $email, $phone, $inquiry_type, $subject, $message, $filename);

    if ($stmt->execute()) {
        header("Location: contact.php?success=Your message has been sent successfully!");
    } else {
        header("Location: contact.php?error=Failed to send message.");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: contact.php?error=Invalid request.");
    exit();
}
