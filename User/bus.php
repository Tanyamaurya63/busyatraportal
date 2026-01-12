<?php
// ✅ Step 1: Database connection
include('../db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BusYatra | Book Your Journey</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #00c6ff, #0072ff);
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .search-box {
      background: rgba(255, 255, 255, 0.1);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }
    .btn-search {
      background-color: #ffc107;
      color: #000;
      font-weight: bold;
    }
    .tagline { animation: blink 1s infinite; }
    @keyframes blink {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }
  </style>
</head>
<body>

<div class="container py-5">
  <h2 class="text-center mb-3">🚌 Welcome to <strong>BusYatra</strong></h2>
  <p class="text-center tagline">Book your seat before it’s gone!</p>

  <div class="row justify-content-center">
    <div class="col-md-6 search-box">
      <form method="GET" action="bus_list.php">
        <div class="mb-3">
          <label for="source" class="form-label">Source</label>
          <input type="text" class="form-control" name="source" placeholder="Enter source city" required>
        </div>
        <div class="mb-3">
          <label for="destination" class="form-label">Destination</label>
          <input type="text" class="form-control" name="destination" placeholder="Enter destination city" required>
        </div>
        <div class="mb-3">
          <label for="journeyDate" class="form-label">Journey Date</label>
          <input type="date" class="form-control" name="date" required>
        </div>
        <button type="submit" class="btn btn-search w-100">🔍 Search Buses</button>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
