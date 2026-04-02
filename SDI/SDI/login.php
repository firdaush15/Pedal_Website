<?php
ob_start();
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    if (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {
        $error = '❌ Invalid username format.';
    } else {
        // Query the users table
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $valid = false;

            if ($user['role'] === 'customer') {
                $valid = password_verify($password, $user['password']);
            } elseif ($user['role'] === 'admin') {
                $valid = ($password === $user['password']);
            }

            if ($valid) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: admin_manageuser.php");
                } else {
                    header("Location: bikes.php");
                }
                exit();
            } else {
                $error = '❌ Incorrect password.';
            }
        } else {
            $error = '❌ User not found.';
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Pedal Malaysia</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      margin: 0;
      min-height: 100vh;
      font-family: Arial, sans-serif;
      background-image: url('Cover-1440x625-22.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }
    .login-container {
      background-color: rgba(255, 255, 255, 0.85);
      padding: 20px;
      margin: 20px auto;
      border-radius: 12px;
      max-width: 900px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .login-content {
      display: flex;
      max-width: 900px;
      width: 100%;
      border-radius: 12px;
      overflow: hidden;
    }
    .login-logo-side {
      flex: 1;
      background-color: #fff5e6;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-logo-side .big-logo {
      width: 80%;
      max-width: 300px;
    }
    .login-form-side {
      flex: 1;
      padding: 40px;
      background-color: #fff;
    }
    .login-form-side h2 {
      color: #ff6600;
      margin-bottom: 10px;
    }
    .login-form-side p {
      margin-bottom: 20px;
    }
    .login-form-side label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    .login-form-side input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .login-form-side button {
      width: 100%;
      background-color: #ff6600;
      color: #fff;
      padding: 12px;
      border: none;
      margin-top: 20px;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }
    .login-form-side .account-link {
      margin-top: 15px;
      text-align: center;
    }
    .login-form-side .account-link a {
      color: #ff6600;
      text-decoration: none;
    }
    .logo img {
      width: 200px;
      height: auto;
    }
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      background-color: rgba(255, 255, 255, 0.85);
      position: sticky;
      top: 0;
      z-index: 999;
    }
    .nav-left a {
      margin-left: 20px;
      text-decoration: none;
      color: #333;
      font-weight: bold;
    }
    .nav-left a:hover {
      color: #ff6600;
    }
    .error-msg {
      color: red;
      font-weight: bold;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>

<body>
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
        <a href="order-history.php">Order History</a>
        <a href="logout.php" class="login-btn">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
      <?php else: ?>
        <a href="login.php" class="login-btn">Login</a>
      <?php endif; ?>
    </div>
  </nav>

  <section class="login-container">
    <div class="login-content">
      <div class="login-logo-side">
        <img src="pedal (black).png" alt="PedalMalaysia Logo" class="big-logo" />
      </div>
      <div class="login-form-side">
        <h2>Welcome Back</h2>
        <p>Login to continue your journey with Pedal Malaysia</p>

        <?php if (!empty($error)): ?>
          <p class="error-msg"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="login.php" method="post">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required />

          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required />

          <button type="submit">Login</button>

          <p class="account-link">Don’t have an account? <a href="register.php">Register here</a></p>
        </form>
      </div>
    </div>
  </section>
</body>
</html>
