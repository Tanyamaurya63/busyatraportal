<?php
session_start();

// Prevent direct access without login
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BusYatra Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      background-color: rgba(255,255,255,0.1);
      border: none;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
      color: white;
      transition: 0.3s ease;
    }
    .card:hover {
      transform: scale(1.02);
    }
    .btn-custom {
      background-color: #ffc107;
      color: black;
      font-weight: bold;
    }
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }
    .logout-btn {
      background-color: #dc3545;
      color: white;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      text-decoration: none;
    }
    .logout-btn:hover {
      background-color: #bb2d3b;
    }
  </style>
</head>
<body>

  <div class="container py-5">
    <div class="top-bar">
      <h2>🛠️ Welcome, <?php echo $_SESSION['admin']; ?>!</h2>
      <a href="../code/logout.php" class="logout-btn">Logout</a>
    </div>

    <h3 class="text-center mb-4">BusYatra Admin Dashboard</h3>

    <div class="row g-4">
      <!-- Manage Buses -->
      <div class="col-md-4">
        <div class="card p-3">
          <h5>🚌 Manage Buses</h5>
          <p>Add or edit bus details, departure time, total seats</p>
          <a href="managebus.php" class="btn btn-custom w-100">Go to Buses</a>
        </div>
      </div>

      <!-- Manage Routes -->
      <div class="col-md-4">
        <div class="card p-3">
          <h5>🧭 Manage Routes</h5>
          <p>Define source, destination, distance, duration</p>
          <a href="manage_routes.php" class="btn btn-custom w-100">Go to Routes</a>
        </div>
      </div>

      <!-- Manage Quotas -->
      <div class="col-md-4">
        <div class="card p-3">
          <h5>🎫 Manage Quotas</h5>
          <p>Set quota limits, cutoff times, and rules</p>
          <a href="manage_quotas.php" class="btn btn-custom w-100">Go to Quotas</a>
        </div>
      </div>

      <!-- View Bookings -->
      <div class="col-md-6">
        <div class="card p-3">
          <h5>📋 View Bookings</h5>
          <p>Check confirmed bookings, user info, seat status</p>
          <a href="booking_view.php" class="btn btn-custom w-100">View Bookings</a>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
