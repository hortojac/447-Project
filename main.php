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
    <title>iBuy</title>
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
      .nav-link:hover {
        color: #000000;
      }
      .text-color {
        color: #ffffff;
      }
      .footer {
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
      .side-nav:hover {
        background-color: #6c757d;
      }
      .btn-cart {
        background-color: #1b4d89;
        color: #ffffff;
      }
      .btn-info {
        background-color: #6c757d;
        color: #ffffff;
      }
      .btn-cart:focus, .btn-info:active {
        outline: none;
      }
      .btn-info:hover, .btn-cart:hover {
        opacity: 0.8;
      }
      .no-hover:hover {
        color: #ffffff;
        cursor: default;
      }
      .card-img-top{
        height: 200px;
        margin-top: 10px;
        object-fit: contain;
      }
      .logo{
        width: 7%;
        height: 7%;
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
              <input type="submit" value ="Search" class="btn btn-outline-light" style="width:100px;" name="search_data_product">
            </form>
          </div>
      </div>
    </nav>

    <!-- calling cart function -->
    <?php cart(); ?>

    <!-- second child -->
    <nav class="navbar navbar-expand-lg navbar-light second-color">
      <div class="container-fluid">
        <div class="navbar-brand mx-auto text-color no-hover"><h3>Products</h3></div>
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
    <div class="row">
      <div class="col-md-2 bg-light p-0">
        <!-- Categories -->
        <ul class="navbar-nav me-auto text-center" style="overflow: hidden;">
          <li class="bg-dark text-color">
            <h4>Categories</h4>
          </li>

          <?php
          getcategory();
          ?>
        </ul>

        <!-- Brands -->
        <ul class="navbar-nav me-auto text-center" style="overflow: hidden;">
          <li class="bg-dark text-color">
            <h4>Brands</h4>
          </li>

          <?php
          getbrands();
          ?>
        </ul>
      </div>

      <div class="col-md-10">
        <!-- products -->
        <div class="row">
          <!-- Getting items from database -->
          <?php
          getproducts();
          get_unique_categories();   
          get_unique_brand(); 
          ?>
          <!-- row end -->
        </div>
        <!-- col end -->
      </div>
    </div>
    
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