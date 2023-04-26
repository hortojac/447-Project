<?php
include('./includes/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//getting products
function getproducts(){
    global $conn;

    if(!isset($_GET['category'])){
        if(!isset($_GET['brand'])){
            $select_query="select * from `products` order by product_title LIMIT 0,9";
            $result_query=mysqli_query($conn,$select_query);
            // $row=mysqli_fetch_assoc($result_query);
            // echo $row['product_title'];
            while($row=mysqli_fetch_assoc($result_query)){
            $product_id=$row['product_id'];
            $product_title=$row['product_title'];
            $product_description=$row['product_description'];
            $product_image1=$row['product_image1'];
            $product_price=$row['product_price'];
            $category_id=$row['category_id'];
            $brand_id=$row['brand_id'];
            echo "
            <div class='col-md-4 mb-2'>
                <div class='card'>
                    <img src='admin/product_images/$product_image1' class='card-img-top' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'>$product_title</h5>
                        <p class='card-text'>$product_description</p>
                        <p class='card-text'>$$product_price</p>

                        <a href='main.php?add_to_cart=$product_id' class='btn btn-primary'>Add to cart</a>
                        <a href='#' class='btn btn-secondary'>More Info</a>
                    </div>
                </div>
            </div>";
            }
        }
    }
}

//getting all products
function get_all_products(){
    global $conn;

    if(!isset($_GET['category'])){
        if(!isset($_GET['brand'])){
            $select_query="select * from `products` order by rand()";
            $result_query=mysqli_query($conn,$select_query);
            // $row=mysqli_fetch_assoc($result_query);
            // echo $row['product_title'];
            while($row=mysqli_fetch_assoc($result_query)){
            $product_id=$row['product_id'];
            $product_title=$row['product_title'];
            $product_description=$row['product_description'];
            $product_image1=$row['product_image1'];
            $product_price=$row['product_price'];
            $category_id=$row['category_id'];
            $brand_id=$row['brand_id'];
            echo "
            <div class='col-md-4 mb-2'>
                <div class='card'>
                    <img src='admin/product_images/$product_image1' class='card-img-top' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'>$product_title</h5>
                        <p class='card-text'>$product_description</p>
                        <p class='card-text'>$$product_price</p>
                        <a href='main.php?add_to_cart=$product_id' class='btn btn-primary'>Add to cart</a>
                        <a href='#' class='btn btn-secondary'>More Info</a>
                    </div>
                </div>
            </div>";
            }
        }
    }
}


//get specific category
function get_unique_categories() {
    global $conn;
    if (isset($_GET['category'])) {
        $category_id = $_GET['category'];
        $select_query = "SELECT * FROM `products` WHERE category_id = ?";
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
                <div class='col-md-4 mb-2'>
                    <div class='card'>
                        <img src='admin/product_images/$product_image1' class='card-img-top' alt='...'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <p class='card-text'>$$product_price</p>
                            <a href='main.php?add_to_cart=$product_id' class='btn btn-primary'>Add to cart</a>
                            <a href='#' class='btn btn-secondary'>More Info</a>
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

//get specific brands
function get_unique_brand(){
    global $conn;
    if (isset($_GET['brand'])) {
        $brand_id = $_GET['brand'];
        $select_query = "SELECT * FROM `products` WHERE brand_id = ?";
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
                <div class='col-md-4 mb-2'>
                    <div class='card'>
                        <img src='admin/product_images/$product_image1' class='card-img-top' alt='...'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <p class='card-text'>$$product_price</p>
                            <a href='main.php?add_to_cart=$product_id' class='btn btn-primary'>Add to cart</a>
                            <a href='#' class='btn btn-secondary'>More Info</a>
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





//left nav bar brands
function getbrands(){
    global $conn;
    $select_brands="SELECT * FROM `brands`";
    $result_brands=mysqli_query($conn,$select_brands);
    // $row_data=mysqli_fetch_assoc($result_brands);
    // echo $row_data['brand_title'];
    while($row_data=mysqli_fetch_assoc($result_brands)){
      $brand_title=$row_data['brand_title'];
      $brand_id=$row_data['brand_id'];
      echo " <li class='nav-item'> <a href='main.php?brand=$brand_id' class='nav-link text-light'>$brand_title</a> </li>";
    }
}


//left nav bar categories
function getcategory(){
    global $conn;
    $select_categories="SELECT * FROM `categories`";
    $result_categories=mysqli_query($conn,$select_categories);
    while($row_data=mysqli_fetch_assoc($result_categories)){
    $category_title=$row_data['category_title'];
    $category_id=$row_data['category_id'];
    echo " <li class='nav-item'> <a href='main.php?category=$category_id' class='nav-link text-light'>$category_title</a> </li>";
    }
}

//search products
//getting products
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
    <div class='col-md-4 mb-2'>
        <div class='card'>
            <img src='admin/product_images/$product_image1' class='card-img-top' alt='...'>
            <div class='card-body'>
                <h5 class='card-title'>$product_title</h5>
                <p class='card-text'>$product_description</p>
                <p class='card-text'>$$product_price</p>
                <a href='main.php?add_to_cart=$product_id' class='btn btn-primary'>Add to cart</a>
                <a href='#' class='btn btn-secondary'>More Info</a>
            </div>
        </div>
    </div>";
    }
}

//get ip address function
function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
//whether ip is from the remote address  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  

// $ip = getIPAddress();  
// echo 'User Real IP Address - '.$ip;



//cart function
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

//cart item number
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

?>


