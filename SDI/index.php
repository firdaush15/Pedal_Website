
<?php session_start(); ?>
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


   .bike-section {
  max-width: 1200px;
  margin: 50px auto;
  padding: 30px 20px;
  position: relative;
  border-radius: 20px;
  text-align: center;
  background: linear-gradient(135deg, #fff7f0, #ff6a00);
  box-shadow: 0 8px 30px rgba(255, 106, 0, 0.3);
  overflow: hidden;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.bike-section::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle at center, rgba(255, 106, 0, 0.1), transparent 70%);
  z-index: 0;
  pointer-events: none;
  border-radius: 20px;
}

.bike-section * {
  position: relative;
  z-index: 1;
}

.explore-btn {
  display: inline-block;
  background: #ff5100;
  color: white;
  padding: 14px 36px;
  font-size: 20px;
  font-weight: 700;
  border-radius: 50px;
  margin: 30px auto;
  cursor: pointer;
  text-decoration: none;
  box-shadow: 0 6px 15px rgba(255, 81, 0, 0.6);
  transition: all 0.4s ease;
  user-select: none;
  letter-spacing: 1.1px;
  text-transform: uppercase;
}

.explore-btn:hover {
  background: #f5a732;
  box-shadow: 0 8px 25px rgba(245, 167, 50, 0.7);
  transform: scale(1.05);
}

.bike-grid {
  display: flex;
  gap: 25px;
  overflow-x: auto;
  scroll-snap-type: x mandatory;
  -webkit-overflow-scrolling: touch;
  padding-bottom: 10px;
}

.bike-card {
  background: rgba(255, 255, 255, 0.85);
  border-radius: 20px;
  box-shadow: 0 8px 20px rgba(255, 106, 0, 0.15);
  padding: 20px;
  width: 280px;
  flex-shrink: 0;
  text-align: center;
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  scroll-snap-align: center;
  cursor: pointer;
}

.bike-card:hover {
  transform: scale(1.05);
  box-shadow: 0 15px 35px rgba(255, 106, 0, 0.4);
}

.bike-card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-radius: 15px;
  transition: transform 0.5s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.bike-card:hover img {
  transform: scale(1.1);
}

.bike-card h4 {
  margin-top: 15px;
  font-size: 22px;
  color: #ff5100;
  font-weight: 700;
  letter-spacing: 0.8px;
}

.bike-card p {
  margin-top: 8px;
  font-size: 16px;
  color: #555;
  line-height: 1.4;
  font-weight: 500;
  min-height: 54px;
}


    .why-choose {
      position: relative;
      background: linear-gradient(to right, #ffe5b4, #fff1e0);
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      padding: 40px 20px;
      margin: 40px auto;
      border-radius: 16px;
      color: #000;
      text-align: center;
      overflow: hidden;
    }

    .why-choose::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.6);
      z-index: 1;
      border-radius: 16px;
    }

    .why-choose * {
      position: relative;
      z-index: 2;
    }

    .feature-boxes {
      display: flex;
      justify-content: center;
      gap: 40px;
      flex-wrap: wrap;
      margin-top: 30px;
    }

    .feature-box {
      max-width: 250px;
      background: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .feature-box i {
      font-size: 40px;
      margin-bottom: 15px;
      color: #ff5100;
    }

    .footer {
      background-color: #fff5e6;
      padding: 20px 0;
      text-align: center;
    }

    .footer .footer-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .footer p {
      margin: 5px 0;
    }

.interactive-banner {
  display: flex;
  justify-content: center;
  gap: 20px;
  max-width: 1000px;
  margin: 40px auto;
}

.banner-item {
  position: relative;
  width: 320px;
  height: 200px;
  overflow: hidden;
  border-radius: 12px;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(255, 87, 34, 0.3);
  transition: transform 0.3s ease;
  background: white;
}

.banner-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
  border-radius: 12px;
}

.banner-item:hover {
  transform: scale(1.05);
  box-shadow: 0 6px 15px rgba(255, 87, 34, 0.6);
}

.banner-item:hover img {
  transform: scale(1.1);
}

