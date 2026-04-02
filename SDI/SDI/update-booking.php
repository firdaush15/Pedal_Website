<?php
include 'db.php';

$rental_id = $_POST['rental_id'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$total_price = $_POST['total_price'];

$sql = "UPDATE Rentals SET start_time = ?, end_time = ?, total_price = ? WHERE rental_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdi", $start_time, $end_time, $total_price, $rental_id);

if ($stmt->execute()) {
    echo "updated";
} else {
    echo "failed";
}
?>
