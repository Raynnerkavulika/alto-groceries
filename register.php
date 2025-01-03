<?php
 include 'config.php';


 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;

 require 'vendor/autoload.php'; // Path to Composer autoloader

 if(isset($_POST['submit'])){
    $name = trim($_POST['name']);
    $name = filter_var($name,FILTER_SANITIZE_STRING);
    $email = trim($_POST['email'])?: null;
    $email = filter_var($email,FILTER_SANITIZE_STRING);
    $phone = trim($_POST['phone']) ?: null;
    $phone = filter_var($phone,FILTER_SANITIZE_STRING);
    $password = trim($_POST['password']);
    $password = filter_var($password,FILTER_SANITIZE_STRING);
    $cpassword = trim($_POST['cpassword']);
    $cpassword = filter_var($cpassword,FILTER_SANITIZE_STRING);

    //validate inputs
    if(empty($name) || empty($password)){
       $message[] = "name and password fields are required";
    }if(!$email && !$password){
        $message[] = "Atleast one of email or phone number number should be provided";
    }if($phone && !preg_match('/^\d{10,15}$/',$phone)){
        $message[] = "invalid phone number";
    }if($password != $cpassword){
        $message[] = "confirm your passwords does not match";
    }

    //check if the user exist

    $select_user = $conn->prepare("SELECT id FROM `users` WHERE email = ? OR phone = ?");
    $select_user->execute([$email,$phone]);

    if($select_user->rowCount() > 0){
        $message[] = "user already exist";
    }

    //handle the image upload

    $image_path = null; //default to null meaning no image uploaded
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0 ){
       $allowedTypes = ['image/jpeg','image/jpg','image/png','image/gif'];
       $fileType = $_FILES['image']['type'];
       $fileSize = $_FILES['image']['size'];
       $maxFileSize = 2 * 1024 * 1024; //2MB maximum file size
       $uploadDir = 'upload/images/';

       if(!in_array($fileType,$allowedTypes)){
        $message[] = "invalid image type only PNG,JPEG,JPG,GIF are allowed";
       }if($fileSize > $maxFileSize){
        $message[] = "Image size exceeds the maximum limit of 2MB";
       }

       //Generate unique file name to avoid conflicts

       $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
          $image_path = $uploadDir . $imageName;

          //move uploaded file to server
          if(!move_uploaded_file($_FILES['image']['tmp_name'],$image_path)){
             $message[] = "failed to upload image";
          }
       }


        // Generate a unique token and verification code
    $token = bin2hex(random_bytes(16)); // Random token for email verification
    $verification_code = rand(100000, 999999); // Random 6-digit verification code

    // Set the token expiry time (e.g., 1 hour)
    $token_expiry = time() + 3600; // 1 hour from now
       //insert new user with a verification token and a profile image
       $insert_user = $conn->prepare("INSERT INTO `users`(name,email,phone,password_hash,token,image, verification_code, token_expiry,verified) VALUES(?,?,?,?,?,?,?,?,0)");
       if($insert_user->execute([$name,$email,$phone,$password,$token,$image_path, $verification_code, $token_expiry])){

       //sending verification email or sms
       if($email){
        sendVerificationEmail($email,$verification_code);
        $message[] = "Registration successful,please check your email to verify your account";
       }

        // After registering the user, redirect to the verification page with the token
    header("Location: verify.php?token=" . urlencode($token));
    exit();
    }else{
        $message[] = "could not register";
    }
}

//   function to send verification email

function sendVerificationEmail($email,$verification_code){
  $mail = new PHPMailer(true);
  try{

     //Server settings
     $mail->isSMTP(); 
     $mail->Host       = 'smtp.gmail.com'; 
     $mail->SMTPAuth   = true; 
     $mail->Username   = 'lorem.ipsum.sample.email@gmail.com';
     $mail->Password   = 'novtycchbrhfyddx';
     $mail->SMTPSecure = 'ssl';
     $mail->Port       = 465;    

    $mail->setFrom('kavulikar@gmail.com','Alto groceries');
    $mail->addAddress($email);
    $mail->addReplyTo('kavulikar@gmail.com', 'Alto groceries'); 


        //Content
        $mail->isHTML(true);  
        $mail->Subject = 'Verification Code';
        $mail->Body    = 'Your verification code is: ' .$verification_code; 

        $mail->send();


    } catch (Exception $e) {
        echo "Error: " . $mail->ErrorInfo;
    }
}



// Function to send verification SMS (simulated)
// function sendVerificationSMS($phone, $token) {
//     // Assuming you have an SMS service provider like Twilio
//     $message = "Your verification code is: $token";
//     $api_url = "https://sms-provider.com/send?to=$phone&message=" . urlencode($message);
//     $response = file_get_contents($api_url);
// }

 

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

    <title>register page</title>
</head>
<body>
    <section class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
              <h3><i class="fas fa-user-plus"></i>create an account</h3>
            <input type="text" name="name" placeholder="enter your username" class="box" required>
            <input type="email" name="email" placeholder="enter your email" class="box">
            <input type="number" name="phone" placeholder="eg. +2547..." min="0" class="box">
            <input type="password" name="password" placeholder="enter your password" class="box" required>
            <input type="password" name="cpassword" placeholder="confirm your password" class="box" required>
            <input type="file" name="image" accept="image/png,image/jpeg,image/jpg" class="box">
            <input type="submit" name="submit" value="register now" class="btn">
            <p>already have an account? <a href="login.php">login now</a></p>
        </form>
    </section>
</body>
</html>