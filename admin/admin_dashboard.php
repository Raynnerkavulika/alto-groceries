<?php 
include '../config.php';


session_start();

$admin_id = $_SESSION['admin'];

if(!isset($admin_id)){
  header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin dashboard</title>
    <!-- custom css file link -->
    <link rel="stylesheet" href="../style.css">
    <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <!-- admin header -->

    <?php include 'admin_header.php'; ?>

     <?php
     $total_pending_orders = 0;
      $select_pending_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
      $select_pending_orders->execute(['pending']);
      while($fetch_pending_orders = $select_pending_orders->fetch(PDO::FETCH_ASSOC)){
         $total_pending_orders += $fetch_pending_orders;
      }    
    ?>

    <h3>total pending orders</h3>
    <p>SH <?= $total_pending_orders; ?></p>
</body>
</html>