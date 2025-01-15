<?php 
include '../config.php';

session_start();

if(isset($_POST['add_product'])){
    $name = $_POST['name'];
    $name = filter_var($name,FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price,FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category,FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details,FILTER_SANITIZE_STRING);


    $image = $_FILES['image']['name'];
    
    
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin products</title>

    <!-- custom css file link -->
    <link rel="stylesheet" href="../style.css">
    <!-- font awesome cdn link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>
<body>
    

  <!-- admin header -->

  <?php include 'admin_header.php'; ?>

  
<section class="add-products">
    <h3 class="title">add a product</h3>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="flex">

            <div class="inputbox">
                <input type="text" name="name" required placeholder="enter product name" class="box">
                <input type="number" required name="price" min="0" class="box" placeholder="enter product price">
            </div>

            <div class="inputbox">
                <select name="category" id="" required class="box">
                    <option value="fruits">fruits</option>
                    <option value="vegetables">vegetables</option>
                    <option value="cereals">cereals</option>
                    <option value="meat">meat</option>
                    <option value="fish">fish</option>
                </select>
                <input type="file" name="image" accept="image/png,image/jpeg,image/jpg" required class="box">
            </div>
        </div>
        <textarea name="details" class="box" placeholder="enter product details" required></textarea>
        <input type="submit" class="btn" name="add_product">
    </form>
</section>
</body>
</html>