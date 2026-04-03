<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rental_id = $_POST["rental_id"];
    $status = $_POST["status"];

    $stmt = $conn->prepare("UPDATE rentals SET status = ? WHERE rental_id = ?");
    $stmt->bind_param("si", $status, $rental_id);

    if ($stmt->execute()) {
        header("Location: admin_manageuser.php?success=1");
        exit();
    } else {
        echo "Error updating status: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