.overlay {
  position: absolute;
  bottom: 0;
  width: 100%;
  background: rgba(255, 87, 34, 0.8); /* orange tint */
  color: white;
  padding: 10px 0;
  text-align: center;
  font-weight: bold;
  font-size: 16px;
  opacity: 0;
  transition: opacity 0.3s ease;
  border-radius: 0 0 12px 12px;
}

.banner-item:hover .overlay {
  opacity: 1;
}

.our-story-section {
  background: #fff7f0;
  padding: 60px 20px;
  border-radius: 20px;
  max-width: 1100px;
  margin: 60px auto;
  box-shadow: 0 8px 30px rgba(255, 106, 0, 0.15);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #333;
}

.our-story-section .container {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 40px;
}

.our-story-section h2 {
  width: 100%;
  font-size: 36px;
  font-weight: 700;
  color: #ff5100;
  margin-bottom: 30px;
  text-align: center;
  letter-spacing: 1.2px;
}

.story-content {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  gap: 30px;
  width: 100%;
}

.story-text {
  flex: 1 1 400px;
  font-size: 18px;
  line-height: 1.6;
  color: #555;
}

.story-text p {
  margin-bottom: 20px;
}

.btn-learn-more {
  display: inline-block;
  padding: 14px 30px;
  background-color: #ff5100;
  color: white;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  font-size: 18px;
  transition: background-color 0.3s ease;
  box-shadow: 0 6px 15px rgba(255, 81, 0, 0.6);
}

.btn-learn-more:hover {
  background-color: #f5a732;
  box-shadow: 0 8px 25px rgba(245, 167, 50, 0.7);
}

.story-image {
  flex: 1 1 400px;
  max-width: 450px;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 8px 25px rgba(255, 106, 0, 0.3);
}

.story-image img {
  width: 100%;
  height: auto;
  display: block;
  object-fit: cover;
  transition: transform 0.4s ease;
  border-radius: 20px;
}

.story-image img:hover {
  transform: scale(1.05);
  cursor: pointer;
}

/* Responsive */
@media (max-width: 768px) {
  .our-story-section .container {
    flex-direction: column;
  }
  .story-text, .story-image {
    max-width: 100%;
  }
  
}
.collab-section {
  position: relative;
  background: rgba(255, 255, 255, 0.85); /* White with 85% opacity */
  padding: 80px 20px;
  color: #333; /* Dark text for contrast on white bg */
  overflow: hidden;
  border-radius: 20px;
  max-width: 1200px;
  margin: 60px auto;
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

/* Remove overlay */
.collab-section .overlay {
  display: none;
}

.collab-content {
  position: relative;
  z-index: 2;
  text-align: center;
}

.collab-content h2 {
  font-size: 3rem;
  margin-bottom: 12px;
  font-weight: 900;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: #FF6B00;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 12px;
}

.collab-content h2 i {
  font-size: 2.8rem;
  animation: bike-spin 4s linear infinite;
}

.collab-content p {
  font-size: 1.25rem;
  max-width: 600px;
  margin: 0 auto 40px;
  color: #555;
  font-weight: 600;
}

.collab-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 20px;
}

.collab-item {
  overflow: hidden;
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.1);
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.collab-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.collab-item:hover {
  transform: translateY(-10px) scale(1.05);
  box-shadow: 0 16px 40px rgba(255, 107, 0, 0.8);
}

.collab-item:hover img {
  transform: scale(1.1) rotate(1deg);
}

/* Spin animation keyframes */
@keyframes bike-spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

/* Responsive */
@media (max-width: 600px) {
  .collab-content h2 {
    font-size: 2rem;
  }
  .collab-content p {
    font-size: 1rem;
  }
}



  </style>
</head>

<body>

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

 
  <!-- Auto Sliding Promotion second Banner -->
<div class="interactive-banner">
  <div class="banner-item">
    <img src="promo1 (2).jpg" alt="Bike 1" />
    <div class="overlay">
      <p>Rent from $10/hour</p>
    </div>
  </div>
  <div class="banner-item">
    <img src="promo3.jpg" alt="Bike 2" />
    <div class="overlay">
      <p>FREE!</p>
    </div>
  </div>
  <div class="banner-item">
    <img src="bicycle3.jpg" alt="Bike 3" />
    <div class="overlay">
      <p>Best for city rides</p>
    </div>
  </div>
