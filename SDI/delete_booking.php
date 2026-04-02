<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rental_id'])) {
    $rental_id = intval($_POST['rental_id']);

    // Optional: Verify that the rental belongs to this user for security
    $checkQuery = "SELECT * FROM rentals WHERE rental_id = ? AND user_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $rental_id, $user_id);
    $stmt->execute();
    $checkResult = $stmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Delete the rental
        $deleteQuery = "DELETE FROM rentals WHERE rental_id = ? AND user_id = ?";
        $delStmt = $conn->prepare($deleteQuery);
        $delStmt->bind_param("ii", $rental_id, $user_id);
        if ($delStmt->execute()) {
            $_SESSION['message'] = "Booking cancelled successfully.";
        } else {
            $_SESSION['message'] = "Failed to cancel booking. Please try again.";
        }
    } else {
        $_SESSION['message'] = "Booking not found or you don't have permission.";
    }
} else {
    $_SESSION['message'] = "Invalid request.";
}

header("Location: order-history.php");
exit();
