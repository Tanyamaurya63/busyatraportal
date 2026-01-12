<?php
include '../db_connect.php';
session_start();

if (isset($_POST['btn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query: check admin table
    $query = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin'] = $row['email'];  // Session create
        $_SESSION['admin_id'] = $row['id'];  // Optional

        header("Location: ../Admin/dashboard.php");
        exit();
    } else {
        echo "<script>alert('❌ Invalid Email or Password'); window.location.href='../Admin/index.php';</script>";
    }
}
?>
