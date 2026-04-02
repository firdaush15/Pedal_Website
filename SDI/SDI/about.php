<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pedal Malaysia</title>

  <!-- FontAwesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="style.css" />

  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url('https://images.pexels.com/photos/100582/pexels-photo-100582.jpeg');
      background-size: cover;
      background-attachment: fixed;
      margin: 0;
    }
    .navbar .logo img {
  height: 200px; /* Adjust height as needed */
  width: auto;  /* Keeps aspect ratio */
}
    .navbar-banner {
      width: 100%;
      overflow: hidden;
      position: relative;
      height: 400px;
    }

    .navbar-banner img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }


.about-section {
  background-color: #fff;
  padding: 60px 20px;
  max-width: 1100px;
  margin: 60px auto;
  border-radius: 20px;
  box-shadow: 0 8px 30px rgba(255, 81, 0, 0.15);
  color: #333;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  text-align: center;
}

.about-section h2 {
  color: #ff5100;
  font-size: 36px;
  margin-bottom: 40px;
  font-weight: 700;
  letter-spacing: 1.2px;
}

.about-content {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  align-items: center;
  gap: 40px;
}

.about-text {
  flex: 1 1 450px;
  font-size: 18px;
  line-height: 1.6;
  color: #555;
  text-align: left;
}

.about-stats {
  display: flex;
  gap: 30px;
  flex: 1 1 400px;
  justify-content: center;
  flex-wrap: wrap;
}

.stat-item {
  background-color: #ff5100;
  color: white;
  padding: 30px 25px;
  border-radius: 20px;
  box-shadow: 0 6px 15px rgba(255, 81, 0, 0.5);
  width: 140px;
  transition: transform 0.3s ease;
}

.stat-item:hover {
  transform: scale(1.1);
  box-shadow: 0 10px 25px rgba(255, 81, 0, 0.7);
}

.stat-item h3 {
  font-size: 42px;
  margin-bottom: 10px;
  font-weight: 700;
  letter-spacing: 1px;
}

.stat-item p {
  font-size: 18px;
  font-weight: 600;
  letter-spacing: 0.8px;
}

/* Responsive */
@media (max-width: 768px) {
  .about-content {
    flex-direction: column;
  }
  .about-text, .about-stats {
    flex-basis: 100%;
    text-align: center;
  }
  .about-text {
    margin-bottom: 30px;
  }
}
</style>

<!-- NAVBAR (UNCHANGED) -->
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
  <?php else: ?>
    <a href="login.php">Login</a>
  <?php endif; ?>
         <?php if (isset($_SESSION['user_id'])): ?>
  <a href="order-history.php">Order History</a>
<?php endif; ?>

    </div>
  </nav>

<section class="about-section">
  <div class="container">
    <h2>About Pedal Malaysia</h2>
    <div class="about-content">
      <div class="about-text">
        <p>
          At Pedal Malaysia, we are passionate about promoting cycling as a healthy, eco-friendly, and fun way to explore the beautiful landscapes and vibrant cities of Malaysia.
        </p>
        <p>
          Our team is dedicated to providing the best quality bikes and rental services, ensuring every ride is safe, comfortable, and unforgettable. Whether you're commuting, exercising, or adventuring, Pedal Malaysia is your trusted partner on two wheels.
        </p>
      </div>
      <div class="about-stats">
        <div class="stat-item">
          <h3>5000+</h3>
          <p>Happy Riders</p>
        </div>
        <div class="stat-item">
          <h3>50+</h3>
          <p>Bike Models</p>
        </div>
        <div class="stat-item">
          <h3>10</h3>
          <p>Rental Locations</p>
        </div>
      </div>
    </div>
  </div>
</section>
