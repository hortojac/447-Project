<?php
require_once('../includes/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['insert_cat'])) {
    // Get the category title from the input field
    $cat_title = trim($_POST['cat_title']);

    // Check if the category title is not empty
    if (!empty($cat_title)) {
        // Check if the category title already exists
        $sql_check = "SELECT category_title FROM categories WHERE category_title = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $cat_title);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) == 0) {
            // Prepare and bind SQL statement
            $sql = "INSERT INTO categories (category_title) VALUES (?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $cat_title);

            // Execute SQL statement
            if (mysqli_stmt_execute($stmt)) {
                echo "Category added successfully.";
            } else {
                echo "Error adding category: " . mysqli_error($conn);
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Category title already exists.";
        }

        // Close check statement
        mysqli_stmt_close($stmt_check);
    } else {
        echo "Category title cannot be empty.";
    }
}
?>

<h2 class="text-center">Insert Categories</h2>

<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text main-color text-color" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <input type="text" class="form-control" name="cat_title" placeholder="Insert categories" aria-label = "Categories" aria-describedby="basic-addon1">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="main-color text-color border-0 p-2 submit-item" name="insert_cat" value="Insert Categories">
    </div>
</form>