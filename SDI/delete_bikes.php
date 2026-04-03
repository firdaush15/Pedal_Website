<?php
include("db.php");

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Only process if ID is provided
if(isset($_GET['id'])) {
    // Sanitize the input
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // First check if bike exists and get image path
    $check_query = "SELECT image_url FROM bicycles WHERE bike_id = '$id'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (!$check_result) {
        die("Query failed: " . mysqli_error($conn));
    }
    
    if (mysqli_num_rows($check_result) > 0) {
        $row = mysqli_fetch_assoc($check_result);
        $image_path = $row['image_url'];
        
        // Delete the bike record
        $delete_query = "DELETE FROM bicycles WHERE bike_id = '$id'";
        $delete_result = mysqli_query($conn, $delete_query);

        if ($delete_result) {
            // Delete the associated image file if it exists
            if (!empty($image_path) && file_exists($image_path)) {
                unlink($image_path);
            }
            
            // Redirect with success message
            header("Location: admin_managebikes.php?delete_success=1");
            exit();
        } else {
            die("Error deleting bike: " . mysqli_error($conn));
        }
    } else {
        // If bike not found, redirect with error message
        header("Location: admin_managebikes.php?delete_error=1");
        exit();
    }
} else {
    // If no ID provided, redirect with error
    header("Location: admin_managebikes.php?delete_error=2");
    exit();
}
?>