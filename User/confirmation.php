<?php
// Database connection
include('../db_connect.php');
// Get booking ID from URL
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

if ($booking_id > 0) {
  $sql = "SELECT * FROM bookings WHERE id = $booking_id";
  $result = $conn->query($sql);
  $booking = $result->fetch_assoc();
} else {
  $booking = null;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Confirmation | BusYatra</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .ticket-box {
      background-color: rgba(255,255,255,0.1);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.4);
    }
    .qr-placeholder {
      width: 120px;
      height: 120px;
      background-color: white;
      border-radius: 8px;
      margin: auto;
    }
    .btn-custom {
      background-color: #ffc107;
      color: black;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <?php if ($booking): ?>
    <h2 class="text-center mb-4">🎉 Booking Confirmed!</h2>

    <div class="ticket-box mx-auto" style="max-width: 600px;">
      <h5 class="text-center mb-3">🚌 BusYatra Ticket</h5>

      <div class="mb-3">
        <strong>Passenger:</strong> <?= htmlspecialchars($booking['passenger_name']) ?><br>
        <strong>Email:</strong> <?= htmlspecialchars($booking['email']) ?><br>
        <strong>Phone:</strong> <?= htmlspecialchars($booking['phone']) ?>
      </div>

      <div class="mb-3">
        <strong>Bus:</strong> <?= htmlspecialchars($booking['bus_name']) ?><br>
        <strong>Route:</strong> <?= htmlspecialchars($booking['source']) ?> → <?= htmlspecialchars($booking['destination']) ?><br>
        <strong>Departure:</strong> <?= htmlspecialchars($booking['departure_time']) ?>
      </div>

      <div class="mb-3">
        <strong>Seat No:</strong> <?= htmlspecialchars($booking['seat_no']) ?><br>
        <strong>Quota:</strong> <?= htmlspecialchars($booking['quota']) ?><br>
        <strong>Status:</strong> ✅ Confirmed
      </div>

      <div class="text-center mb-3">
        <div class="qr-placeholder d-flex align-items-center justify-content-center">
          <span class="text-dark">QR</span>
        </div>
        <small class="d-block mt-2">Scan at boarding point</small>
      </div>

      <div class="d-flex justify-content-between">
        <button class="btn btn-custom" onclick="window.print()">🖨️ Print Ticket</button>
        <a href="download_ticket.php?booking_id=<?= $booking['id'] ?>" class="btn btn-light text-dark">⬇️ Download</a>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-danger text-center mt-5">
      ❌ Invalid or Missing Booking ID.
    </div>
  <?php endif; ?>
</div>

</body>
</html>
