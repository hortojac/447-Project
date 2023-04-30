<?php
require_once('../includes/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// function to remove brand
    global $conn;
    if(isset($_POST['remove_Brand']) && isset($_POST['removeBrand']) && !empty($_POST['removeBrand'])) {
        foreach($_POST['removeBrand'] as $removeBrand_id) {
            // Retrieve brand name before deleting it
            $select_brand = "SELECT brand_title FROM `brands` WHERE brand_id=$removeBrand_id";
            $result_brand = mysqli_query($conn, $select_brand);
            $row_brand = mysqli_fetch_assoc($result_brand);
            $brand_title = $row_brand['brand_title'];

            // Delete brand
            $delete_query = "DELETE FROM `brands` WHERE brand_id=$removeBrand_id";
            $run_delete = mysqli_query($conn, $delete_query);
            if($run_delete) {
                // Display success message with brand name
                echo "<script>alert('\"$brand_title\" brand deleted')</script>";
            } else {
                // Display error message if query fails
                echo "Error deleting brand: " . mysqli_error($conn);
            }
        }
    }

?>

<form action="" method="post" id=""> 
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Brand</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
        <?php
            global $conn;
            $select_brands = "SELECT * FROM `brands`";
            $result_brands = mysqli_query($conn, $select_brands);
            while($row_data = mysqli_fetch_assoc($result_brands)) {
                $brand_title = $row_data['brand_title'];
                $brand_id = $row_data['brand_id'];
                echo
                "<tr>
                    <td>$brand_title</td>
                    <td><input type='checkbox' name='removeBrand[]' value='$brand_id'></td>
                </tr>";
            }
        ?>
        </tbody>
    </table>
    <div class="d-flex flex-row-reverse mb-5">
        <input type="submit" value="Remove" class="bg-danger p-2 border-2 m-1 delete-btn" name="remove_Brand">
    </div>
</form>