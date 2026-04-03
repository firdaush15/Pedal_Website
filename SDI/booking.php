<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Booking - Pedal Malaysia</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #fef9f4, #ffe1c4);
      color: #333;
    }

    /* Navbar */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: rgba(255, 165, 0, 0.9);
      padding: 10px 20px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

    .form-box {
      background: rgba(255, 255, 255, 0.8);
      max-width: 500px;
      margin: 50px auto;
      padding: 35px;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(8px);
      text-align: center;
    }

    .bike-preview img {
      width: 100%;
      max-width: 300px;
      border-radius: 18px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      transition: transform 0.25s ease;
    }

    .bike-preview img:hover {
      transform: scale(1.05);
    }

    h2 {
      font-size: 1.8rem;
      margin: 20px 0 30px;
      color: #ff5722;
    }

    form {
      text-align: left;
    }

    form label {
      font-weight: 600;
      margin-bottom: 8px;
      display: block;
      color: #444;
    }

    form input[type="date"],
    form input[type="number"],
    form select {
      width: 100%;
      padding: 12px 16px;
      border: 2px solid #ffb382;
      border-radius: 12px;
      font-size: 1rem;
      margin-bottom: 20px;
      transition: border-color 0.3s;
      background-color: #fffdfa;
    }

    form input:focus,
    form select:focus {
      border-color: #ff5722;
      outline: none;
      box-shadow: 0 0 6px rgba(255, 87, 34, 0.4);
    }

    /* Date validation error styling */
    .date-error, .time-error {
      border-color: #ff1744 !important;
      box-shadow: 0 0 6px rgba(255, 23, 68, 0.4) !important;
    }

    .error-message {
      color: #ff1744;
      font-size: 0.9rem;
      margin-top: -15px;
      margin-bottom: 15px;
      display: none;
    }

    #total,
    #returnTime {
      font-weight: bold;
      margin: 8px 0;
      color: #ff5722;
    }

    button {
      width: 100%;
      padding: 14px;
      font-size: 1.1rem;
      font-weight: 700;
      color: white;
      background: linear-gradient(to right, #ff7f50, #ff5722);
      border: none;
      border-radius: 14px;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
    }

    button:hover {
      background: linear-gradient(to right, #ff5722, #e65100);
      transform: translateY(-2px);
    }

    button:disabled {
      background: #cccccc;
      cursor: not-allowed;
      transform: none;
    }

    @media (max-width: 480px) {
      .form-box {
        margin: 30px 16px;
        padding: 25px 20px;
      }

      h2 {
        font-size: 1.5rem;
      }

      form input {
        font-size: 0.95rem;
      }

      button {
        font-size: 1rem;
      }
    }
    .business-hours {
      background-color: #f0f8ff;
      padding: 10px;
      border-left: 5px solid #00aaff;
      margin-bottom: 15px;
    }

    .time-info {
      background-color: #fff3e0;
      padding: 10px;
      border-left: 5px solid #ff9800;
      margin-bottom: 15px;
      font-size: 0.9rem;
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

<div class="business-hours">
  <h3>📅 Business Hours</h3>
  <ul>
    <li>🕘 Monday – Friday: 9:00 AM to 6:00 PM</li>
    <li>🕙 Saturday – Sunday: 10:00 AM to 4:00 PM</li>
  </ul>
</div>

<!-- FORM -->
<div class="form-box">
  <div class="bike-preview">
    <img id="bikeImageDisplay" src="" alt="Selected Bike" />
    <h3 id="bikeNameDisplay"></h3>
  </div>

  <h2>Bike Booking</h2>
  <form action="submit_booking.php" method="POST" onsubmit="return confirmBooking()">
    <input type="hidden" name="bike_id" id="bikeIdInput" />
    <input type="hidden" name="bike_name" id="bikeNameInput" />
    <input type="hidden" name="bike_image" id="bikeImageInput" />
    <input type="hidden" name="bike_price" id="bikePriceInput" />
    <input type="hidden" name="deposit" value="100" />
    <input type="hidden" name="booking_time" id="bookingTimeInput" />

    <label for="bookingDateInput">Booking Date:</label>
    <input type="date" name="booking_date" id="bookingDateInput" required />
    <div class="error-message" id="dateError">Please select today's date or a future date.</div>

    <label for="bookingTimeSelect">Start Time:</label>
    <select name="start_time" id="bookingTimeSelect" required>
      <option value="">Select start time</option>
    </select>
    <div class="error-message" id="timeError">Please select a valid start time.</div>
    
    <div class="time-info" id="timeInfo" style="display: none;">
      ⏰ <strong>Note:</strong> You must return the bike before closing time.
    </div>

    <label for="hoursInput">Number of Hours:</label>
    <input type="number" name="hours" id="hoursInput" min="1" required />


    <p id="total">Total: RM 0.00</p>
    <p id="returnTime">Return Time: -</p>
    <p id="deposit">Deposit: RM 100.00</p><br>

    <div style="background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
  <strong>⚠️ Important Booking Notice:</strong>
  <ul style="margin-top: 10px;">
    <li>⏰ If you return the bike late by more than <strong>30 minutes</strong>, <strong>RM50</strong> will be deducted from your deposit.</li>
    <li>🔧 If the bike is <strong>damaged</strong>, the <strong>full deposit</strong> will be taken.</li>
    <li>🚫 If the bike is <strong>missing</strong>, you will be charged a <strong>RM500 fine per bike</strong>.</li>
  </ul>
</div>
<div style="margin-top: 15px; display: flex; align-items: center;">
  <input type="checkbox" id="agree" required style="margin-right: 10px;">
  <label for="agree" style="margin: 0;">
    I understand and agree to the penalties for late return, damages, or missing bikes.
  </label>
</div>
    <div class="error-message" id="agreementError" style="display: none;">You must agree to the terms and conditions.</div><br>

    <button type="submit" id="submitBtn">Confirm Booking</button>
  </form>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const bikeId = localStorage.getItem("bikeId");
    const bikeName = localStorage.getItem("bikeName");
    const bikeImage = localStorage.getItem("bikeImage");
    const bikePrice = localStorage.getItem("bikePrice");

    if (!bikeId || !bikeName || !bikeImage || !bikePrice) {
      alert("No bike selected. Please select a bike first.");
      window.location.href = "bikes.php";
      return;
    }

    document.getElementById("bikeImageDisplay").src = bikeImage;
    document.getElementById("bikeNameDisplay").textContent = bikeName;
    document.getElementById("bikeIdInput").value = bikeId;
    document.getElementById("bikeNameInput").value = bikeName;
    document.getElementById("bikeImageInput").value = bikeImage;
    document.getElementById("bikePriceInput").value = bikePrice;

    // Set minimum date to today
    const today = new Date();
    const todayString = today.toISOString().split('T')[0];
    document.getElementById("bookingDateInput").min = todayString;

    // Event listeners
    document.getElementById("bookingDateInput").addEventListener("change", handleDateChange);
    document.getElementById("bookingTimeSelect").addEventListener("change", calculateTotal);
    document.getElementById("hoursInput").addEventListener("input", calculateTotal);

    calculateTotal();
  });

  function handleDateChange() {
    const selectedDate = new Date(document.getElementById("bookingDateInput").value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    const dateInput = document.getElementById("bookingDateInput");
    const errorMessage = document.getElementById("dateError");
    const submitBtn = document.getElementById("submitBtn");
    const timeSelect = document.getElementById("bookingTimeSelect");

    if (selectedDate < today) {
      // Show error styling and message
      dateInput.classList.add("date-error");
      errorMessage.style.display = "block";
      submitBtn.disabled = true;
      timeSelect.innerHTML = '<option value="">Select start time</option>';
      document.getElementById("returnTime").textContent = "Return Time: -";
      return;
    } else {
      // Remove error styling and message
      dateInput.classList.remove("date-error");
      errorMessage.style.display = "none";
      submitBtn.disabled = false;
    }

    // Populate time options based on selected date
    populateTimeOptions(selectedDate);
    calculateTotal();
  }

  function populateTimeOptions(selectedDate) {
    const timeSelect = document.getElementById("bookingTimeSelect");
    const timeInfo = document.getElementById("timeInfo");
    const day = selectedDate.getDay(); // 0 = Sunday, 6 = Saturday
    const today = new Date();
    const isToday = selectedDate.toDateString() === today.toDateString();

    // Clear existing options
    timeSelect.innerHTML = '<option value="">Select start time</option>';
    
    // Determine business hours
    let startHour, endHour;
    if (day >= 1 && day <= 5) { // Monday to Friday
      startHour = 9;
      endHour = 18; // 6 PM
    } else { // Saturday and Sunday
      startHour = 10;
      endHour = (day === 6) ? 16 : 16; // 4 PM for weekends
    }

    // If it's today, start from current hour + 1 (to allow preparation time)
    if (isToday) {
      const currentHour = today.getHours();
      const currentMinute = today.getMinutes();
      
      // If current time is past opening, start from next hour
      if (currentHour >= startHour) {
        startHour = currentHour + (currentMinute > 0 ? 2 : 1); // Add buffer time
      }
      
      // If it's too late today, show message
      if (startHour >= endHour) {
        timeSelect.innerHTML = '<option value="">Too late to book today</option>';
        timeInfo.style.display = "block";
        timeInfo.innerHTML = '⚠️ <strong>Too late for today!</strong> Please select a future date.';
        return;
      }
    }

    // Generate time options (every hour)
    for (let hour = startHour; hour < endHour; hour++) {
      const time12 = formatTo12Hour(hour, 0);
      const time24 = String(hour).padStart(2, '0') + ':00';
      
      const option = document.createElement('option');
      option.value = time24;
      option.textContent = time12;
      timeSelect.appendChild(option);
    }

    // Show time info
    timeInfo.style.display = "block";
    const closingTime = formatTo12Hour(endHour, 0);
    timeInfo.innerHTML = `⏰ <strong>Note:</strong> Store closes at ${closingTime}. You must return the bike before closing time.`;
  }

  function formatTo12Hour(hour, minute) {
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const hour12 = hour % 12;
    const displayHour = hour12 ? hour12 : 12;
    const displayMinute = minute.toString().padStart(2, '0');
    return `${displayHour}:${displayMinute} ${ampm}`;
  }

  function calculateTotal() {
    const deposit = 100;
    const hours = parseInt(document.getElementById("hoursInput").value) || 0;
    const price = parseFloat(document.getElementById("bikePriceInput").value) || 0;
    const total = hours * price;
    const totalWithDeposit = total + deposit;

    document.getElementById("total").textContent = "Total: RM " + totalWithDeposit.toFixed(2);

    const dateInput = document.getElementById("bookingDateInput").value;
    const timeInput = document.getElementById("bookingTimeSelect").value;
    
    if (dateInput && timeInput && hours > 0) {
      calculateReturnTime();
    } else {
      document.getElementById("returnTime").textContent = "Return Time: -";
    }
  }

  function calculateReturnTime() {
    const dateStr = document.getElementById("bookingDateInput").value;
    const timeStr = document.getElementById("bookingTimeSelect").value;
    const hours = parseInt(document.getElementById("hoursInput").value) || 0;
    
    if (!dateStr || !timeStr || hours <= 0) {
      document.getElementById("returnTime").textContent = "Return Time: -";
      return;
    }

    // Create start datetime
    const startDateTime = new Date(dateStr + 'T' + timeStr);
    const selectedDate = new Date(dateStr);
    const day = selectedDate.getDay();
    
    // Calculate return time
    const returnDateTime = new Date(startDateTime.getTime() + hours * 60 * 60 * 1000);
    
    // Check if return time exceeds closing time
    const closingTime = new Date(selectedDate);
    closingTime.setHours(day >= 1 && day <= 5 ? 18 : 16, 0, 0, 0); // 6 PM weekdays, 4 PM weekends
    
    const timeSelect = document.getElementById("bookingTimeSelect");
    const timeError = document.getElementById("timeError");
    const submitBtn = document.getElementById("submitBtn");
    
    if (returnDateTime > closingTime) {
      // Show error
      timeSelect.classList.add("time-error");
      timeError.style.display = "block";
      timeError.textContent = `Return time (${returnDateTime.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit', hour12: true})}) exceeds closing time. Please reduce hours or choose earlier start time.`;
      submitBtn.disabled = true;
      document.getElementById("returnTime").textContent = "Return Time: Exceeds closing time!";
    } else {
      // Remove error
      timeSelect.classList.remove("time-error");
      timeError.style.display = "none";
      submitBtn.disabled = false;
      
      // Update booking time hidden input
      document.getElementById("bookingTimeInput").value = timeStr;
      
      // Display return time
      document.getElementById("returnTime").textContent = 
        "Return Time: " + returnDateTime.toLocaleString("en-MY", {
          hour12: true,
          weekday: "short",
          year: "numeric",
          month: "short",
          day: "numeric",
          hour: "2-digit",
          minute: "2-digit"
        });
    }
  }

  function confirmBooking() {
    // Additional validation before form submission
    const selectedDate = new Date(document.getElementById("bookingDateInput").value);
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    if (selectedDate < today) {
      alert("Cannot book for past dates. Please select today's date or a future date.");
      return false;
    }
    
    const timeSelect = document.getElementById("bookingTimeSelect").value;
    if (!timeSelect) {
      alert("Please select a start time for your booking.");
      return false;
    }
    
    const hours = parseInt(document.getElementById("hoursInput").value);
    if (!hours || hours < 1) {
      alert("Please enter a valid number of hours.");
      return false;
    }
    
    return confirm("Are you sure you want to confirm this booking?");
  }
</script>

</body>
</html>