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
    <section class="dashboard">
    <h3 class="title">admin dashboard</h3>

        <div class="box-container">
          <div class="box">
              <?php
                $total_pending_orders = 0;
                  $select_pending_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                  $select_pending_orders->execute(['pending']);
                  while($fetch_pending_orders = $select_pending_orders->fetch(PDO::FETCH_ASSOC)){
                    $total_pending_orders += $fetch_pending_orders;
                  }    
                ?>

                <h3>total pending orders</h3>
                <p>Sh <?= $total_pending_orders; ?>/-</p>
          </div>

          <div class="box">
              <?php
                $total_paid_orders = 0;
                  $select_paid_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                  $select_paid_orders->execute(['paid']);
                  while($fetch_paid_orders = $select_paid_orders->fetch(PDO::FETCH_ASSOC)){
                    $total_paid_orders += $fetch_paid_orders;
                  }    
                ?>

                <h3>total paid orders</h3>
                <p>Sh <?= $total_paid_orders; ?>/-</p>
          </div>

            <div class="box">
              <?php
                $total_paid_orders = 0;
                  $select_paid_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                  $select_paid_orders->execute(['paid']);
                  while($fetch_paid_orders = $select_paid_orders->fetch(PDO::FETCH_ASSOC)){
                    $total_paid_orders += $fetch_paid_orders;
                  }    
                ?>

                <h3>total paid orders</h3>
                <p>Sh <?= $total_paid_orders; ?>/-</p>
          </div>

          <div class="box">
              <?php
                $total_failed_orders = 0;
                  $select_failed_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                  $select_failed_orders->execute(['failed']);
                  while($fetch_failed_orders = $select_failed_orders->fetch(PDO::FETCH_ASSOC)){
                    $total_paid_orders += $fetch_failed_orders;
                  }    
                ?>

                <h3>total failed orders</h3>
                <p>Sh <?= $total_failed_orders; ?>/-</p>
          </div>

          <div class="box">
            <?php
              $select_product = $conn->prepare("SELECT * FROM `products`");
              $select_product->execute();
              $number_of_product = $select_product->rowCount();
            ?>

          <h3>products added</h3>
          <p>Sh <?= $number_of_product; ?>/-</p>
          </div>

          <div class="box">
            <?php
              $select_users = $conn->prepare("SELECT * FROM `users`");
              $select_users->execute();
              $number_of_users = $select_users->rowCount();
            ?>

          <h3>users registerd</h3>
          <p><?= $number_of_users; ?></p>
          </div>

          <div class="box">
            <?php
              $select_messages = $conn->prepare("SELECT * FROM `messages`");
              $select_messages->execute();
              $number_of_messages = $select_messages->rowCount();
            ?>

          <h3>messages received</h3>
          <p><?= $number_of_messages; ?></p>
          </div>
        </div>
    </section>

    
</body>
</html>