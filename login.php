<?php

include 'config.php';

session_start();

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $password = filter_var($password,FILTER_SANITIZE_STRING);

    $select = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password_hash = ?");
    $select->execute([$email,$password]);
    $row = $select->fetch(PDO::FETCH_ASSOC);

    if($select->rowCount() > 0){
         if($row['user_type'] == 'admin'){
            $_SESSION['admin'] = $row['id'];
            header('location:admin/admin_dashboard.php');
         }elseif($row['user_type'] == 'user'){
            $_SESSION['user'] = $row['id'];
            header('location:index.php');
         }
    }else{
        echo 'wrong email or password';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- custom css file link -->
     <link rel="stylesheet" href="style.css">
     <!-- font awesome cdn link -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

    <title>login page</title>
</head>
<body>
    <section class="form-container">
        <form action="" method="post">
              <h3><i class="fas fa-smile"></i>welcome back!</h3>
            <input type="email" name="email" placeholder="enter your email" class="box">
            <input type="number" name="phone" placeholder="eg. +2547..." min="0" class="box">
            <input type="password" name="password" placeholder="enter your password" class="box" required>
            <span><a href="password_reset.php">Forgot password?</a></span>
            <input type="submit" name="submit" value="login now" class="btn">
            <p>don't have an account? <a href="register.php">register now</a></p>
        </form>
    </section>
</body>
</html>