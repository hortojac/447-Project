<?php
  session_start();
  require_once('./includes/connect.php');
  include('./functions/common_functions.php');

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  // retrieve the first name and admin rights of the logged-in user
  if(isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $query = "SELECT first_name, admin_rights FROM accounts WHERE email = '$email'";
    $result = $conn->query($query);
    if($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $first_name = $row['first_name'];
      $admin_rights = $row['admin_rights'];
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="icon" href="./images/logo.png" class="">
    <!--bootstrap-->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!--font links-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- css -->
    <link rel="stylesheet" href="style.css">
    <style>
      .cart_img {
        width: 80px;
        height: 80px;
        object-fit: contain;
      }
      .nav-link:hover {
        color: #000000;
      }
      .text-color {
        color: #ffffff;
      }
      .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        box-sizing: border-box;
      }
      .main-color {
        background-color: #1b4d89;
      }
      .second-color {
        background-color: #e63030;
      }
      .no-hover:hover {
        color: #ffffff;
        cursor: default;
      }
      button:hover {
        opacity: 0.8;
      }
      .submit-item:hover {
        background-color: #6c757d;
      }
    </style>
</head>
<body>
  <!--navbar-->
  <div class="container-fluid p-0">
    <!-- firstchild -->
    <nav class="navbar navbar-expand-lg navbar-light main-color">
      <div class="container-fluid">
        <img src="images/logo.png" alt="" class="logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            <li class="nav-item">
              <a class="nav-link text-color" aria-current="page" href="main.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-color" href="display_all.php">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-color" href="#">Support</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-color" href="cart.php"><i class="fa-sharp fa-solid fa-cart-shopping"></i><sup><?php cart_item(); ?></sup></a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-color" href="#">Total: $<?php total_cart_price(); ?></a>
            </li>
          </ul>
          <form class="d-flex" action="search_product.php" method="get">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
            <!-- <button class="btn btn-outline-light" type="submit">Search</button> -->
            <input type="submit" value ="Search" class="btn btn-outline-light" name="search_data_product">
          </form>
        </div>
      </div>
    </nav>

    <!-- calling cart function -->
    <?php cart(); ?>

    <!-- second child -->
    <nav class="navbar navbar-expand-lg navbar-light second-color">
      <div class="container-fluid">
        <div class="navbar-brand mx-auto text-color no-hover"><h3>Cart</h3></div>
        <div class="d-flex">
          <?php if(isset($_SESSION['email']) && isset($first_name)) { ?>
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a href="#" class="nav-link text-color no-hover">Welcome <?php echo $first_name; ?></a>
              </li>
              <?php if($admin_rights == 'yes') { ?>
                <li class="nav-item">
                  <a href="./admin/index.php" class="nav-link text-color">Admin</a>
                </li>
              <?php } ?>
              <li class="nav-item">
                <a href="./user_area/logout.php" class="nav-link text-color">Logout</a>
              </li>
            </ul>
          <?php } else { ?>
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a href="#" class="nav-link text-color no-hover">Welcome Guest</a>
              </li>
              <li class="nav-item">
                <a href="./user_area/user_login.php" class="nav-link text-color">Login</a>
              </li>
            </ul>
          <?php } ?>
        </div>
      </div>
    </nav>

    <!-- third child -->
    <div class="container">
        <div class="row">
            <form action="" method="post" id="cartForm"> 
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Remove</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        global $conn;
                        $get_ip_add = getIPAddress();
                        $total_price = 0;

                        $cart_query = "SELECT * FROM cart_details WHERE ip_address = ?";
                        $cart_statement = mysqli_prepare($conn, $cart_query);
                        mysqli_stmt_bind_param($cart_statement, "s", $get_ip_add);
                        mysqli_stmt_execute($cart_statement);

                        $cart_results = mysqli_stmt_get_result($cart_statement);
                        while ($cart_row = mysqli_fetch_array($cart_results)) {
                            $product_id = $cart_row['product_id'];
                            $products_query = "SELECT * FROM products WHERE product_id = ?";
                            $products_statement = mysqli_prepare($conn, $products_query);
                            mysqli_stmt_bind_param($products_statement, "i", $product_id);
                            mysqli_stmt_execute($products_statement);

                            $product_results = mysqli_stmt_get_result($products_statement);
                            while ($product_row = mysqli_fetch_array($product_results)) {
                                $product_price = $product_row['product_price'];
                                $product_title = $product_row['product_title'];
                                $product_image1 = $product_row['product_image1'];
                                $quantity = $cart_row['quantity'];
                                $total_price += $product_price * $quantity;
                                echo 
                                "<tr>
                                    <td><img src='admin/product_images/$product_image1' alt='' class='cart_img' /></td>
                                    <td>$product_title</td>
                                    <td><input type='text' name='qty[]' value='$quantity' placeholder='' class='form-control w-25 mx-auto'></td>
                                    <td>$" . $product_price . "</td>";

                                    if (isset($_POST['update_cart'])) {
                                        $quantities = $_POST['qty'];
                                        $product_ids = $_POST['product_id'];
                                        $total_price = 0;
                                    
                                        for ($i = 0; $i < count($quantities); $i++) {
                                            $update_cart = "UPDATE cart_details SET quantity = ? WHERE product_id = ? AND ip_address = ?";
                                            $update_statement = mysqli_prepare($conn, $update_cart);
                                            mysqli_stmt_bind_param($update_statement, "iis", $quantities[$i], $product_ids[$i], $get_ip_add);
                                            mysqli_stmt_execute($update_statement);
                                            $total_price += $product_price * $quantities[$i]; // Update the total price for each updated quantity
                                        }
                                    }                                    
                                echo
                                "<td><input type='checkbox' name='removeItem[]' value='$product_id'></td>
                                <td>
                                <input type='submit' value='Update Quantity' class='button bg-warning p-2 border-2 m-1' name='update_cart'>
                                <input type='hidden' name='product_id[]' value='$product_id'>
                                    <input type='submit' value='Remove' class='bg-danger p-2 border-2 m-1' name='remove_cart'>
                                </td>
                                </tr>";             
                            }
                          }
                      ?>
                  </tbody>
              </table>
          </form>
          <!-- subtotal -->
          <div class="d-flex flex-row-reverse mb-5">
            <a href="main.php"><button class="main-color text-color submit-item p-2 border-2 m-1">Continue Shopping</button></a>
            <a href="#"><button class="main-color text-color submit-item p-2 border-2 m-1">Checkout</button></a>
            <h4 class="px-3 text-end m-1">Subtotal: $<strong class="text-success"><?php echo $total_price; ?></strong></h4>
          </div>
      </div>
  </div>

  <!-- function to remove item -->
  <?php
    function remove_cart_item(){
        global $conn;
        if(isset($_POST['remove_cart'])){
            foreach($_POST['removeItem'] as $remove_id){
                echo $remove_id;
                $delete_query="Delete from `cart_details` where product_id=$remove_id";
                $run_delete=mysqli_query($conn,$delete_query);
                if($run_delete){
                    echo "<script>window.open('cart.php','_self')</script>";
                }
            }
        }
    }
    echo $remove_item=remove_cart_item();
  ?>
  <!-- last child -->
  <div class="main-color p-3 text-center footer">
      <p class="text-color">By Bikash and Jacob</p>
  </div> 
</div>
    <!--bootstrap js link-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>