<?php
    // Include the connect.php file
    require_once('../includes/connect.php');

    if(isset($_POST['submit'])) {
        // Sanitize user input to prevent SQL injection
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);

        // Construct the SQL query to retrieve the user's account from the database
        $sql = "SELECT * FROM accounts WHERE email='$email' AND password='$password'";

        // Execute the SQL query
        $result = $conn->query($sql);

        // Check if the query was successful and if a row was returned
        if ($result && $result->num_rows == 1) {
            // Set the user's session and redirect them to the shop page
            session_start();
            $_SESSION['email'] = $email;
            header("Location: ../main.php");
            exit();
        } else {
            // Display an error message and redirect the user back to the login page
            echo "<script>alert('Invalid email or password!');</script>";
            echo "<script>setTimeout(function(){window.location.href='./user_login.php';}, 1000);</script>";
            exit();
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
    <title>Login</title>
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
        <h1 class="text-center">Login</h1>
        <!-- login form -->
        <form action="" method="post" enctype="multipart/form-data">

            <!-- email -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Enter email" autocomplete="off" required="required">
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

            <!-- submit -->
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="submit" class="btn submit-btn mb-3 px-3" value="Login">

                <!-- don't have an account -->
                <p class="fw-bold mb-0 pt-1">Don't have an account? <a href="./create_account.php">Sign Up</a></p>
            </div>
        </form>
    </div> 
</body>
</html>