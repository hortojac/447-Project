<?php
    // Create a new MySQLi object
    $mysqli = new mysqli("mysql.eecs.ku.edu", "j242h828", "Ru3ji3oh", "j242h828");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Get the input values from the HTML form
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];

    // Construct the SQL query to insert the values into the table
    $sql = "INSERT INTO users (fname, lname, email, password, street, city, state, zipcode) 
            VALUES ('$fname', '$lname', '$email', '$password1', '$street', '$city', '$state', '$zipcode')";

    // Execute the SQL query
    if ($mysqli->query($sql) === TRUE) {
        echo "Account created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
?>

