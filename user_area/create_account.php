<?php
require_once('../includes/connect.php');
include('../functions/common_functions.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$insert_stmt = null;

if (isset($_POST['create_account'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
    $user_image = $_FILES['user_image']['name'];
    $img_tmp_name = $_FILES['user_image']['tmp_name'];
    $user_ip = getIPAddress();

    // Prepare SELECT query to check if username or email is already taken
    $select_stmt = mysqli_prepare($conn, "SELECT * FROM `accounts` WHERE username = ? OR email = ?");
    mysqli_stmt_bind_param($select_stmt, "ss", $username, $email);
    mysqli_stmt_execute($select_stmt);
    $result = mysqli_stmt_get_result($select_stmt);

    $rowcount = mysqli_num_rows($result);

    if ($rowcount > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['username'] == $username) {
                echo "<script>alert('Sorry, username \'$username\' is already taken.')</script>";
            } elseif ($row['email'] == $email) {
                echo "<script>alert('Sorry, email \'$email\' is already taken.')</script>";
            }
        }
    } else {
        // Check if all fields are filled
        if ($first_name == '' || $last_name == '' || $password == '' || $email == '' || $username == '' || $phone_number == '' || $user_image == '') {
            echo "<script>alert('All fields required')</script>";
        } else {
            // Prepare INSERT query to add new user
            $insert_stmt = $conn->prepare("INSERT INTO `accounts` (username, first_name, last_name, email, password, phone_number, user_image, user_ip, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $insert_stmt->bind_param("ssssssss", $username, $first_name, $last_name, $email, $password, $phone_number, $user_image, $user_ip);
            
            // Upload the image
            move_uploaded_file($img_tmp_name, "./profile/$user_image");

            // Execute the prepared statement
            $result_query = $insert_stmt->execute();
            if ($result_query) {
                session_start();
                $_SESSION['email'] = $email;
                echo "<script>alert('Account Created');</script>";
                echo "<script>setTimeout(function(){window.location.href='../main.php';}, 1000);</script>";
                exit();
            }
        }
    }
    if ($insert_stmt) {
        mysqli_stmt_close($insert_stmt);
    }
    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
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

            <!-- userImage -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="user_image" class="form-label">Profile Picture</label>
                <input type="file" name="user_image" id="user_image" class="form-control" required="required">
            </div>

            <!-- username -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" autocomplete="off" required="required">
            </div>

            <!-- password -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" autocomplete="off" required="required">
                    <button type="button" class="btn btn-outline-secondary" id="showPasswordBtn">Show</button>
                </div>
            </div>

            <script>
                const passwordInput = document.getElementById('password');
                const showPasswordBtn = document.getElementById('showPasswordBtn');
                showPasswordBtn.addEventListener('click', function() {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        showPasswordBtn.textContent = 'Hide';
                    } else {
                        passwordInput.type = 'password';
                        showPasswordBtn.textContent = 'Show';
                    }
                });
            </script>

            <!-- phone number -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Enter phone number" autocomplete="off" required="required">
            </div>

            <!-- submit -->
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="create_account" class="btn submit-btn mb-3 px-3" value="Sign Up">

                <!-- Already have an account -->
                <p class="fw-bold mb-0 pt-1">Already have an account? <a href="user_login.php">Login</a></p>
            </div>
        </form>
    </div> 
</body>
</html>