<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    $nric = trim($_POST['nric']);

    // Validate required fields
    if (empty($fullname) || empty($email) || empty($phone) || empty($nric) || empty($username) || empty($password) || empty($confirm)) {
        echo "<script>alert('❌ Please fill in all required fields.'); window.location.href='register.php';</script>";
        exit();
    }

    // Validate username format
    if (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {
        echo "<script>alert('❌ Invalid username format.'); window.location.href='register.php';</script>";
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('❌ Invalid email format.'); window.location.href='register.php';</script>";
        exit();
    }

    // Validate password match
    if ($password !== $confirm) {
        echo "<script>alert('❌ Passwords do not match.'); window.location.href='register.php';</script>";
        exit();
    }

    // Check if username already exists
    $checkSql = "SELECT * FROM users WHERE username = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('❌ Username already taken.'); window.location.href='register.php';</script>";
        exit();
    }

    // Check if NRIC already exists
    $checkNricSql = "SELECT * FROM customers WHERE nric = ?";
    $checkNricStmt = $conn->prepare($checkNricSql);
    $checkNricStmt->bind_param("s", $nric);
    $checkNricStmt->execute();
    $checkNricResult = $checkNricStmt->get_result();

    if ($checkNricResult->num_rows > 0) {
        echo "<script>alert('❌ NRIC already registered.'); window.location.href='register.php';</script>";
        exit();
    }

    // Hash password before using it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into users table
    $insertUser = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmtUser = $conn->prepare($insertUser);
    $stmtUser->bind_param("ss", $username, $hashedPassword);

    if ($stmtUser->execute()) {
        $userId = $stmtUser->insert_id;

        // Insert into customers
        $insertCustomer = "INSERT INTO customers (user_id, full_name, email, phone_number, nric, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtCustomer = $conn->prepare($insertCustomer);
        $stmtCustomer->bind_param("issssss", $userId, $fullname, $email, $phone, $nric, $username, $hashedPassword);

        if ($stmtCustomer->execute()) {
            echo "<script>alert('✅ Registration successful!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('❌ Failed to insert customer: " . $conn->error . "'); window.location.href='register.php';</script>";
        }
    } else {
        echo "<script>alert('❌ Failed to insert user: " . $conn->error . "'); window.location.href='register.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register | PedalMalaysia</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      background-image: url('bgReg.jpg');
      background-size: cover;
      background-position: center;
      color: #333;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .register-hero {
      width: 100%;
      padding: 40px 20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-container {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
      max-width: 420px;
      width: 100%;
      text-align: center;
    }

    .logo img {
      width: 80px;
      margin-bottom: 15px;
    }

    .logo h1 {
      font-size: 28px;
      margin-bottom: 10px;
    }

    .orange {
      color: #ff6600;
    }

    .subheading {
      font-size: 14px;
      color: #666;
      margin-bottom: 30px;
    }

    .register-form {
      display: flex;
      flex-direction: column;
      gap: 15px;
      text-align: left;
    }

    .register-form label {
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 5px;
    }

    .register-form input {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      width: 100%;
    }

    .register-form button {
      background-color: #ff3300;
      color: #fff;
      border: none;
      padding: 14px;
      font-size: 16px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      width: 100%;
      transition: 0.3s;
    }

    .register-form button:hover {
      background-color: #e62e00;
    }

    .form-footer {
      margin-top: 25px;
      font-size: 13px;
      color: #555;
    }

    .form-footer a {
      color: #ff6600;
      text-decoration: none;
      font-weight: 600;
    }

    .terms-text {
      margin-top: 20px;
      font-size: 13px;
      color: #555;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: white;
      margin: 10% auto;
      padding: 20px;
      border-radius: 8px;
      max-width: 500px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
      position: relative;
    }

    .close-button {
      color: #aaa;
      position: absolute;
      right: 15px;
      top: 10px;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .close-button:hover {
      color: orange;
    }
  </style>
</head>
<body>
  <section class="register-hero">
    <div class="form-container">
      <div class="logo">
        <img src="pedal (black).png" alt="PedalMalaysia Logo" />
        <h1>Join <span class="orange">PedalMalaysia</span></h1>
        <p class="subheading">Create your account and start exploring amazing places</p>
      </div>

      <form action="register.php" method="post" class="register-form">
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" required />

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required />

        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" required />

        <label for="nric">NRIC Number</label>
        <input type="text" id="nric" name="nric" placeholder="e.g., 980101-14-5678" required />

        <label for="username">Username</label>
        <input type="text" id="username" name="username" required />

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />

        <label for="confirm">Confirm Password</label>
        <input type="password" id="confirm" name="confirm_password" required />

        <button type="submit">Create Account</button>
      </form>

      <p class="terms-text">
        By creating an account, you agree to our 
        <a id="termsLink" href="#" style="color: #ff6600; font-weight: 600; text-decoration: underline;">Terms and Conditions</a>.
      </p>

      <p style="margin-top: 15px; font-size: 13px; color: #555;">
        Already have an account? <a href="login.php" style="color: #ff6600; font-weight: 600;">Sign In</a>
      </p>
    </div>
  </section>

  <!-- Modal -->
  <div id="termsModal" class="modal">
    <div class="modal-content">
      <span class="close-button" id="closeModal">&times;</span>
      <h2>Terms and Conditions</h2>
      <p>
        <br>
        Welcome to PedalMalaysia. By using our services, you agree to the following terms and conditions :
        <br /><br />
        1. You must be 18 years or older to rent a bike.<br>
        2. A refundable deposit is required for all rentals.<br>
        3. Bikes must be returned in the same condition.<br>
        4. Users are responsible for any damages.<br>
        5. Cancellation is allowed up to 24 hours in advance.<br><br>
        For full details, please contact our support team.
      </p>
    </div>
  </div>

  <script>
    const modal = document.getElementById("termsModal");
    const termsLink = document.getElementById("termsLink");
    const closeBtn = document.getElementById("closeModal");

    termsLink.onclick = function(event) {
      event.preventDefault();
      modal.style.display = "block";
    };

    closeBtn.onclick = function() {
      modal.style.display = "none";
    };

    window.onclick = function(event) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    };
  </script>
</body>
</html>