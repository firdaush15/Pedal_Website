<?php
include("db.php");

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'] === 'Resolved' ? 'Resolved' : 'Unresolved';

    $query = "UPDATE contact_messages SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $status, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: admin_messages.php?msg=updated");
        exit();
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
