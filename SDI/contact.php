<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Us - Pedal Malaysia</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
  <style>
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

    .navbar .logo img {
      height: 60px;
    }

    .container {
      max-width: 900px;
      margin: 60px auto;
      background: rgba(255, 255, 255, 0.85);
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .contact-form label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }

    .contact-form input,
    .contact-form textarea,
    .contact-form select {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
      font-size: 1rem;
    }

    button {
      background-color: orange;
      color: white;
      padding: 14px;
      border: none;
      width: 100%;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s ease;
    }

    button:hover {
      background-color: darkorange;
    }

    .faq-section {
      background-color: rgba(255, 255, 255, 0.8);
      padding: 60px 20px;
      border-radius: 24px;
      margin: 40px auto;
      max-width: 1200px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .faq-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 24px;
    }

    .faq-card {
      background: white;
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease;
    }

    .faq-card:hover {
      transform: translateY(-6px);
    }
    @keyframes fadeSlideUp {
  0% {
    opacity: 0;
    transform: translateY(30px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.faq-card {
  opacity: 0;
  transform: translateY(30px);
  animation: fadeSlideUp 0.6s ease forwards;
}

.faq-card:nth-child(1) { animation-delay: 0.1s; }
.faq-card:nth-child(2) { animation-delay: 0.2s; }
.faq-card:nth-child(3) { animation-delay: 0.3s; }
.faq-card:nth-child(4) { animation-delay: 0.4s; }
.faq-card:nth-child(5) { animation-delay: 0.5s; }
.faq-card:nth-child(6) { animation-delay: 0.6s; }

.call-btn {
  background-color: orange;
  color: white;
  padding: 14px 28px;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: bold;
  text-decoration: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
  display: inline-block;
}

.call-btn:hover {
  background-color: darkorange;
}

 .logo img {
      width: 80px;
      margin-bottom: 200px;
    }


  </style>

</head>
<body>

<!-- Navbar -->
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

<!-- Contact Form -->
<div class="container">
  <h2>Contact Us</h2>
  <p>If you have any questions or issues, reach out using the form below.</p>

  <form class="contact-form" action="contact_submit.php" method="POST" enctype="multipart/form-data">
    <label for="fullname">Full Name</label>
    <input type="text" name="fullname" id="fullname" required>

    <label for="email">Email Address</label>
    <input type="email" name="email" id="email" required>

    <label for="phone">Phone Number (optional)</label>
    <input type="tel" name="phone" id="phone">

    <label for="inquiry_type">Inquiry Type</label>
    <select name="inquiry_type" id="inquiry_type" required>
      <option value="">-- Select --</option>
      <option value="Rental Issue">Rental Issue</option>
      <option value="Payment Problem">Payment Problem</option>
      <option value="Return/Refund">Return/Refund</option>
      <option value="Lost Item">Lost Item</option>
      <option value="General Question">General Question</option>
    </select>

    <label for="subject">Subject</label>
    <input type="text" name="subject" id="subject" required>

    <label for="message">Message</label>
    <textarea name="message" id="message" rows="5" required></textarea>

    <label for="attachment">Upload Image (optional)</label>
    <input type="file" name="attachment" id="attachment" accept="image/*">

    <button type="submit">Send Message</button>
  </form>

  <h3>Business Hours</h3>
  <p>Mon–Fri: 9:00 AM – 6:00 PM | Sat–Sun: 10:00 AM – 4:00 PM</p>

  <h3>Connect with us</h3>
  <div style="font-size: 1.5rem;">
    <a href="https://wa.me/601162206039" target="_blank" style="color:#25D366;"><i class="fab fa-whatsapp"></i></a>
    <a href="https://www.facebook.com/" target="_blank" style="margin-left: 20px; color:#3b5998;"><i class="fab fa-facebook"></i></a>
    <a href="https://www.instagram.com/" target="_blank" style="margin-left: 20px; color:#e1306c;"><i class="fab fa-instagram"></i></a>
  </div>
</div>


<!-- FAQ Section -->
<section class="faq-section container">
  <h2>Frequently Asked Questions (FAQ)</h2>
 <div class="call-support" style="text-align:center; margin-bottom:30px;">
  <a href="tel:+601162206039" class="call-btn">📞 Call Customer Service</a>
</div>

  <div class="faq-grid">
    <div class="faq-card">
      <h3>Q1: What types of bikes do you rent?</h3>
      <p>A: We offer hybrid, cruiser, mountain, and other types of bikes.</p>
    </div>
    <div class="faq-card">
      <h3>Q2: How much is the rental fee?</h3>
      <p>A: Rental fees start at RM10/hour. Daily pricing varies by bike type.</p>
    </div>
    <div class="faq-card">
      <h3>Q3: Do I need to pay a deposit?</h3>
      <p>A: Yes, a RM100 refundable deposit is required.</p>
    </div>
    <div class="faq-card">
      <h3>Q4: Do you provide helmets?</h3>
      <p>A: Yes, all rentals include helmets at no additional cost.</p>
    </div>
    <div class="faq-card">
  <h3>Q6: What happens to my deposit if the bike is damaged?</h3>
  <p>A: If the bicycle is returned with damage caused by misuse or negligence, your RM100 deposit may be withheld to cover repair costs. Minor wear and tear is acceptable and will not affect your deposit.</p>
</div>

    <!-- New FAQ Card -->
    <div class="faq-card">
      <h3>Q5: When will I get my deposit back?</h3>
      <p>A: Your RM50 deposit will be refunded within 1–2 working days after the bike is returned in good condition.</p>
    </div>
  </div>
</section>


<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  const params = new URLSearchParams(window.location.search);
  const status = params.get("status");
  const msg = params.get("msg");
  if (status && msg) {
    if (status === "success") {
      toastr.success(msg);
    } else if (status === "error") {
      toastr.error(msg);
    }
    setTimeout(() => {
      history.replaceState({}, document.title, window.location.pathname);
    }, 1000);
  }
</script>


</body>
</html>
