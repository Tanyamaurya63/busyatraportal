<?php
// ✅ Step 1: Database connection
include('../db_connect.php');

// ✅ Step 2: Get data from form (via GET method)
$route_id = isset($_GET['route_id']) ? $_GET['route_id'] : '';

$buses = [];
if ($route_id) {
  // ✅ Step 3: Fetch buses based on selected route
  $sql = "SELECT * FROM buses WHERE route_id = '$route_id'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $buses[] = $row;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BusYatra | Select Route</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #1e3c72, #2a5298);
      color: white;
      overflow-x: hidden;
    }
    .bus-animation {
      position: absolute;
      bottom: 0;
      left: -200px;
      width: 150px;
      animation: moveBus 10s linear infinite;
    }
    @keyframes moveBus {
      0% { left: -200px; }
      100% { left: 100vw; }
    }
    .content-box { position: relative; z-index: 2; padding-top: 100px; }
    .dropdown-box {
      background: rgba(255,255,255,0.1);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }
    table {
      color: white;
    }
    .btn-book {
      background-color: #ffc107;
      color: black;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <!-- Animated Bus -->
  <img src="https://cdn-icons-png.flaticon.com/512/296/296216.png" alt="Bus" class="bus-animation">

  <div class="container content-box">
    <h2 class="text-center mb-4">🧭 Choose Your Route</h2>

    <!-- Route Selection -->
    <div class="row justify-content-center mb-5">
      <div class="col-md-6 dropdown-box">
        <form method="GET" action="">
          <div class="mb-3">
            <label for="routeSelect" class="form-label">Select Route</label>
            <select class="form-select" id="routeSelect" name="route_id" required>
              <option value="">Choose a route</option>
              <option value="1" <?php if($route_id==1) echo 'selected'; ?>>Lucknow → New Delhi</option>
              <option value="2" <?php if($route_id==2) echo 'selected'; ?>>Delhi → Kanpur</option>
              <option value="3" <?php if($route_id==3) echo 'selected'; ?>>Agra → Varanasi</option>
              <option value="4" <?php if($route_id==4) echo 'selected'; ?>>Jaipur → Gorakhpur</option>
            </select>
          </div>
          <button type="submit" class="btn btn-warning w-100">🔍 Search Buses</button>
        </form>
      </div>
    </div>

    <!-- Bus Results -->
    <?php if ($route_id): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
          <thead class="table-dark">
            <tr>
              <th>Bus Name</th>
              <th>Bus Number</th>
              <th>Total Seats</th>
              <th>Fare (₹)</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($buses)): ?>
              <?php foreach ($buses as $bus): ?>
              <tr>
                <td><?= $bus['bus_name'] ?></td>
                <td><?= $bus['bus_no'] ?></td>
                <td><?= $bus['total_seats'] ?></td>
                <td><?= $bus['fare'] ?></td>
                <td><a href="book_seat.php?bus_id=<?= $bus['id'] ?>" class="btn btn-sm btn-book">🪑 Book Seat</a></td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="5">😞 No buses found for this route</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

  </div>

</body>
</html>
