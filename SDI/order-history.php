<?php
require_once 'db.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

// Fetch user's name
$userQuery = "SELECT username FROM users WHERE id = ?";
$userStmt = $conn->prepare($userQuery);
$userStmt->bind_param("i", $user_id);
$userStmt->execute();
$userResult = $userStmt->get_result();
$userRow = $userResult->fetch_assoc();
$username = $userRow['username'] ?? 'User';

// Fetch rentals and bike info - Updated to include booking_time
$query = "SELECT r.*, b.bike_name, b.image_url FROM rentals r
          JOIN bicycles b ON r.bike_id = b.bike_id
          WHERE r.user_id = ? ORDER BY r.created_at DESC";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Function to format time to 12-hour format
function formatTime($time) {
    if (empty($time)) return 'Not specified';
    
    // Convert 24-hour time to 12-hour format
    $timestamp = strtotime($time);
    return date('g:i A', $timestamp);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Order History - Pedal Malaysia</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    /* your styles here, including .toast styles */
    .toast {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      background-color: #4BB543;
      color: white;
      text-align: center;
      border-radius: 8px;
      padding: 16px;
      position: fixed;
      z-index: 9999;
      left: 50%;
      bottom: 30px;
      font-size: 17px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      transition: visibility 0s, opacity 0.5s linear;
      opacity: 0;
    }
    .toast.show {
      visibility: visible;
      opacity: 1;
    }
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #ffe5b4, #fff1e0);
      color: #333;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: rgba(255, 165, 0, 0.9);
      padding: 10px 20px;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      margin: 0 12px;
      font-weight: 600;
    }

    .navbar a:hover {
      text-decoration: underline;
    }

    .logo img {
      height: 200px;
    }

    .nav-left {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
    }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      background: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .container h2 {
      text-align: center;
      color: #ff6600;
      margin-bottom: 20px;
    }

    .order-item {
      display: flex;
      align-items: center;
      background-color: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      margin-bottom: 20px;
    }

    .order-item img {
      width: 180px;
      height: 120px;
      object-fit: cover;
      border-radius: 10px;
      margin-right: 20px;
    }

    .order-info p {
      margin: 4px 0;
    }

    .booking-time {
      color: #ff6600;
      font-weight: 600;
    }

    .booking-details {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin-bottom: 10px;
    }

    @media (max-width: 600px) {
      .order-item {
        flex-direction: column;
        align-items: flex-start;
      }

      .order-item img {
        width: 100%;
        height: auto;
        margin-bottom: 12px;
      }

      .booking-details {
        grid-template-columns: 1fr;
      }
    }
  
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="logo">
    <img src="pedal (2).png" alt="Pedal Malaysia Logo" />
  </div>
  <div class="nav-left">
    <a href="index.php">Home</a>
    <a href="bikes.php">Bikes</a>
    <a href="booking.php">Booking</a>
    <a href="contact.php">Contact us</a>
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="logout.php">Logout</a>
      <a href="order-history.php">Order History</a>
    <?php else: ?>
      <a href="login.php">Login</a>
    <?php endif; ?>
  </div>
  <div id="toast" class="toast"></div>
</nav>

<div class="container">
  <h2>Hi <?= htmlspecialchars($username) ?>, this is your order history</h2>

  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="order-item" style="border:1px solid #ddd; padding:10px; margin-bottom:10px;">
        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['bike_name']) ?>" width="200" />
        <div class="order-info">
          <h4><?= htmlspecialchars($row['bike_name']) ?></h4>
          
          <div class="booking-details">
            <p><strong>📅 Booking Date:</strong> <?= htmlspecialchars($row['booking_date']) ?></p>
            <p class="booking-time"><strong>🕒 Start Time:</strong> <?= formatTime($row['booking_time']) ?></p>
            <p><strong>⏱️ Duration:</strong> <?= htmlspecialchars($row['rental_hours']) ?> hour(s)</p>
            <p><strong>💰 Total:</strong> RM <?= number_format($row['total_price'], 2) ?></p>
          </div>

          <p><strong>📌 Status:</strong>
  <span style="color: <?= ($row['status'] === 'Cancelled') ? '#f44336' : (($row['status'] === 'Completed') ? 'green' : '#ffa500') ?>;">
    <?= htmlspecialchars($row['status']) ?>
  </span>
</p>


          <?php 
          // Calculate return time if booking_time exists
          if (!empty($row['booking_time']) && !empty($row['rental_hours'])) {
              $startTime = strtotime($row['booking_time']);
              $returnTime = $startTime + ($row['rental_hours'] * 3600); // Add hours in seconds
              $returnTimeFormatted = date('g:i A', $returnTime);
              echo "<p><strong>🔄 Return Time:</strong> <span class='booking-time'>{$returnTimeFormatted}</span></p>";
          }
          ?>

          <!-- Cancel button -->
          <form method="POST" action="delete_booking.php" style="display:inline-block; margin-top:10px;" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
            <input type="hidden" name="rental_id" value="<?= $row['rental_id'] ?>">
            <button type="submit" style="padding:5px 10px; background:#f44336; color:white; border:none; border-radius:4px; cursor:pointer;">Cancel</button>
          </form>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align:center;">You have no rental history yet.</p>
  <?php endif; ?>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    <?php if (isset($_SESSION['message'])): ?>
      const toast = document.getElementById("toast");
      toast.textContent = <?= json_encode($_SESSION['message']) ?>;
      toast.classList.add("show");

      setTimeout(() => {
        toast.classList.remove("show");
      }, 3000);

      <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
  });
</script>

</body>
</html>