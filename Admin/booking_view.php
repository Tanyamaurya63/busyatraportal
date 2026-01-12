<?php
// Database connection
include('../db_connect.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete booking
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM bookings WHERE id = '$id'");
    echo "<script>alert('Booking deleted successfully!'); window.location='booking_view.php';</script>";
}

// Fetch bookings
$result = $conn->query("SELECT * FROM bookings ORDER BY id DESC");

// Function to get bus name using bus_id
function getBusName($conn, $bus_id) {
    $query = $conn->query("SELECT bus_name FROM buses WHERE id='$bus_id'");
    if ($query && $query->num_rows > 0) {
        $row = $query->fetch_assoc();
        return $row['bus_name'];
    }
    return "Unknown Bus";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Bookings | BusYatra Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #141e30, #243b55);
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .table-box {
      background-color: rgba(255,255,255,0.1);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }
    table {
      color: white;
    }
    .btn-view {
      background-color: #17a2b8;
      color: white;
    }
    .btn-delete {
      background-color: #dc3545;
      color: white;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <h2 class="text-center mb-4">📋 View All Bookings</h2>

  <div class="table-box">
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>Booking ID</th>
          <th>Bus Name</th>
          <th>Seat No.</th>
          <th>Passenger</th>
          <th>From</th>
          <th>To</th>
          <th>Booking Time</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                $busName = getBusName($conn, $row['bus_id']);

                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$busName}</td>
                        <td>{$row['seat_number']}</td>
                        <td>{$row['passenger_name']}</td>
                        <td>{$row['from_city']}</td>
                        <td>{$row['to_city']}</td>
                        <td>{$row['booking_time']}</td>
                        <td>
                          <a href='view_booking_details.php?id={$row['id']}' class='btn btn-sm btn-view'>👁️ View</a>
                          <a href='booking_view.php?delete={$row['id']}' 
                             class='btn btn-sm btn-delete' 
                             onclick='return confirm(\"Are you sure you want to delete this booking?\")'>
                             🗑️ Delete
                          </a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8' class='text-center'>No bookings found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
