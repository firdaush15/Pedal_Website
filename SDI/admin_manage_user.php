<?php
include("db.php");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$search = isset($_GET["search"]) ? $_GET["search"] : "";

$query = "SELECT users.id AS user_id, users.username, users.role,
                 customers.full_name, customers.email, customers.phone_number, customers.nric
          FROM users
          LEFT JOIN customers ON users.id = customers.user_id";

if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $query .= " WHERE customers.full_name LIKE '%$search%' 
                OR users.username LIKE '%$search%' 
                OR customers.email LIKE '%$search%' 
                OR users.id LIKE '%$search%'";
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
  <title>Admin Dashboard | Manage Users</title>
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
      background: #42a5f5;
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
          <input type="text" name="search" placeholder="Search by name, email, username..." value="<?php echo htmlspecialchars($search); ?>">
          <button type="submit">Search</button>
        </form>
      </div>

      <table class="user-table">
        <thead>
          <tr>
            <th>User ID</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>NRIC</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>
                <td>{$row['user_id']}</td>
                <td>{$row['full_name']}</td>
                <td>{$row['username']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone_number']}</td>
                <td>{$row['nric']}</td>
<td>
  <form method='POST' action='update_role.php' style='display:inline-block;'>
    <input type='hidden' name='user_id' value='{$row['user_id']}'>
    <select name='role' onchange='this.form.submit()'>
      <option value='admin' " . ($row['role'] == 'admin' ? 'selected' : '') . ">Admin</option>
      <option value='customer' " . ($row['role'] == 'customer' ? 'selected' : '') . ">Customer</option>
    </select>
  </form>
  <a href='edit_user.php?id={$row['user_id']}' class='action-btn edit-btn'>Edit</a>
  <a href='delete_user.php?id={$row['user_id']}' class='action-btn delete-btn' onclick=\"return confirm('Are you sure you want to delete this user?')\">Delete</a>
</td>

              </tr>";
            }
          } else {
            echo "<tr><td colspan='7'>No users found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
