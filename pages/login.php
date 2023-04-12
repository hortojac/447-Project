<?php
    // Create a new MySQLi object
    $mysqli = new mysqli("mysql.eecs.ku.edu", "j242h828", "Ru3ji3oh", "j242h828");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    if(isset($_POST['email']) && isset($_POST['password'])) {
        // Sanitize user input to prevent SQL injection
        $email = $mysqli->real_escape_string($_POST['email']);
        $password = $mysqli->real_escape_string($_POST['password']);

        // Construct the SQL query to retrieve the user's account from the database
        $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";

        // Execute the SQL query
        $result = $mysqli->query($sql);

        // Check if the query was successful and if a row was returned
        if ($result && $result->num_rows == 1) {
            // Set the user's session and redirect them to the shop page
            session_start();
            $_SESSION['email'] = $email;
            header("Location: ./shop_page.html");
            exit();
        } else {
            // Display an error message and redirect the user back to the login page
            echo "Invalid email or password!";
            echo "<script>setTimeout(function(){window.location.href='./login.html';}, 3000);</script>";
            exit();
        }
    } else {
        // Display an error message and redirect the user back to the login page
        echo "Please provide a email and password!";
        echo "<script>setTimeout(function(){window.location.href='./login.html';}, 3000);</script>";
        exit();
    }

    // Close the database connection
    $mysqli->close();
?>

