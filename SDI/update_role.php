<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $new_role, $user_id);

    if ($stmt->execute()) {
        header("Location: admin_manageuser.php?message=Role updated");
    } else {
        echo "Error updating role: " . $stmt->error;
    }

    $stmt->close();
}
?>
