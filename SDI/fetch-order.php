<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT Rentals.*, Bicycles.model FROM Rentals 
        JOIN Bicycles ON Rentals.bike_id = Bicycles.bike_id 
        WHERE Rentals.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$orders = [];

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
?>
