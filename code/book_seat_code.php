<?php
include('../db_connect.php'); // back to main folder

if(isset($_POST['book'])){
    $bus_id = $_POST['bus_id'];
    $seat_no = $_POST['seat_no'];
    $passenger_name = $_POST['passenger_name'];
    $from_city = $_POST['from_city'];
    $to_city = $_POST['to_city'];

    // Check if seat already booked
   // Check if seat already booked
$check_sql = "SELECT * FROM bookings WHERE bus_id='$bus_id' AND seat_number='$seat_no'";
$check_result = mysqli_query($conn, $check_sql);


    if(mysqli_num_rows($check_result) > 0){
        echo "<script>alert('Seat already booked!'); window.location='../User/bus_list.php';</script>";
    } else {
       $sql = "INSERT INTO bookings (bus_id, seat_number, passenger_name, from_city, to_city)
        VALUES ('$bus_id', '$seat_no', '$passenger_name', '$from_city', '$to_city')";

        if(mysqli_query($conn, $sql)){
            echo "<script>alert('Seat booked successfully!'); window.location='../User/bus_list.php';</script>";
        } else {
            echo "<script>alert('Error booking seat'); window.location='../User/bus_list.php';</script>";
        }
    }
}
?>