</div>

  <!-- our story -->
<section class="our-story-section">
  <div class="container">
    <h2>Our Story</h2>
    <div class="story-content">
      <div class="story-text">
        <p>
          Pedal Malaysia started with a simple mission: to make cycling accessible and enjoyable for everyone across Malaysia. 
          We believe in the power of two wheels to bring people closer to nature, promote health, and reduce urban congestion.
        </p>
        <p>
          Since our launch, we have provided quality bikes and exceptional service, enabling thousands to explore their cities and trails effortlessly. 
          Join us on this journey as we continue to promote sustainable, fun, and affordable cycling experiences for all.
        </p>
        <a href="about.php" class="btn-learn-more">Learn More</a>
      </div>
      <div class="story-image">
        <img src="ImageStory.jpg" alt="People cycling in Malaysia" />
      </div>
    </div>
  </div>
</section>



  <!-- Bike Cards Section -->
  <section class="bike-section">
  <a href="bikes.php" class="explore-btn">Explore Our Bikes</a>

  <div class="bike-grid">
    <div class="bike-card">
      <img src="OIP (5).jpeg" alt="Mountain Bike" />
      <h4>Mountain Bike</h4>
      <p>Built for off-road adventures and rough terrain.</p>
    </div>
    <div class="bike-card">
      <img src="OIP (6).jpeg" alt="Electric Bike" />
      <h4>Electric Bike</h4>
      <p>Efficient for urban commuting with a sleek design.</p>
    </div>
    <div class="bike-card">
      <img src="roadbike.jpg" alt="Road Bike" />
      <h4>Road Bike</h4>
      <p>Designed for speed and long-distance rides on smooth pavement.</p>
    </div>
    <div class="bike-card">
      <img src="bike4.jpg" alt="Hybrid Bike" />
      <h4>Hybrid Bike</h4>
      <p>Versatile bike suitable for both city and trail rides.</p>
    </div>
    <div class="bike-card">
      <img src="bike5.jpg" alt="Folding Bike" />
      <h4>Folding Bike</h4>
      <p>Compact and ideal for urban dwellers and commuters.</p>
    </div>
  </div>
</section>

<section class="collab-section">
  <div class="overlay"></div>
  <div class="collab-content">
    <h2><i class="fas fa-bicycle"></i> Our Collaborations</h2>
    <p>Partnering with the best in the cycling world to bring you awesome rides and events!</p>
    <div class="collab-gallery">
      <div class="collab-item">
        <img src="collab1.jpg" alt="Collaboration 1" />
      </div>
      <div class="collab-item">
        <img src="collab2.jpg" alt="Collaboration 2" />
      </div>
      <div class="collab-item">
        <img src="collab3.jpg" alt="Collaboration 3" />
    </div>
  </div>
</section>

  <!-- Why Choose Us Section -->
  <section class="why-choose">
    <h2>Why Choose Pedal Malaysia?</h2>
    <div class="feature-boxes">
      <div class="feature-box">
        <i class="fas fa-shield-alt"></i>
        <h4>Safety & Security</h4>
        <p>We prioritize your safety with high-quality bikes and secure rental processes.</p>
      </div>
      <div class="feature-box">
        <i class="fas fa-smile"></i>
        <h4>Friendly Service</h4>
        <p>Our team is always ready to assist with a smile and helpful support.</p>
      </div>
      <div class="feature-box">
        <i class="fas fa-file-contract"></i>
        <h4>Clear Rental Terms & Guarantee</h4>
        <p>No hidden fees. Transparent policies and guaranteed satisfaction.</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-container">
      <p><strong>Pedal Malaysia</strong><br />Experience Malaysia one ride at a time</p>
      <p>&copy; 2025 Pedal Malaysia. All rights reserved.</p>
    </div>
  </footer>


</body>
</html>
