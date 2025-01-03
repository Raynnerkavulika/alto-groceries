<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin products</title>
</head>
<body>
    
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