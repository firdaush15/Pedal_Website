<?php
session_start();
require_once 'db.php';

$query = "SELECT * FROM bicycles";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Available Bikes | Pedal Malaysia</title>
  <link rel="stylesheet" href="style.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    /* Your exact style as you posted (no changes) */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #ffe5b4, #fff1e0);
      margin: 0;
      padding: 0;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: rgba(255, 165, 0, 0.9);
      padding: 10px 20px;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      margin: 0 12px;
      font-weight: 600;
    }

    .logo img {
      height: 200px;
    }

    .bike-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 25px;
      padding: 30px;
      max-width: 1400px;
      margin: 0 auto;
    }

    .bike-card {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      padding: 20px;
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      display: flex;
      flex-direction: column;
      height: auto;
      min-height: 420px;
    }

    .bike-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .bike-card img {
      width: 100%;
      height: 180px;
      border-radius: 8px;
      object-fit: cover;
      margin-bottom: 15px;
    }

    .bike-card h3 {
      font-size: 1.4em;
      font-weight: 700;
      color: #333;
      margin: 10px 0;
      line-height: 1.2;
    }

    .bike-info {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .price-info {
      margin: 12px 0;
    }

    .deposit {
      font-size: 0.9em;
      color: #666;
      margin: 5px 0;
      font-weight: 500;
    }

    .hourly-rate {
      font-size: 1.1em;
      font-weight: 700;
      color: #ff6600;
      margin: 8px 0;
    }

    .description {
      font-size: 0.95em;
      color: #555;
      line-height: 1.4;
      margin: 12px 0;
      text-align: center;
      flex-grow: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .bike-card button {
      background-color: #ff8c00;
      color: white;
      border: none;
      padding: 12px 24px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1em;
      font-weight: 600;
      transition: background-color 0.3s ease, transform 0.2s ease;
      margin-top: 15px;
      width: 100%;
    }

    .bike-card button:hover {
      background-color: #ff7700;
      transform: translateY(-2px);
    }

    .bike-card button:active {
      transform: translateY(0);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .bike-list {
        grid-template-columns: 1fr;
        padding: 20px;
        gap: 20px;
      }
      
      .bike-card {
        min-height: 380px;
        padding: 15px;
      }
      
      .bike-card h3 {
        font-size: 1.2em;
      }
      
      .logo img {
        height: 150px;
      }
    }
    .status-label {
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: bold;
      text-transform: uppercase;
      font-size: 0.9em;
      margin-bottom: 10px;
      display: inline-block;
    }

    .status-label.available {
      background-color: #d4edda;
      color: #155724;
    }

    .status-label.unavailable {
      background-color: #f8d7da;
      color: #721c24;
    }

    .status-label.maintenance {
      background-color: #fff3cd;
      color: #856404;
    }

    .bike-card button:disabled {
      background-color: #ccc;
      cursor: not-allowed;
      color: #666;
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
</nav>

<!-- BIKE LIST -->
<div class="bike-list">
  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($bike = $result->fetch_assoc()): ?>
      <div class="bike-card">
        <?php
          $imageFile = $bike['image_url'];
          $imagePath = (!empty($imageFile) && file_exists($imageFile)) ? $imageFile : 'default-bike.png';
        ?>
        <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($bike['bike_name']) ?>">

        <div class="bike-info">
          <h3><?= htmlspecialchars($bike['bike_name']) ?></h3>
          
          <div class="price-info">
            <div class="deposit">
              <strong>Deposit:</strong> RM100.00
            </div>

            <div class="hourly-rate">
              RM <?= number_format($bike['price_per_hour'], 2) ?>/hour
            </div>
          </div>

          <div class="description">
            <?= htmlspecialchars($bike['description']) ?>
          </div>

          <?php
            $bikeData = [
              'id' => $bike['bike_id'],
              'name' => $bike['bike_name'],
              'image' => basename($imagePath),
              'price' => (float)$bike['price_per_hour']
            ];
          ?>

          <div class="status-label <?= strtolower($bike['status']) ?>">
            <?= htmlspecialchars($bike['status']) ?>
          </div>

          <button 
            onclick='bookBike(<?= json_encode($bikeData) ?>)' 
            <?= ($bike['status'] !== 'Available') ? 'disabled' : '' ?>>
            Rent
          </button>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No bikes available at the moment.</p>
  <?php endif; ?>
</div>

<script>
function bookBike(bike) {
  localStorage.setItem("bikeId", bike.id);
  localStorage.setItem("bikeName", bike.name);
  localStorage.setItem("bikeImage", bike.image);
  localStorage.setItem("bikePrice", bike.price);
  window.location.href = "booking.php";
}
</script>

</body>
</html>
