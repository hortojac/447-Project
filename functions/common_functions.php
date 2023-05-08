<?php
include('./includes/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// getting products
function getproducts(){
    global $conn;
    if(!isset($_GET['category'])){
        if(!isset($_GET['brand'])){
            $select_query="select * from `products` order by product_title LIMIT 0,9";
            $result_query=mysqli_query($conn,$select_query);
            
            while($row=mysqli_fetch_assoc($result_query)){
            $product_id=$row['product_id'];
            $product_title=$row['product_title'];
            $product_description=$row['product_description'];
            $product_image1=$row['product_image1'];
            $product_price=$row['product_price'];
            $category_id=$row['category_id'];
            $brand_id=$row['brand_id'];
            echo "
            <div class='col-md-4 mb-2 mt-2'>
                <div class='card h-100'>
                    <img src='admin/product_images/$product_image1' class='card-img-top' alt='...'>
                    <div class='card-body d-flex flex-column'>
                        <h5 class='card-title'>$product_title</h5>
                        <p class='card-text flex-grow-1'>$product_description</p>
                        <div class='mt-auto d-flex justify-content-between'>  
                            <p class='card-text'>$$product_price</p>
                            <div>
                                <a href='main.php?add_to_cart=$product_id' class='btn btn-light btn-cart mr-2'>Add to cart</a>
                                <a href='#' class='btn btn-light btn-info'>More Info</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
            }
        }
    }
}

// getting all products
function get_all_products(){
    global $conn;

    if(!isset($_GET['category'])){
        if(!isset($_GET['brand'])){
            $select_query="select * from `products` order by rand()";
            $result_query=mysqli_query($conn,$select_query);
            
            while($row=mysqli_fetch_assoc($result_query)){
            $product_id=$row['product_id'];
            $product_title=$row['product_title'];
            $product_description=$row['product_description'];
            $product_image1=$row['product_image1'];
            $product_price=$row['product_price'];
            $category_id=$row['category_id'];
            $brand_id=$row['brand_id'];
            echo "
            <div class='col-md-4 mb-2 mt-2'>
                <div class='card h-100'>
                    <img src='admin/product_images/$product_image1' class='card-img-top' alt='...'>
                    <div class='card-body d-flex flex-column'>
                        <h5 class='card-title'>$product_title</h5>
                        <p class='card-text flex-grow-1'>$product_description</p>
                        <div class='mt-auto d-flex justify-content-between'>  
                            <p class='card-text'>$$product_price</p>
                            <div>
                                <a href='main.php?add_to_cart=$product_id' class='btn btn-light btn-cart mr-2'>Add to cart</a>
                                <a href='#' class='btn btn-light btn-info'>More Info</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
            }
        }
    }
}

// get specific category using JOIN
function get_unique_categories() {
    global $conn;
    if (isset($_GET['category'])) {
        $category_id = $_GET['category'];
        $select_query = "SELECT * FROM `products` 
                         JOIN `categories` ON products.category_id = categories.category_id 
                         WHERE products.category_id = ?";
        $stmt = mysqli_prepare($conn, $select_query);
        mysqli_stmt_bind_param($stmt, "i", $category_id);
        mysqli_stmt_execute($stmt);
        $result_query = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result_query) > 0) {
            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                $category_id = $row['category_id'];
                $brand_id = $row['brand_id'];
                echo "
                <div class='col-md-4 mb-2 mt-2'>
                    <div class='card h-100'>
                        <img src='admin/product_images/$product_image1' class='card-img-top' alt='...'>
                        <div class='card-body d-flex flex-column'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text flex-grow-1'>$product_description</p>
                            <div class='mt-auto d-flex justify-content-between'>  
                                <p class='card-text'>$$product_price</p>
                                <div>
                                    <a href='main.php?add_to_cart=$product_id' class='btn btn-light btn-cart mr-2'>Add to cart</a>
                                    <a href='#' class='btn btn-light btn-info'>More Info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>No stock in this category</div>";
        }

        mysqli_stmt_close($stmt);
    }
}

// get specific brands
function get_unique_brand(){
    global $conn;
    if (isset($_GET['brand'])) {
        $brand_id = $_GET['brand'];
        $select_query = "SELECT products.* FROM `products`
                         JOIN `brands` ON products.brand_id = brands.brand_id
                         WHERE products.brand_id = ?";
        $stmt = mysqli_prepare($conn, $select_query);
        mysqli_stmt_bind_param($stmt, "i", $brand_id);
        mysqli_stmt_execute($stmt);
        $result_query = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result_query) > 0) {
            while ($row = mysqli_fetch_assoc($result_query)) {
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                $category_id = $row['category_id'];
                $brand_id = $row['brand_id'];
                echo "
                <div class='col-md-4 mb-2 mt-2'>
                    <div class='card h-100'>
                        <img src='admin/product_images/$product_image1' class='card-img-top' alt='...'>
                        <div class='card-body d-flex flex-column'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text flex-grow-1'>$product_description</p>
                            <div class='mt-auto d-flex justify-content-between'>  
                                <p class='card-text'>$$product_price</p>
                                <div>
                                    <a href='main.php?add_to_cart=$product_id' class='btn btn-light btn-cart mr-2'>Add to cart</a>
                                    <a href='#' class='btn btn-light btn-info'>More Info</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>No stock for this brand</div>";
        }
        mysqli_stmt_close($stmt);
    }
}

