<?php
include('../db_connect.php'); // parent folder se include
if(!isset($_GET['bus_id'])){
    die("No bus selected.");
}
$bus_id = $_GET['bus_id'];

$result = mysqli_query($conn, "SELECT * FROM buses WHERE id='$bus_id'");
$bus = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Seat</title>
    <style>
        body { font-family: Arial; background-color: #f8f9fa; }
        .container { width: 400px; margin: 50px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
        input, button { width: 100%; padding: 10px; margin-top: 8px; }
        button { background: #007bff; color: white; border: none; border-radius: 5px; }
    </style>
</head>
<body>
<div class="container">
    <h3>Book Seat in <?php echo $bus['bus_name']; ?></h3>
    <form action="../code/book_seat_code.php" method="POST">
        <input type="hidden" name="bus_id" value="<?php echo $bus['id']; ?>">

        
        <label>Passenger Name:</label>
        <input type="text" name="passenger_name" required>

        <label>Seat Number:</label>
        <input type="number" name="seat_no" min="1" max="50" required>

        <label>From:</label>
        <input type="text" name="from_city" required>

        <label>To:</label>
        <input type="text" name="to_city" required>

        <button type="submit" name="book">Book Now</button>
    </form>
</div>
</body>
</html>
