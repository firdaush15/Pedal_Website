<?php
include("db.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';
$filterQuery = "SELECT * FROM contact_messages";

if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search);
    $filterQuery .= " WHERE fullname LIKE '%$search%' OR email LIKE '%$search%' OR inquiry_type LIKE '%$search%' OR subject LIKE '%$search%'";
}

$filterQuery .= " ORDER BY submitted_at DESC";
$result = mysqli_query($conn, $filterQuery);
if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard | User Messages</title>
  <style>
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
      color: white;
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
      width: 220px;
      background-color: #f0f0f0;
      padding: 20px;
      height: calc(100vh - 61px);
    }

    .sidebar h3 {
      color: #444;
      margin-bottom: 25px;
      font-size: 20px;
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
      overflow-x: auto;
    }

    h2 {
      margin-bottom: 20px;
      color: #333;
    }

    form.search-form {
      margin-bottom: 20px;
    }

    form input[type="text"] {
      padding: 8px;
      width: 300px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    form button {
      padding: 8px 12px;
      background-color: #f57c00;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .user-table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .user-table th {
      background-color: #f57c00;
      color: white;
      padding: 12px;
      text-align: left;
      font-weight: 600;
    }

    .user-table td {
      padding: 12px;
      border-bottom: 1px solid #eee;
      vertical-align: top;
    }

    .user-table tr:hover {
      background-color: #f5f5f5;
    }

    .attachment-link {
      color: #007BFF;
      text-decoration: none;
    }

    .attachment-link:hover {
      text-decoration: underline;
    }

    .btn-action {
      display: inline-block;
      margin: 2px 0;
      padding: 5px 10px;
      background-color: #00897b;
      color: white;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      font-size: 12px;
    }

    .btn-action:hover {
      background-color: #00695c;
    }

    .status-label {
      padding: 4px 8px;
      border-radius: 6px;
      font-size: 12px;
      color: white;
    }

    .resolved {
      background-color: green;
    }

    .unresolved {
      background-color: red;
    }
  </style>
</head>
<body>

<div class="navbar">
  <div class="logo">
    <img src="pedal (2).png" alt="Logo">
    <h3>Pedal Malaysia</h3>
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
    <a href="admin_messages.php">User Messages</a>
  </div>

  <div class="main-content">
    <h2>User Contact Messages</h2>

    <form class="search-form" method="GET" action="admin_messages.php">
      <input type="text" name="search" placeholder="Search by name, email, subject..." value="<?= htmlspecialchars($search) ?>">
      <button type="submit">Search</button>
    </form>

    <table class="user-table">
      <thead>
        <tr>
          <th>Full Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Type</th>
          <th>Subject</th>
          <th>Message</th>
          <th>Attachment</th>
          <th>Submitted At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= htmlspecialchars($row['fullname']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['phone']) ?></td>
              <td><?= htmlspecialchars($row['inquiry_type']) ?></td>
              <td><?= htmlspecialchars($row['subject']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
              <td>
                <?php if (!empty($row['attachment'])): ?>
                  <a class="attachment-link" href="uploads/<?= htmlspecialchars($row['attachment']) ?>" download>Download</a>
                <?php else: ?>
                  No Attachment
                <?php endif; ?>
              </td>
              <td><?= $row['submitted_at'] ?></td>
              <td>
                <div>
                  <span class="status-label <?= $row['status'] === 'Resolved' ? 'resolved' : 'unresolved' ?>">
                    <?= $row['status'] ?? 'Unresolved' ?>
                  </span><br>
           <a class="btn-action" href="update_messages_status.php?id=<?= $row['id'] ?>&status=Resolved">Mark Resolved</a>
<a class="btn-action" href="update_messages_status.php?id=<?= $row['id'] ?>&status=Unresolved">Mark Unresolved</a>
                  <a class="btn-action" href="mailto:<?= htmlspecialchars($row['email']) ?>?subject=Reply to your message&body=Hi <?= htmlspecialchars($row['fullname']) ?>," target="_blank">Reply Email</a>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="9">No messages found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
