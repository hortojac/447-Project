<?php
    // Create a new MySQLi object
    $mysqli = new mysqli("mysql.eecs.ku.edu", "j242h828", "Ru3ji3oh", "j242h828");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $email = $_POST['email'];

    // Check if the email exists in the users table
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

    if ($result->num_rows > 0) {
        // Generate a unique token for the password reset link
        $token = uniqid();

        // Send the password reset link to the user's email address
        $to = $email;
        $subject = "Reset your password";
        $message = "Please click on the following link to reset your password: https://people.eecs.ku.edu/~j242h828/eecs447/pages/reset_password.html?token=$token";
        $headers = "From: https://people.eecs.ku.edu/~j242h828/eecs447";
        mail($to, $subject, $message, $headers);

        echo "A password reset link has been sent to your email address.";
        echo "<script>setTimeout(function(){window.location.href='./login.html';}, 3000);</script>";
    } else {
        echo "The provided email address is not registered!";
        echo "<script>setTimeout(function(){window.location.href='./password_reset_link.html';}, 3000);</script>";
    }

    // Close the database connection
    $mysqli->close();
?>

