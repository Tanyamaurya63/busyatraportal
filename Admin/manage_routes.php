<?php
session_start();
include('../db_connect.php');

// Prevent access without login
if (!isset($_SESSION['admin_id'])) {
  header("Location: index.php");
  exit();
}

// 🟢 Add New Route
if (isset($_POST['add_route'])) {
  $source = mysqli_real_escape_string($conn, $_POST['source']);
  $destination = mysqli_real_escape_string($conn, $_POST['destination']);
  $distance = mysqli_real_escape_string($conn, $_POST['distance']);
  $duration = mysqli_real_escape_string($conn, $_POST['duration']);

  $query = "INSERT INTO routes (source, destination, distance, duration)
            VALUES ('$source', '$destination', '$distance', '$duration')";
  mysqli_query($conn, $query);

  echo "<script>alert('✅ New Route Added Successfully!');</script>";
}

// 🔴 Delete Route
if (isset($_GET['delete_id'])) {
  $id = $_GET['delete_id'];
  mysqli_query($conn, "DELETE FROM routes WHERE id='$id'");
  echo "<script>alert('🗑️ Route Deleted!'); window.location.href='manage_routes.php';</script>";
}

// 🟡 Fetch All Routes
$routes = mysqli_query($conn, "SELECT * FROM routes ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Routes | BusYatra Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #1f4037, #99f2c8);
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
      <h2>🧭 Manage Routes</h2>
      <a href="../code/logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- Add Route Form -->
    <div class="form-box mb-5">
      <h5>Add New Route</h5>
      <form method="POST" action="">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="source" class="form-label">Source</label>
            <input type="text" name="source" class="form-control" id="source" placeholder="Enter source city" required>
          </div>
          <div class="col-md-6">
            <label for="destination" class="form-label">Destination</label>
            <input type="text" name="destination" class="form-control" id="destination" placeholder="Enter destination city" required>
          </div>
          <div class="col-md-6">
            <label for="distance" class="form-label">Distance (km)</label>
            <input type="number" name="distance" class="form-control" id="distance" placeholder="Enter distance" required>
          </div>
          <div class="col-md-6">
            <label for="duration" class="form-label">Duration (hrs)</label>
            <input type="text" name="duration" class="form-control" id="duration" placeholder="e.g. 5h 30m" required>
          </div>
        </div>
        <button type="submit" name="add_route" class="btn btn-custom mt-3">➕ Add Route</button>
      </form>
    </div>

    <!-- Existing Routes Table -->
    <div class="table-box">
      <h5>Existing Routes</h5>
      <table class="table table-bordered table-hover mt-3">
        <thead class="table-dark">
          <tr>
            <th>Route ID</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Distance (km)</th>
            <th>Duration</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($routes)) { ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['source']; ?></td>
            <td><?php echo $row['destination']; ?></td>
            <td><?php echo $row['distance_km']; ?></td>
            <td><?php echo $row['duration_hr']; ?></td>
            <td>
              <a href="manage_routes.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this route?')">🗑️ Delete</a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
