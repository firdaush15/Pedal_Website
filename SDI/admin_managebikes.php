<?php
include("db.php");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle add new bike form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addBike'])) {
    $bikeName = $_POST['newBikeName'];
    $price = $_POST['newPrice'];
    $description = $_POST['newDescription'];
    
    // Handle Image Upload
    $targetDir = "uploads/";
    $fileName = basename($_FILES["newImage"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    move_uploaded_file($_FILES["newImage"]["tmp_name"], $targetFilePath);

    $stmt = $conn->prepare("INSERT INTO bicycles (bike_name, price_per_hour, description, image_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $bikeName, $price, $description, $targetFilePath);
    $stmt->execute();

    header("Location: admin_managebikes.php?add_success=1");
    exit;
}


// Handle bike deletion
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $query = "DELETE FROM bicycles WHERE bike_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: admin_managebikes.php?delete_success=1");
        exit;
    } else {
        header("Location: admin_managebikes.php?delete_error=1");
        exit;
    }
}

// Fetch all bikes
$query = "SELECT * FROM bicycles ORDER BY bike_id";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error fetching bikes: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Pedal Malaysia</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * { box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background-color: #f8f6f4; margin: 0; }
    .navbar {
      display: flex; justify-content: space-between; align-items: center;
      background-color: rgb(208, 98, 1); padding: 10px 20px;
    }
    .navbar .logo { display: flex; align-items: center; }
    .navbar .logo img { width: 40px; margin-right: 10px; }
    .navbar .nav-links a {
      margin-left: 20px; text-decoration: none; color: white; font-weight: 500;
    }
    .container { display: flex; }
    .sidebar {
      width: 200px; background-color: #f0f0f0; padding: 20px;
      height: calc(100vh - 61px);
    }
    .sidebar a {
      display: block; margin-bottom: 15px; text-decoration: none;
      color: rgb(125, 89, 5); font-weight: 500; padding: 10px;
      background-color: white; border-radius: 8px; text-align: center;
    }
    .sidebar a:hover { background-color: #ddd; }
    .main-content { flex: 1; padding: 30px; }
    .bike-table-container {
      max-width: 1000px; margin: auto; padding: 20px;
    }
    .bike-table {
      width: 100%; border-collapse: collapse;
      background: white; border-radius: 12px; overflow: hidden;
    }
    .bike-table th {
      background-color: #f57c00; color: white;
      padding: 12px; text-align: left;
    }
    .bike-table td { padding: 12px; border-bottom: 1px solid #ddd; }
    .bike-table tr:hover { background-color: #f5f5f5; }
    .bike-table img { width: 80px; border-radius: 5px; }
    .action-btn {
      padding: 6px 10px; border: none; border-radius: 5px;
      color: white; cursor: pointer; text-decoration: none;
      margin-right: 5px; display: inline-block;
    }
    .edit-btn {
  background-color: #4CAF50; /* Green */
  padding: 6px 10px;
  border: none;
  border-radius: 5px;
  color: white;
  cursor: pointer;
  text-decoration: none;
  display: inline-block;
  margin-right: 5px;
}

    .delete-btn { background-color: #f44336; }
    .add-btn {
      background-color: #2196F3; padding: 10px 15px;
      display: inline-block;
    }
    .modal {
      display: none; position: fixed; z-index: 1;
      left: 0; top: 0; width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
      background: white; padding: 20px; border-radius: 8px;
      width: 50%; margin: 10% auto;
    }
    .close, .close-add {
      float: right; font-size: 28px; font-weight: bold;
      cursor: pointer;
    }
    input[type="text"], textarea {
      width: 100%; padding: 8px; margin-bottom: 10px;
      border: 1px solid #ccc; border-radius: 4px;
    }
    button[type="submit"] {
      background-color: #4CAF50; color: white;
      padding: 10px 15px; border: none;
      border-radius: 5px; cursor: pointer;
    }
    .status-available {
  color: green;
  font-weight: bold;
}
.status-unavailable {
  color: red;
  font-weight: bold;
}

  </style>
</head>
<body>
  <div class="navbar">
    <div class="logo">
      <img src="pedal (2).png" alt="Logo">
      <h3><strong>Pedal Malaysia</strong></h3>
    </div>
    <div class="nav-links">
      
      <a href="login.php">Logout</a>
    </div>
  </div>
  <div class="container">
    <div class="sidebar">
      <h3>Admin Panel</h3>
       <a href="admin_manage_user.php">Manage Users</a>
      <a href="admin_managebikes.php">Manage Bikes</a>
      <a href="admin_manageuser.php">Manage Booking</a>
          <a href="admin_messages.php">User Messages</a> <!-- New link added -->
    </div>
    <div class="main-content">
      <h2>Available Bikes</h2>
      <div class="bike-table-container">
        <table class="bike-table">
          <thead>
            <tr>
              <th>Image</th>
              <th>Bike Name</th>
              <th>Price/Hour (RM)</th>
              <th>Description</th>
               <th>Status</th> 
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Bike Image"></td>
              <td><?php echo htmlspecialchars($row['bike_name']); ?></td>
              <td>RM <?php echo number_format($row['price_per_hour'], 2); ?></td>
              <td><?php echo htmlspecialchars($row['description']); ?></td>
              <td>
<td>
  <span class="<?php echo $row['status'] == 'Available' ? 'status-available' : 'status-unavailable'; ?>">
    <?php echo $row['status']; ?>
  </span>
</td>
<td>
  <button class="action-btn edit-btn" 
    data-bike-id="<?php echo $row['bike_id']; ?>" 
    data-bike-name="<?php echo htmlspecialchars($row['bike_name']); ?>" 
    data-price="<?php echo $row['price_per_hour']; ?>" 
    data-description="<?php echo htmlspecialchars($row['description']); ?>"
    data-status="<?php echo $row['status']; ?>">
  <i class="fas fa-pencil-alt"></i> Edit
</button>

                <a href="admin_managebikes.php?id=<?php echo $row['bike_id']; ?>&action=delete"
                   class="action-btn delete-btn"
                   onclick="return confirm('Are you sure you want to delete this bike?')">
                  <i class="fas fa-trash"></i> Delete
                </a>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <div style="margin-top: 20px;">
        <a href="javascript:void(0);" class="action-btn add-btn"><i class="fas fa-plus"></i> Add New Bike</a>
      </div>
    </div>
  </div>


  <!-- Edit Modal -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Edit Bike Information</h2>
<form id="editForm" method="POST" action="edit_bikes.php" enctype="multipart/form-data">
    <input type="hidden" id="bikeId" name="bikeId">
    
    <label for="bikeName">Bike Name:</label>
    <input type="text" id="bikeName" name="bikeName" required>
    
    <label for="price">Price/Hour (RM):</label>
    <input type="text" id="price" name="price" required>
    
    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>
    
    <label for="bikeImage">Upload New Image:</label>
    <input type="file" id="bikeImage" name="bikeImage" accept="image/*">

    <label for="status">Status:</label>
<select id="status" name="status" required>
  <option value="Available">Available</option>
  <option value="Unavailable">Unavailable</option>
</select>

    
    <button type="submit">Save Changes</button>
</form>
    </div>
  </div>

  

  <!-- Add Modal -->
  <div id="addModal" class="modal">
    <div class="modal-content">
      <span class="close-add">&times;</span>
      <h2>Add New Bike</h2>
<form method="POST" action="admin_managebikes.php" enctype="multipart/form-data">
    <input type="hidden" name="addBike" value="1">
    <label for="newBikeName">Bike Name:</label>
    <input type="text" id="newBikeName" name="newBikeName" required>
    
    <label for="newPrice">Price/Hour (RM):</label>
    <input type="text" id="newPrice" name="newPrice" required>
    
    <label for="newDescription">Description:</label>
    <textarea id="newDescription" name="newDescription" required></textarea>
    
    <label for="newImage">Upload Image:</label>
    <input type="file" id="newImage" name="newImage" accept="image/*" required>
    
    <button type="submit">Add Bike</button>
</form>

    </div>
  </div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Existing edit modal logic
    const editButtons = document.querySelectorAll(".edit-btn");
    const editModal = document.getElementById("editModal");
    const closeEditBtn = document.querySelector(".close");

    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            document.getElementById("bikeId").value = this.getAttribute("data-bike-id");
            document.getElementById("bikeName").value = this.getAttribute("data-bike-name");
            document.getElementById("price").value = this.getAttribute("data-price");
            document.getElementById("description").value = this.getAttribute("data-description");
            document.getElementById("status").value = this.getAttribute("data-status");


            editModal.style.display = "block";
        });
    });

    closeEditBtn.onclick = () => editModal.style.display = "none";
    window.onclick = event => {
        if (event.target === editModal) editModal.style.display = "none";
    };

    // ✅ New: Add modal logic
    const addButton = document.querySelector(".add-btn");
    const addModal = document.getElementById("addModal");
    const closeAddBtn = document.querySelector(".close-add");

    addButton.addEventListener("click", function () {
        addModal.style.display = "block";
    });

    closeAddBtn.onclick = () => addModal.style.display = "none";
    window.onclick = event => {
        if (event.target === addModal) addModal.style.display = "none";
    };
});
</script>

</body>
</html>