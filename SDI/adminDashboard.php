
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard | Pedal Malaysia</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f6f4;
    }

    /* Navbar */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: rgb(208, 98, 1);
      padding: 10px 20px;
      border-bottom: 1px solid #ddd;
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
      color: rgb(255, 255, 255);
      font-weight: 500;
    }

    .container {
      display: flex;
    }

    /* Sidebar */
    .sidebar {
      width: 200px;
      background-color: #f0f0f0;
      padding: 20px;
      border-right: 1px solid #ccc;
      height: calc(100vh - 61px); /* adjust for navbar height */
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

    /* Main content */
    .main-content {
      flex: 1;
      padding: 30px;
    }

    .banner {
      background-color: #d3d3d3;
      height: 250px;
      border-radius: 12px;
      margin-bottom: 40px;
    }

    h2 {
      margin-bottom: 20px;
      color: #333;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      gap: 20px;
      margin-bottom: 40px;
    }

    .card {
      background-color: #ccc;
      padding: 30px;
      border-radius: 10px;
      text-align: center;
    }

    .bike-card {
      height: 160px;
      background-color: #ccc;
      border-radius: 10px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <div class="logo">
      <img src="pedal (2).png" alt="Logo">
      <strong><h3>Pedal Malaysia<h3></strong>
    </div>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="login.php">Logout</a>
    </div>
  </div>

  <!-- Main Page Layout -->
  <div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
      <h3>Admin Name</h3>
       <a href="admin_manage_user.php">Manage Users</a>
      <a href="admin_managebikes.php">Manage Bikes</a>
      <a href="admin_manageuser.php">Manage Booking</a>
          <a href="admin_messages.php">User Messages</a> <!-- New link added -->
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="banner"></div>

      <h2>Users</h2>
      <div class="grid">
        <div class="card">user info</div>
        <div class="card">user info</div>
        <div class="card">user info</div>
        <div class="card">user info</div>
        <div class="card">user info</div>
        <div class="card">user info</div>
      </div>

  <h2 style="text-align:center;">Available Bikes</h2>
<div style="max-width: 1000px; margin: auto; padding: 20px;">
  <table style="width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden;">
    <thead style="background-color: #f57c00; color: white;">
      <tr>
        <th style="padding: 12px;">Image</th>
        <th>Bike Name</th>
        <th>Price/Day (RM)</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="bikeTableBody"></tbody>
  </table>
</div>

<script>
  const bikeList = [
    {
      name: "Mountain Bike X1",
      price: 50,
      image: "images/mountain.jpg",
      available: true
    },
    {
      name: "City Cruiser 3000",
      price: 40,
      image: "images/citybike.jpg",
      available: true
    },
    {
      name: "Electric Foldy",
      price: 70,
      image: "images/foldy.jpg",
      available: false
    }
  ];

  function populateBikeTable() {
    const tbody = document.getElementById("bikeTableBody");
    tbody.innerHTML = "";

    bikeList.forEach((bike, index) => {
      const row = document.createElement("tr");

      row.innerHTML = `
        <td style="text-align: center;"><img src="${bike.image}" alt="${bike.name}" style="width: 80px; border-radius: 8px;"></td>
        <td style="text-align: center;">${bike.name}</td>
        <td style="text-align: center;">RM ${bike.price}</td>
        <td style="text-align: center; color: ${bike.available ? 'green' : 'red'};">${bike.available ? "Available" : "Unavailable"}</td>
        <td style="text-align: center;">
          <button onclick="editBike(${index})" style="padding: 6px 10px; background: #ffa726; border: none; border-radius: 5px; color: white;">Edit</button>
          <button onclick="deleteBike(${index})" style="padding: 6px 10px; background: #ef5350; border: none; border-radius: 5px; color: white; margin-left: 5px;">Delete</button>
        </td>
      `;

      tbody.appendChild(row);
    });
  }

  function editBike(index) {
    alert("Edit bike: " + bikeList[index].name + "\n(This feature is coming soon)");
  }

  function deleteBike(index) {
    if (confirm("Are you sure you want to delete this bike?")) {
      bikeList.splice(index, 1);
      populateBikeTable();
    }
  }

  document.addEventListener("DOMContentLoaded", populateBikeTable);
</script>


</body>
</html>
