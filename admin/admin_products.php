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
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = 'upload\images/'.$image;

    $select_product = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_product->execute([$name]);

    if($select_product->rowCount() > 0){
        $message[] = 'product name already exist';
    }else{
        $insert_product = $conn->prepare("INSERT INTO `products`() VALUES()");
        $insert_product->execute();
    }

    
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
        <input type="submit" class="btn" value="add product" name="add_product">
    </form>
</section>

<section class="show-product">
    <h3 class="title">show added products</h3>

    <?php 
       $show_product = $conn->prepare("SELECT * FROM `products`");
       $show_product->execute();
       if($show_product->rowCount()){
        while($fetch_product = $show_product->fetch(PDO::FETCH_ASSOC)){      
    ?>
        <div class="box">
            <div class="price"><?= $fetch_product['price']; ?></div>
            <img src="upload\images\<?= $fetch_product['image'] ?>" alt="">
            <div class="name"><?= $fetch_product['name']; ?></div>
            <div class="category"><?= $fetch_product['category']; ?></div>
            <div class="details"><?= $fetch_product['details']; ?></div>
            <div class="flex-btn">
                <a href="admin_update_products.php?update=<?= $fetch_product['id']; ?>" class="btn">update</a>
                <a href="admin_products.php?delete=<?= $fetch_product['id']; ?>" class="delete-btn">delete</a>
            </div>
        </div>
    <?php  
        }
        }else{
        echo '<p class="empty">no products has been added yet!</p>';
        } 
    ?>
</section>
</body>
</html>