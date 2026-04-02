<?php
include("db.php");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$search = isset($_GET["search"]) ? $_GET["search"] : "";
$query = "SELECT r.rental_id, r.user_id, r.bike_id, r.booking_date, r.rental_hours, r.total_price, r.status,
                 c.full_name, c.email, c.phone_number, c.nric, c.username
          FROM rentals r
          JOIN customers c ON r.user_id = c.user_id";

if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $query .= " WHERE c.full_name LIKE '%$search%' 
                OR c.username LIKE '%$search%' 
                OR c.email LIKE '%$search%' 
                OR r.rental_id LIKE '%$search%'";
}

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard | Pedal Malaysia</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f6f4;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: rgb(208, 98, 1);
      padding: 10px 20px;
    }

    .navbar .logo {
      display: flex;
      align-items: center;
    }

    .navbar .logo img {
      width: 40px;
      margin-right: 10px;
    }

    .navbar .nav-links a {
      margin-left: 20px;
      text-decoration: none;
      color: white;
      font-weight: 500;
    }

    .container {
      display: flex;
    }

    .sidebar {
      width: 200px;
      background-color: #f0f0f0;
      padding: 20px;
      height: calc(100vh - 61px);
    }

    .sidebar a {
      display: block;
      margin-bottom: 15px;
      text-decoration: none;
      color: rgb(125, 89, 5);
      font-weight: 500;
      padding: 10px;
      background-color: white;
      border-radius: 8px;
      text-align: center;
      transition: background 0.3s ease;
    }

    .sidebar a:hover {
      background-color: #ddd;
    }

    .main-content {
      flex: 1;
      padding: 30px;
    }

    h2 {
      margin-bottom: 20px;
      color: #333;
    }

    .search-container {
      margin-bottom: 20px;
    }

    .search-container input {
      padding: 8px;
      width: 300px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    .search-container button {
      padding: 8px 15px;
      background-color: #f57c00;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .user-table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
    }

    .user-table th {
      background-color: #f57c00;
      color: white;
      padding: 12px;
      text-align: left;
    }

    .user-table td {
      padding: 12px;
      border-bottom: 1px solid #eee;
    }

    .user-table tr:hover {
      background-color: #f5f5f5;
    }

    .action-btn {
      padding: 6px 10px;
      border: none;
      border-radius: 5px;
      color: white;
      cursor: pointer;
    }

    .edit-btn {
      background: #ffa726;
    }

    .delete-btn {
      background: #ef5350;
      margin-left: 5px;
      text-decoration: none;
      display: inline-block;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div class="logo">
      <img src="pedal (2).png" alt="Logo">
      <strong><h3>Pedal Malaysia</h3></strong>
    </div>
    <div class="nav-links">
      <a href="logout.php">Logout</a>
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
      <h2>Manage Users</h2>

      <div class="search-container">
        <form method="GET" action="">
          <input type="text" name="search" placeholder="Search by name, email, rental ID..." value="<?php echo htmlspecialchars($search); ?>">
          <button type="submit">Search</button>
        </form>
      </div>

      <table class="user-table">
        <thead>
          <tr>
            <th>Rental ID</th>
            <th>Customer Name</th>
            <th>Bike ID</th>
            <th>Booking Date</th>
            <th>Rental Hours</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>
                <td>{$row['rental_id']}</td>
                <td>{$row['full_name']} ({$row['username']})</td>
                <td>{$row['bike_id']}</td>
                <td>{$row['booking_date']}</td>
                <td>{$row['rental_hours']}</td>
                <td>RM " . number_format($row['total_price'], 2) . "</td>
                <td>{$row['status']}</td>
                <td>
                  <form action='update_status.php' method='POST' style='display:inline-block;'>
                    <input type='hidden' name='rental_id' value='{$row['rental_id']}'>
                    <select name='status'>
                      <option value='Pending'" . ($row['status'] == 'Pending' ? ' selected' : '') . ">Pending</option>
                      <option value='Late'" . ($row['status'] == 'Late' ? ' selected' : '') . ">Late</option>
                      <option value='Complete'" . ($row['status'] == 'Complete' ? ' selected' : '') . ">Complete</option>
                    </select>
                    <button type='submit' class='action-btn edit-btn'>Update</button>
                  </form>
                  <a href='delete_user.php?id={$row['rental_id']}&action=delete' class='action-btn delete-btn' onclick=\"return confirm('Are you sure you want to delete this rental?')\">Delete</a>
                </td>
              </tr>";
            }
          } else {
            echo "<tr><td colspan='8'>No rentals found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
