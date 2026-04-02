<?php
include("db.php");

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM rentals WHERE rental_id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Rental deleted successfully.";
        // Redirect to the display page after deletion
        header("Location: admin_manageuser.php");
        exit;
    } else {
        echo "Error deleting rental: " . mysqli_error($conn);
    }
} else {
    echo "Invalid rental ID.";
}
?>

