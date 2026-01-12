<?php
// ✅ Database Connection
include('../db_connect.php');

// ✅ Add Quota
if (isset($_POST['add_quota'])) {
  $name = mysqli_real_escape_string($conn, $_POST['quotaName']);
  $limit = mysqli_real_escape_string($conn, $_POST['limitPercent']);
  $cutoff = mysqli_real_escape_string($conn, $_POST['cutoffTime']);

  $query = "INSERT INTO quotas (quota_name, limit_percent, cutoff_time)
            VALUES ('$name', '$limit', '$cutoff')";
  mysqli_query($conn, $query);
  echo "<script>alert('✅ Quota Added Successfully!'); window.location.href='manage_quotas.php';</script>";
}

// ✅ Delete Quota
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM quotas WHERE id='$id'");
  echo "<script>alert('🗑️ Quota Deleted!'); window.location.href='manage_quotas.php';</script>";
}

// ✅ Edit Quota (Fetch Data)
$edit_data = null;
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $edit_query = mysqli_query($conn, "SELECT * FROM quotas WHERE id='$id'");
  $edit_data = mysqli_fetch_assoc($edit_query);
}

// ✅ Update Quota
if (isset($_POST['update_quota'])) {
  $id = $_POST['quota_id'];
  $name = mysqli_real_escape_string($conn, $_POST['quotaName']);
  $limit = mysqli_real_escape_string($conn, $_POST['limitPercent']);
  $cutoff = mysqli_real_escape_string($conn, $_POST['cutoffTime']);

  $update = "UPDATE quotas SET quota_name='$name', limit_percent='$limit', cutoff_time='$cutoff' WHERE id='$id'";
  mysqli_query($conn, $update);
  echo "<script>alert('✏️ Quota Updated Successfully!'); window.location.href='manage_quotas.php';</script>";
}

// ✅ Fetch All Quotas
$quotas = mysqli_query($conn, "SELECT * FROM quotas ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Quotas | BusYatra Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #3a6186, #89253e);
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
      <h2>🎫 Manage Booking Quotas</h2>
      <a href="../code/logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- 🟢 Add or Edit Quota Form -->
    <div class="form-box mb-5">
      <?php if ($edit_data) { ?>
        <h5>✏️ Edit Quota</h5>
        <form method="POST" action="">
          <input type="hidden" name="quota_id" value="<?php echo $edit_data['id']; ?>">
          <div class="row g-3">
            <div class="col-md-4">
              <label for="quotaName" class="form-label">Quota Name</label>
              <select class="form-select" id="quotaName" name="quotaName" required>
                <option disabled>Select quota</option>
                <option value="Tatkal" <?php if ($edit_data['quota_name']=='Tatkal') echo 'selected'; ?>>Tatkal</option>
                <option value="Ladies" <?php if ($edit_data['quota_name']=='Ladies') echo 'selected'; ?>>Ladies</option>
                <option value="General" <?php if ($edit_data['quota_name']=='General') echo 'selected'; ?>>General</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="limitPercent" class="form-label">Limit (%)</label>
              <input type="number" name="limitPercent" class="form-control" id="limitPercent"
                     value="<?php echo $edit_data['limit_percent']; ?>" required>
            </div>
            <div class="col-md-4">
              <label for="cutoffTime" class="form-label">Cutoff Time</label>
              <input type="time" name="cutoffTime" class="form-control" id="cutoffTime"
                     value="<?php echo $edit_data['cutoff_time']; ?>" required>
            </div>
          </div>
          <button type="submit" name="update_quota" class="btn btn-success mt-3">💾 Update Quota</button>
          <a href="manage_quotas.php" class="btn btn-secondary mt-3">❌ Cancel</a>
        </form>
      <?php } else { ?>
        <h5>➕ Add New Quota</h5>
        <form method="POST" action="">
          <div class="row g-3">
            <div class="col-md-4">
              <label for="quotaName" class="form-label">Quota Name</label>
              <select class="form-select" id="quotaName" name="quotaName" required>
                <option selected disabled>Select quota</option>
                <option value="Tatkal">Tatkal</option>
                <option value="Ladies">Ladies</option>
                <option value="General">General</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="limitPercent" class="form-label">Limit (%)</label>
              <input type="number" name="limitPercent" class="form-control" id="limitPercent" placeholder="e.g. 20" required>
            </div>
            <div class="col-md-4">
              <label for="cutoffTime" class="form-label">Cutoff Time</label>
              <input type="time" name="cutoffTime" class="form-control" id="cutoffTime" required>
            </div>
          </div>
          <button type="submit" name="add_quota" class="btn btn-custom mt-3">➕ Add Quota</button>
        </form>
      <?php } ?>
    </div>

    <!-- 🟡 Existing Quotas Table -->
    <div class="table-box">
      <h5>Existing Quotas</h5>
      <table class="table table-bordered table-hover mt-3">
        <thead class="table-dark">
          <tr>
            <th>Quota ID</th>
            <th>Name</th>
            <th>Limit (%)</th>
            <th>Cutoff Time</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($quotas)) { ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['quota_name']; ?></td>
            <td><?php echo $row['limit_percent']; ?>%</td>
            <td><?php echo $row['cutoff_time']; ?></td>
            <td>
              <a href="manage_quotas.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
              <a href="manage_quotas.php?delete=<?php echo $row['id']; ?>" 
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Are you sure you want to delete this quota?')">🗑️ Delete</a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
