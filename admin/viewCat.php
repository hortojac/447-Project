<?php
require_once('../includes/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// function to remove category
    global $conn;
    if(isset($_POST['remove_cat']) && isset($_POST['removeCat']) && !empty($_POST['removeCat'])) {
        foreach($_POST['removeCat'] as $removeCat_id) {
            // Retrieve category name before deleting it
            $select_category = "SELECT category_title FROM `categories` WHERE category_id=$removeCat_id";
            $result_category = mysqli_query($conn, $select_category);
            $row_category = mysqli_fetch_assoc($result_category);
            $category_title = $row_category['category_title'];

            // Delete category
            $delete_query = "DELETE FROM `categories` WHERE category_id=$removeCat_id";
            $run_delete = mysqli_query($conn, $delete_query);
            if($run_delete) {
                // Display success message with category name
                echo "<script>alert('Category \"$category_title\" deleted')</script>";
            } else {
                // Display error message if query fails
                echo "Error deleting category: " . mysqli_error($conn);
            }
        }
    }

?>

<form action="" method="post" id=""> 
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Category</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
        <?php
            global $conn;
            $select_categories = "SELECT * FROM `categories`";
            $result_categories = mysqli_query($conn, $select_categories);
            while($row_data = mysqli_fetch_assoc($result_categories)) {
                $category_title = $row_data['category_title'];
                $category_id = $row_data['category_id'];
                echo
                "<tr>
                    <td>$category_title</td>
                    <td><input type='checkbox' name='removeCat[]' value='$category_id'></td>
                </tr>";
            }
        ?>
        </tbody>
    </table>
    <div class="d-flex flex-row-reverse mb-5">
        <input type="submit" value="Remove" class="bg-danger p-2 border-2 m-1 delete-btn" name="remove_cat">
    </div>
</form>