// left nav bar brands
function getbrands(){
    global $conn;
    $select_brands="SELECT * FROM `brands`";
    $result_brands=mysqli_query($conn,$select_brands);

    while($row_data=mysqli_fetch_assoc($result_brands)){
      $brand_title=$row_data['brand_title'];
      $brand_id=$row_data['brand_id'];
      echo " <li class='nav-item'> <a href='main.php?brand=$brand_id' class='nav-link side-nav'>$brand_title</a> </li>";
    }
}

// left nav bar categories
function getcategory(){
    global $conn;
    $select_categories="SELECT * FROM `categories`";
    $result_categories=mysqli_query($conn,$select_categories);
    while($row_data=mysqli_fetch_assoc($result_categories)){
    $category_title=$row_data['category_title'];
    $category_id=$row_data['category_id'];
    echo " <li class='nav-item'> <a href='main.php?category=$category_id' class='nav-link side-nav'>$category_title</a> </li>";
    }
}

// search products
function search_product(){
    global $conn;
    if(isset($_GET['search_data_product'])){
        $search_data_value=$_GET['search_data'];
    }
    $search_query = "SELECT * FROM `products` WHERE product_keywords LIKE '%$search_data_value%' OR product_title LIKE '%$search_data_value%'
    OR product_description LIKE '%$search_data_value%'";
    $result_query = mysqli_query($conn, $search_query);    
    if (mysqli_num_rows($result_query)==0){
        echo "<div class='alert alert-danger' role='alert'>No results</div>";
    }
    
    while($row=mysqli_fetch_assoc($result_query)){
    $product_id=$row['product_id'];
    $product_title=$row['product_title'];
    $product_description=$row['product_description'];
    $product_image1=$row['product_image1'];
    $product_price=$row['product_price'];
    $category_id=$row['category_id'];
    $brand_id=$row['brand_id'];
    echo "
    <div class='col-md-4 mb-2 mt-2'>
        <div class='card h-100'>
            <img src='admin/product_images/$product_image1' class='card-img-top' alt='...'>
            <div class='card-body d-flex flex-column'>
                <h5 class='card-title'>$product_title</h5>
                <p class='card-text flex-grow-1'>$product_description</p>
                <div class='mt-auto d-flex justify-content-between'>  
                    <p class='card-text'>$$product_price</p>
                    <div>
                        <a href='main.php?add_to_cart=$product_id' class='btn btn-light btn-cart mr-2'>Add to cart</a>
                        <a href='#' class='btn btn-light btn-info'>More Info</a>
                    </div>
                </div>
            </div>
        </div>
    </div>";
    }
}

// get ip address function
function getIPAddress() {  
    // if ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    // if ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
// if ip is from the remote address  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  

// cart function
function cart(){
    if(isset($_GET['add_to_cart'])){
        global $conn;
        $get_ip_add = getIPAddress();
        $get_product_id=$_GET['add_to_cart'];
        $select_query="Select * from `cart_details` where ip_address='$get_ip_add' and product_id=$get_product_id";
        $result_query = mysqli_query($conn,$select_query);
        if (mysqli_num_rows($result_query)>0){
            echo "<script>alert('Item already in cart')</script>";
            echo "<script>window.open('main.php','_self')</script>";
        }else{
            $insert_query="insert into `cart_details` (product_id,ip_address, quantity) values ($get_product_id,'$get_ip_add',1)";
            $result_insert = mysqli_query($conn, $insert_query);
            echo "<script>alert('Item added to cart')</script>";
            echo "<script>window.open('main.php','_self')</script>";
        }
    }
}

// cart item number
function cart_item(){
    if(isset($_GET['add_to_cart'])){
        global $conn;
        $get_ip_add = getIPAddress();
        $select_query="Select * from `cart_details` where ip_address='$get_ip_add'";
        $result_query = mysqli_query($conn,$select_query);
        $count_cart_items=mysqli_num_rows($result_query);
    }else{
        global $conn;
        $get_ip_add = getIPAddress();
        $select_query="Select * from `cart_details` where ip_address='$get_ip_add'";
        $result_query = mysqli_query($conn,$select_query);
        $count_cart_items=mysqli_num_rows($result_query);
    }
    echo $count_cart_items;
}

// total price
function total_cart_price(){
    global $conn;
    $get_ip_add = getIPAddress();
    $total_price=0;

    $cart_query = "SELECT * FROM cart_details WHERE ip_address = ?";
    $cart_statement = mysqli_prepare($conn, $cart_query);
    mysqli_stmt_bind_param($cart_statement, "s", $get_ip_add);
    mysqli_stmt_execute($cart_statement);

    $cart_results = mysqli_stmt_get_result($cart_statement);
    while($cart_row = mysqli_fetch_array($cart_results)){
        $product_id = $cart_row['product_id'];

        $products_query = "SELECT * FROM products WHERE product_id = ?";
        $products_statement = mysqli_prepare($conn, $products_query);
        mysqli_stmt_bind_param($products_statement, "i", $product_id);
        mysqli_stmt_execute($products_statement);

        $product_results = mysqli_stmt_get_result($products_statement);
        while($product_row = mysqli_fetch_array($product_results)){
            $product_price = $product_row['product_price'];
            $total_price += $product_price;
        }
    }
    echo $total_price;
}


