<style>
@media print {
  button, .no-print {
    display: none !important;
  }
}
</style>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db.php';

echo "<script>alert('Booking confirmed! Please print your receipt and bring it to the counter.');</script>";

$user_id = $_SESSION['user_id'];
$bike_id = intval($_POST['bike_id'] ?? 0);
$booking_date = $_POST['booking_date'] ?? '';
$start_time = $_POST['start_time'] ?? '';  // Capture the booking time
$hours = intval($_POST['hours'] ?? 0);

// Validate inputs
if ($bike_id <= 0 || empty($booking_date) || empty($start_time) || $hours <= 0) {
    var_dump($_POST);
    die("Invalid booking information. Please try again.");
}

// Get actual price from DB
$stmt = $conn->prepare("SELECT price_per_hour FROM bicycles WHERE bike_id = ?");
$stmt->bind_param("i", $bike_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Bike not found.");
}

$row = $result->fetch_assoc();
$price_per_hour = (float)$row['price_per_hour'];
$total_price = $price_per_hour * $hours;

$created_at = date('Y-m-d H:i:s');

// Updated INSERT statement to include booking_time
$insert = $conn->prepare("INSERT INTO rentals (user_id, bike_id, booking_date, booking_time, rental_hours, total_price, created_at)
                          VALUES (?, ?, ?, ?, ?, ?, ?)");
$insert->bind_param("iissids", $user_id, $bike_id, $booking_date, $start_time, $hours, $total_price, $created_at);

if ($insert->execute()) {
    // Use hidden POST data from your form
    $bikeName = $_POST['bike_name'];
    $bikeImage = $_POST['bike_image'];
    $bikePrice = (float)$_POST['bike_price'];
    $deposit = (float)$_POST['deposit'];

    // Calculate return time and total
    $startDateTime = new DateTime("$booking_date $start_time");
    $returnTime = clone $startDateTime;
    $returnTime->modify("+$hours hours");

    $total = ($bikePrice * $hours) + $deposit;
    ?>
    <!DOCTYPE html>
    <html>
    <head>
      <title>Booking Receipt</title>
      <style>
        body { font-family: Arial; padding: 20px; }
        .receipt-box {
          border: 1px solid #ccc;
          padding: 20px;
          max-width: 500px;
          margin: auto;
        }
        img { max-width: 100%; height: auto; }
      </style>
    </head>
    <body>

    <div class="receipt-box">
      <h2>🧾 Booking Receipt</h2>
      <img src="<?php echo $bikeImage; ?>" alt="Bike Image"><br><br>
      <p><strong>Bike Name:</strong> <?php echo $bikeName; ?></p>
      <p><strong>Booking Date:</strong> <?php echo $booking_date; ?></p>
      <p><strong>Start Time:</strong> <?php echo $start_time; ?></p>
      <p><strong>Number of Hours:</strong> <?php echo $hours; ?></p>
      <p><strong>Return Time:</strong> <?php echo $returnTime->format('H:i'); ?></p>
      <p><strong>Bike Price/hour:</strong> RM <?php echo number_format($bikePrice, 2); ?></p>
      <p><strong>Deposit:</strong> RM <?php echo number_format($deposit, 2); ?></p>
      <hr>
      <p><strong>Total Payment:</strong> <span style="color:green;">RM <?php echo number_format($total, 2); ?></span></p>
    </div>
    
    <div style="text-align: center; margin-top: 20px;">
  <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">
    🖨️ Print Receipt
  </button>
  <a href="order-history.php" class="no-print">
    <button style="padding: 10px 20px; font-size: 16px; cursor: pointer;">
      📄 View Order History
    </button>
  </a>
</div>
</div>


    </body>
    </html>
    <?php
} else {
    echo "Error saving booking: " . $conn->error;
}


$stmt->close();
$insert->close();
$conn->close();
?>