<?php
include 'mysql_connect.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id']) && isset($_POST['current_role'])) {
    $user_id = intval($_POST['user_id']);
    $current_role = $_POST['current_role'];
    $new_role = ($current_role === 'admin') ? 'user' : 'admin';

    // Prevent self demotion
    if ($_SESSION['user_id'] == $user_id) {
        echo "<script>alert('You cannot change your own role.'); window.location.href='admin_manage_users.php';</script>";
        exit;
    }

    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE user_id = ?");
    $stmt->bind_param("si", $new_role, $user_id);
    if ($stmt->execute()) {
        echo "<script>alert('User role updated.'); window.location.href='admin_manage_users.php';</script>";
    } else {
        echo "<script>alert('Failed to update role.'); window.location.href='admin_manage_users.php';</script>";
    }
    $stmt->close();
    $conn->close();
}
?>
