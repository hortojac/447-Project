<?php
require_once('../includes/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['brand_insert'])) {
    // Get the brand title from the input field
    $cat_title = trim($_POST['brand_title']);

    // Check if the brand title is not empty
    if (!empty($cat_title)) {
        // Check if the brand title already exists
        $sql_check = "SELECT brand_title FROM brands WHERE brand_title = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $cat_title);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) == 0) {
            // Prepare and bind SQL statement
            $sql = "INSERT INTO brands (brand_title) VALUES (?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $cat_title);

            // Execute SQL statement
            if (mysqli_stmt_execute($stmt)) {
                echo "Brand added successfully.";
            } else {
                echo "Error adding brand: " . mysqli_error($conn);
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Brand name already exists.";
        }
        // Close check statement
        mysqli_stmt_close($stmt_check);
    } else {
        echo "Brand cannot be empty.";
    }
}
?>

<h2 class="text-center">Insert Brands</h2>

<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-3">
        <span class="input-group-text main-color text-color"><i class="fa-solid fa-receipt"></i></span>
        <input type="text" class="form-control" name="brand_title" id="floatingInputGroup1" placeholder="Brand Name">
    </div>

    <div class="input-group w-100 mb-2 m-auto">
        <input type="submit" class="main-color text-color border-0 p-2 submit-item" name="brand_insert" id="floatingInputGroup1" value="Add brand">
    </div>
</form>