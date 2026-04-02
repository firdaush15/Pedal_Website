<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bikeName = $_POST['bikeName'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $query = "INSERT INTO bicycles (bike_name, price_per_hour, description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sds", $bikeName, $price, $description);

    if ($stmt->execute()) {
        header("Location: admin_managebikes.php?add_success=1");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add New Bike</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 40px; }
    .form-container {
      background: white; padding: 30px; border-radius: 10px;
      max-width: 500px; margin: auto; box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 { text-align: center; color: #333; }
    label { display: block; margin-top: 10px; }
    input[type="text"], textarea {
      width: 100%; padding: 10px; margin-top: 5px;
      border: 1px solid #ccc; border-radius: 5px;
    }
    button {
      margin-top: 20px; background-color: #4CAF50; color: white;
      border: none; padding: 10px 20px;
      border-radius: 5px; cursor: pointer;
    }
    a.back-link {
      display: block; margin-top: 20px; text-align: center;
      text-decoration: none; color: #4CAF50;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Add New Bike</h2>
    <form method="POST" action="">
      <label for="bikeName">Bike Name:</label>
      <input type="text" name="bikeName" required>

      <label for="price">Price Per Hour (RM):</label>
      <input type="text" name="price" required>

      <label for="description">Description:</label>
      <textarea name="description" rows="4" required></textarea>

      <button type="submit">Add Bike</button>
    </form>
    <a href="admin_managebikes.php" class="back-link">← Back to Bike List</a>
  </div>
</body>
</html>
