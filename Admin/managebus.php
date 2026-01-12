<?php
session_start();
include('../db_connect.php');

// Prevent direct access without login
if (!isset($_SESSION['admin_id'])) {
  header("Location: index.php");
  exit();
}

// 🟢 Add Bus
if (isset($_POST['add_bus'])) {
  $bus_name = mysqli_real_escape_string($conn, $_POST['bus_name']);
  $route_id = mysqli_real_escape_string($conn, $_POST['route_id']);
  $departure_time = mysqli_real_escape_string($conn, $_POST['departure_time']);
  $total_seats = mysqli_real_escape_string($conn, $_POST['total_seats']);

  // Insert query
  $query = "INSERT INTO buses (bus_name, bus_no, route_id, total_seats, available_seats, fare, quota)
            VALUES ('$bus_name', 'N/A', '$route_id', '$total_seats', '$total_seats', '0', 'General')";
  mysqli_query($conn, $query);
  echo "<script>alert('✅ New Bus Added Successfully!');</script>";
}

// 🔴 Delete Bus
if (isset($_GET['delete_id'])) {
  $id = $_GET['delete_id'];
  mysqli_query($conn, "DELETE FROM buses WHERE id='$id'");
  echo "<script>alert('🗑️ Bus Deleted!'); window.location.href='managebus.php';</script>";
}

// 🟡 Fetch All Buses
$buses = mysqli_query($conn, "SELECT * FROM buses ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Buses | BusYatra Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #232526, #414345);
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .form-box, .table-box {
      background-color: rgba(255,255,255,0.1);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }
    .btn-custom {
      background-color: #ffc107;
      color: black;
      font-weight: bold;
    }
    table {
      color: white;
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
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>🚌 Manage Buses</h2>
      <a href="../code/logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Add Bus Form -->
    <div class="form-box mb-5">
      <h5>Add New Bus</h5>
      <form method="POST" action="">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="busName" class="form-label">Bus Name</label>
            <input type="text" name="bus_name" class="form-control" id="busName" placeholder="Enter bus name" required>
          </div>
          <div class="col-md-6">
            <label for="routeId" class="form-label">Route ID</label>
            <input type="number" name="route_id" class="form-control" id="routeId" placeholder="Enter route ID" required>
          </div>
          <div class="col-md-6">
            <label for="departureTime" class="form-label">Departure Time</label>
            <input type="time" name="departure_time" class="form-control" id="departureTime" required>
          </div>
          <div class="col-md-6">
            <label for="totalSeats" class="form-label">Total Seats</label>
            <input type="number" name="total_seats" class="form-control" id="totalSeats" placeholder="Enter total seats" required>
          </div>
        </div>
        <button type="submit" name="add_bus" class="btn btn-custom mt-3">➕ Add Bus</button>
      </form>
    </div>

    <!-- Existing Buses Table -->
    <div class="table-box">
      <h5>Existing Buses</h5>
      <table class="table table-bordered table-hover mt-3">
        <thead class="table-dark">
          <tr>
            <th>Bus ID</th>
            <th>Bus Name</th>
            <th>Route ID</th>
            <th>Total Seats</th>
            <th>Available</th>
            <th>Fare</th>
            <th>Quota</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($buses)) { ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['bus_name']; ?></td>
            <td><?php echo $row['route_id']; ?></td>
            <td><?php echo $row['total_seats']; ?></td>
            <td><?php echo $row['available_seats']; ?></td>
            <td>₹<?php echo $row['fare']; ?></td>
            <td><?php echo $row['quota']; ?></td>
            <td>
              <a href="managebus.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">🗑️ Delete</a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
