<?php
  session_start();
  require_once('../includes/connect.php');

  // retrieve the first name and admin rights of the logged-in user
  if(isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $query = "SELECT first_name, user_image FROM accounts WHERE email = '$email'";
        $result = $conn->query($query);
        if($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $first_name = $row['first_name'];
            $user_image = $row['user_image'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="../images/logo.png" class="">

    <!-- bootstrap css link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

     <!-- font awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css file -->
    <link rel="stylesheet" href="../style.css">
    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            box-sizing: border-box;
        }
        .text-color {
            color: #ffffff;
        }
        .main-color {
            background-color: #1b4d89;
        }
        .second-color {
            background-color: #e63030;
        }
        .btn-text-color {
            color: #000000;
        }
        button:hover {
			opacity: 0.8;
		}
        .submit-item:hover {
            background-color: #6c757d;
        }
        .text-end {
            margin-top: 1vw;
            margin-right: 1.5vw;
        }
        .admin-image{
            width: 100px;
            object-fit: contain;
        }
        .admin-image:hover {
            cursor: default;
        }
        .form-space {
            margin-bottom: 10vh;
        }
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        .delete-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <!--navbar -->
    <div class="container-fluid p-0">
        <!-- First child -->
        <nav class="navbar navbar-expand-lg navbar-light main-color">
            <div class="container-fluid">
                <img src="../images/logo.png" alt="" class="logo">
                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav ">
                        <li class="nav-item">
                            <button><a href="../user_area/logout.php" class="nav-link btn-light btn-text-color">Logout</a></button>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>
        <!-- second child -->
        <div class="second-color py-2">
            <div class="container">
                <h3 class="text-center text-color">Management Settings</h3>
            </div>
        </div>

        <!-- third child -->
        <div class="row">
            <div class="col-md-12 bg-secondary p-1 d-flex align-items-center">
                <!-- management buttons -->
                <div class="col-md text-center">
                    <button><a href="../main.php" class="btn btn-light btn-text-color">Home</a></button>
                    <button><a href="index.php?insert_item" class="btn btn-light btn-text-color">Add Items</a></button>
                    <button><a href="index.php?all_products" class="btn btn-light btn-text-color">View Items</a></button>
                    <button><a href="index.php?insert_category" class="btn btn-light btn-text-color">Add Category</a></button>
                    <button><a href="index.php?edit_cat" class="btn btn-light btn-text-color">View Categories</a></button>
                    <button><a href="index.php?insert_brand" class="btn btn-light btn-text-color">Add Brands</a></button>
                    <button><a href="index.php?edit_brand" class="btn btn-light btn-text-color">View Brands</a></button>
                    <button><a href="" class="btn btn-light btn-text-color">Orders</a></button>
                    <button><a href="" class="btn btn-light btn-text-color">Payments</a></button>
                    <button><a href="index.php?get_users" class="btn btn-light btn-text-color">All Users</a></button>
                </div>
                <!-- image section -->
                <div class="col-md-auto text-end">
                    <div class="d-flex flex-column align-items-center">
                        <?php 
                            if(isset($_SESSION['email']) && isset($first_name) && isset($user_image)) { 
                            echo '<a href="#"><img src="../user_area/profile/'.$user_image.'" alt="" class="admin-image"></a>';
                            echo '<p class="text-color">Admin: '.$first_name.'</p>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- fourth child add category/brand-->
        <div class="container  my-5">
            <?php
                if(isset($_GET['insert_category'])){
                    include('insert_categories.php');
                }
                if(isset($_GET['insert_brand'])){
                    include('insert_brands.php');
                }
                if(isset($_GET['insert_item'])){
                    include('insert_product.php');
                }
                if(isset($_GET['edit_cat'])){
                    include('viewCat.php');
                }
                if(isset($_GET['edit_brand'])){
                    include('viewBrand.php');
                }
                if(isset($_GET['all_products'])){
                    include('viewItems.php');
                }
                if(isset($_GET['get_users'])){
                    include('viewUsers.php');
                }
            ?>
        </div>
        <!-- last child -->
        <div class="main-color p-3 text-center footer">
            <p class="text-color">By Bikash and Jacob</p>
        </div> 
    </div>

<!-- bootstrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>