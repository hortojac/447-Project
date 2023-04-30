<?php
require_once('./includes/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_POST['create_account'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];

    // Check if empty
    if ($first_name == '' || $last_name == '' || $password== '' || $email == '' || $username == '' || $phone_number == '') {
        echo "<script>alert('All fields required')</script>";
        exit();
    } else {
        // Prepare insert query
        $stmt = $conn->prepare("INSERT INTO `accounts` (username, first_name, last_name, email, password, phone_number, date) VALUES (?, ?, ?, ?, ?, ?, NOW())");

        // Bind the parameters
        $stmt->bind_param("ssssss", $username, $first_name, $last_name, $email, $password, $phone_number);

        // Execute the prepared statement
        $result_query = $stmt->execute();
        if ($result_query) {
            echo "<script>alert('Account Created');</script>";
            echo "<script>setTimeout(function(){window.location.href='./main.php';}, 1000);</script>";
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
    <title>Create Account</title>
    <link rel="icon" href="./images/logo.png" class="">

    <!-- bootstrap css link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

     <!-- font awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css file -->
    <link rel="stylesheet" href="./style.css">
    <style>
        .submit-btn {
            background-color: #1b4d89;
            color: #ffffff;
        }
        .submit-btn:hover {
            background-color: #6c757d; 
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Create Account</h1>
        <!-- create account form -->
        <form action="" method="post" enctype="multipart/form-data">
            <!-- first name -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter first name" autocomplete="off" required="required">
            </div>

            <!-- last name -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter last name" autocomplete="off" required="required">
            </div>

            <!-- email -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Enter email" autocomplete="off" required="required">
            </div>

            <!-- username -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" autocomplete="off" required="required">
            </div>

            <!-- password -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="password" class="form-label">Password</label>
                <input type="text" name="password" id="password" class="form-control" placeholder="Enter password" autocomplete="off" required="required">
            </div>

            <!-- phone number -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Enter phone number" autocomplete="off" required="required">
            </div>

            <!-- submit -->
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="create_account" class="btn submit-btn mb-3 px-3" value="Sign Up">
            </div>
        </form>
    </div> 
</body>
</html>