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
    $product_quantity = $_POST['product_quantity'];
    $product_brands = $_POST['product_brands'];
    $product_price = $_POST['product_Price'];
    $product_status = 'true';

    // Accessing images
    $product_image1 = $_FILES['product_image1']['name'];

    // Image tmp name
    $temp_image1 = $_FILES['product_image1']['tmp_name'];

    // Check if empty
    if ($product_title == '' || $description == '' || $product_quantity == '' || $product_keywords == '' || $product_category == '' ||
        $product_brands == '' || $product_price == '' || $product_image1 == '') {
        echo "<script>alert('All fields required')</script>";
        exit();
    } else {
        move_uploaded_file($temp_image1, "./product_images/$product_image1");

        // Prepare insert query
        $stmt = $conn->prepare("INSERT INTO `products` (product_title, product_quantity, product_description,
        product_keywords, category_id, brand_id, product_image1,
        product_price, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");

        // Bind the parameters
        $stmt->bind_param("sissiisis", $product_title, $product_quantity, $description, $product_keywords, $product_category, $product_brands,
            $product_image1, $product_price, $product_status);

        // Execute the prepared statement
        $result_query = $stmt->execute();
        if ($result_query) {
            echo 'Item Added';
        } else {
            echo 'Error: ' . $stmt->error;
        }
    }
}
?>

<div class="container mt-3">
    <h1 class="text-center">Add Item</h1>
    <!-- add item form -->
    <form class="form-space" action="" method="post" enctype="multipart/form-data">
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
            <label for="product_image1" class="form-label">Item Image</label>
            <input type="file" name= "product_image1" id="product_image1" class="form-control"
            required="required">
        </div>

        <!-- Price -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_Price" class="form-label">Item Price</label>
            <input type="text" name= "product_Price" id="product_Price" class="form-control" placeholder="Enter item Price" autocomplete="off"
            required="required">
        </div>

        <!-- Quantity -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_quantity" class="form-label">Item Quantity</label>
            <input type="text" name= "product_quantity" id="product_quantity" class="form-control" placeholder="Enter quantity" autocomplete="off"
            required="required">
        </div>

        <!-- Add/Submit -->
        <div class="form-outline mb-4 w-50 m-auto d-flex justify-content-between">
            <input type="submit" name="insert_product" class="btn text-white main-color submit-item mb-3 px-3" value="Add Item">
        </div>
    </form>
</div>  