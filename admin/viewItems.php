<?php
require_once('../includes/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// function to delete product
if (isset($_POST['delete_product'])) {
    global $conn;
    if (isset($_POST['removeProduct'])) {
        foreach ($_POST['removeProduct'] as $remove_id) {
            // Fetch product title before deleting
            $fetch_query = "SELECT product_title FROM `products` WHERE product_id=$remove_id";
            $fetch_result = mysqli_query($conn, $fetch_query);
            $product_title = mysqli_fetch_assoc($fetch_result)['product_title'];

            $delete_query = "DELETE FROM `products` WHERE product_id=$remove_id";
            $run_delete = mysqli_query($conn, $delete_query);
            if ($run_delete) {
                // Display success message with product name
                echo "<script>alert('Product \"$product_title\" deleted')</script>";
            } else {
                // Display error message if query fails
                echo "Error deleting product: " . mysqli_error($conn);
            }
        }
    } else {
        echo "<script>alert('No product selected!')</script>";
    }
}
?>

<div class="container">
    <div class="row">
        <form action="" method="post" id="cartForm"> 
            <table class="table table-bordered text-center">
                <thead>
                    <?php
                        global $conn;
                        $select_query="Select * from `products`";
                        $result_query = mysqli_query($conn,$select_query);
                        $count_products=mysqli_num_rows($result_query);
                        echo "<h4 class='text-success'>Total Products: $count_products</h4>"

                    ?>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Keywords</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        global $conn;
                        $product_query = "SELECT * FROM products";
                        $product_statement = mysqli_prepare($conn, $product_query);
                        mysqli_stmt_execute($product_statement);

                        $product_results = mysqli_stmt_get_result($product_statement);
                        while ($product_row = mysqli_fetch_array($product_results)) {
                            $product_id = $product_row['product_id'];
                            $product_price = $product_row['product_price'];
                            $product_title = $product_row['product_title'];
                            $product_image1 = $product_row['product_image1'];
                            $product_keywords = $product_row['product_keywords'];
                            $product_quantity = $product_row['product_quantity'];
                            echo 
                                "<tr>
                                    <td><img src='product_images/$product_image1' alt='' class='product_img' /></td>
                                    <td>$product_title</td>
                                    <td>$product_quantity</td>
                                    <td>$" . $product_price . "</td>
                                    <td>$product_keywords</td>
                                    <td><input type='checkbox' name='removeProduct[]' value='$product_id'></td>
                                </tr>";
                        }
                    ?>
                </tbody>
            </table>
            <div class="d-flex flex-row-reverse mb-5">
                <input type="submit" value="Delete" class="bg-danger p-2 border-2 m-1 delete-btn" name="delete_product">
            </div>
        </form>
    </div>
</div>
