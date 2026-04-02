<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bikeId = $_POST["bikeId"];
    $bikeName = htmlspecialchars(strip_tags($_POST["bikeName"]));
    $price = $_POST["price"];
    $description = htmlspecialchars(strip_tags($_POST["description"]));

    // Validate price
    if (!is_numeric($price)) {
        echo "<script>alert('❌ Price must be a number!'); window.location.href='admin_managebikes.php';</script>";
        exit();
    }

    // Check if bike exists
    $checkQuery = "SELECT bike_id FROM bicycles WHERE bike_id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("i", $bikeId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    if ($checkResult->num_rows === 0) {
        echo "<script>alert('❌ Bike ID not found!'); window.location.href='admin_managebikes.php';</script>";
        exit();
    }

   $status = $_POST["status"]; // ✅ NEW: capture status

if (!empty($_FILES["bikeImage"]["name"])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["bikeImage"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if (!move_uploaded_file($_FILES["bikeImage"]["tmp_name"], $targetFilePath)) {
        echo "<script>alert('❌ Image upload failed!'); window.location.href='admin_managebikes.php';</script>";
        exit();
    }

    $query = "UPDATE bicycles SET bike_name = ?, price_per_hour = ?, description = ?, image_url = ?, status = ? WHERE bike_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $bikeName, $price, $description, $targetFilePath, $status, $bikeId);
} else {
    $query = "UPDATE bicycles SET bike_name = ?, price_per_hour = ?, description = ?, status = ? WHERE bike_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $bikeName, $price, $description, $status, $bikeId);
}

    if ($stmt->execute()) {
        echo "<script>alert('✅ Bike updated successfully!'); window.location.href='admin_managebikes.php';</script>";
    } else {
        echo "<script>alert('❌ Error updating bike: " . $conn->error . "'); window.location.href='admin_managebikes.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>