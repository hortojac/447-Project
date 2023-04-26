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

    </head>
<body>
    <!--navbar -->
    <div class="container-fluid p-0">
        <!-- First child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="../images/logo.png" alt="" class="logo">
                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav ">
                        <li class="nav-item">
                            <a href="" class="nav-link">Welcome guest</a>
                            <button><a href="" class="nav-link btn-outline-primary">Logout</a></button>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>
        <!-- second child -->
        <div class="bg-light">
            <h3 class="text-center p2">Management Settings</h3>
        </div>

        <!-- third child -->
        <div class="row">
            <div class="col-md-12 bg-secondary p-1 d-flex align-items-center">
                <div class="p-3">
                    <a href="#" ><img src="../images/admin1.jpg" alt="" class="admin-image"></a>
                    <p class="text-light text-center">Admin Name</p>
                </div>
                <!-- mangement buttons -->
                <div class="button text-center">
                    <button><a href="" class="btn btn-outline-primary">View Items</a></button>
                    <button><a href="insert_product.php" class="btn btn-outline-primary">Add Items</a></button>
                    <button><a href="index.php?insert_category" class="btn btn-outline-primary">Add Category</a></button>
                    <button><a href="" class="btn btn-outline-primary">View Categories</a></button>
                    <button><a href="index.php?insert_brand" class="btn btn-outline-primary">Add Brands</a></button>
                    <button><a href="" class="btn btn-outline-primary">View Brands</a></button>
                    <button><a href="" class="btn btn-outline-primary">Orders</a></button>
                    <button><a href="" class="btn btn-outline-primary">Payments</a></button>
                    <button><a href="" class="btn btn-outline-primary">All users</a></button>
                    
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
            ?>
        </div>
        <!-- last child -->
        <div class="bg-light p-3 text-center footer">
            <p>By Bikash and Jacob</p>
        </div> 
    </div>

<!-- bootstrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>