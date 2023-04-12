<?php
    // Create a new MySQLi object
    $mysqli = new mysqli("mysql.eecs.ku.edu", "j242h828", "Ru3ji3oh", "j242h828");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Get the input values from the HTML form
    $ssn = $_POST['ssn'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];

    // Hash the password
    //$hashed_password = password_hash($password1, PASSWORD_DEFAULT);

    // Construct the SQL query to insert the values into the table
    $sql = "INSERT INTO users (ssn, fname, lname, email, password, street, city, state, zipcode, age, dob, phone) 
            VALUES ('$ssn', '$fname', '$lname', '$email', '$password1', '$street', '$city', '$state', '$zipcode', '$age', '$dob', '$phone')";

    // Execute the SQL query
    if ($mysqli->query($sql) === TRUE) {
        echo "Account created successfully!";
        // Redirect the user to the shop page
        echo "<script>setTimeout(function(){window.location.href='./shop_page.html';}, 3000);</script>";
    } else {
        // Check if the error is due to a duplicate primary key
        if (strpos($mysqli->error, 'Duplicate entry') !== false) {
            // Send an error message to the user that the SSN is already in use
            echo "Error: The provided SSN is already in use!";
            // Redirect the user to the login page
            echo "<script>setTimeout(function(){window.location.href='./login.html';}, 3000);</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
            // Redirect the user back to the signup page
            echo "<script>setTimeout(function(){window.location.href='./sign_up.html';}, 3000);</script>";
        }
    }

    // Close the database connection
    $mysqli->close();
?>

