<?php
require_once('../includes/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_POST['insert_product'])) {
    $product_title = $_POST['product_title'];
    $description = $_POST['description'];
    $product_keywords = $_POST['product_keywords'];
    $product_category = $_POST['product_categories'];
    $product_brands = $_POST['product_brands'];
    $product_price = $_POST['product_Price'];
    $product_status = 'true';

    // Accessing images
    $product_image1 = $_FILES['product_image1']['name'];
    $product_image2 = $_FILES['product_image2']['name'];
    $product_image3 = $_FILES['product_image3']['name'];

    // Image tmp name
    $temp_image1 = $_FILES['product_image1']['tmp_name'];
    $temp_image2 = $_FILES['product_image2']['tmp_name'];
    $temp_image3 = $_FILES['product_image3']['tmp_name'];

    // Check if empty
    if ($product_title == '' || $description == '' || $product_keywords == '' || $product_category == '' ||
        $product_brands == '' || $product_price == '' || $product_image1 == '' || $product_image2 == '' || $product_image3 == '') {
        echo "<script>alert('All fields required')</script>";
        exit();
    } else {
        move_uploaded_file($temp_image1, "./product_images/$product_image1");
        move_uploaded_file($temp_image2, "./product_images/$product_image2");
        move_uploaded_file($temp_image3, "./product_images/$product_image3");

        // Prepare insert query
        $stmt = $conn->prepare("INSERT INTO `products` (product_title, product_description,
        product_keywords, category_id, brand_id, product_image1, product_image2, product_image3,
        product_price, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");

        // Bind the parameters
        $stmt->bind_param("sssiisssis", $product_title, $description, $product_keywords, $product_category, $product_brands,
            $product_image1, $product_image2, $product_image3, $product_price, $product_status);

        // Execute the prepared statement
        $result_query = $stmt->execute();
        if ($result_query) {
            echo 'Item Added';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Insert Products</title>


    <!-- bootstrap css link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

     <!-- font awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- css file -->
<link rel="stylesheet" href="../style.css">

</head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Add Item</h1>
        <!-- add item form -->
        <form action="" method="post" enctype="multipart/form-data">
            <!-- title -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Item Name</label>
                <input type="text" name= "product_title" id="product_title" class="form-control" placeholder="Enter item name" autocomplete="off"
                required="required">
            </div>

            <!-- description -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="description" class="form-label">Item Description</label>
                <input type="text" name= "description" id="description" class="form-control" placeholder="Enter item description" autocomplete="off"
                required="required">
            </div>

            <!-- Keywords -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_keywords" class="form-label">Item Keywords</label>
                <input type="text" name= "product_keywords" id="product_keywords" class="form-control" placeholder="Enter item Keywords" autocomplete="off"
                required="required">
            </div>

            <!-- Categories -->
            <div class="form-outline mb-4 w-50 m-auto">
                <select name="product_categories" id="" class="form-select">
                    <option value="">Select Category</option>
                    <?php
                    $select_categories="SELECT * FROM `categories`";
                    $result_categories=mysqli_query($conn,$select_categories);
                    while($row_data=mysqli_fetch_assoc($result_categories)){
                        $category_title=$row_data['category_title'];
                        $category_id=$row_data['category_id'];
                        echo "<option value='{$category_id}'>{$category_title}</option>";
                    }
                    ?>
                </select>
            </div>


             <!-- Brands -->
             <div class="form-outline mb-4 w-50 m-auto">
                <select name="product_brands" id="" class="form-select">
                    <option value="">Select Brand</option>
                    <?php
                    $select_brands="SELECT * FROM `brands`";
                    $result_brands=mysqli_query($conn,$select_brands);
                    while($row_data=mysqli_fetch_assoc($result_brands)){
                        $brand_title=$row_data['brand_title'];
                        $brand_id=$row_data['brand_id'];
                        echo "<option value='{$brand_id}'>{$brand_title}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Image1 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image1" class="form-label">Item Image 1</label>
                <input type="file" name= "product_image1" id="product_image1" class="form-control"
                required="required">
            </div>

            <!-- Image2 -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image2" class="form-label">Item Image 1</label>
                <input type="file" name= "product_image2" id="product_image2" class="form-control"
                required="required">
            </div>

              <!-- Image3 -->
              <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image3" class="form-label">Item Image 1</label>
                <input type="file" name= "product_image3" id="product_image3" class="form-control"
                required="required">
            </div>

            <!-- Price -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_Price" class="form-label">Item Price</label>
                <input type="text" name= "product_Price" id="product_Price" class="form-control" placeholder="Enter item Price" autocomplete="off"
                required="required">
            </div>

            <!-- Add/Submit -->
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="insert_product" class="btn btn-info mb-3 px-3" value="Add Item">
            </div>


        </form>


    </div>
    
</body>
</html>