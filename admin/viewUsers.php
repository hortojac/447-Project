<?php
require_once('../includes/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<div class="container">
    <div class="row">
        <form action="" method="post" id="userForm"> 
            <table class="table table-bordered text-center">
                <thead>
                    <?php
                        global $conn;
                        $select_query="Select * from `accounts`";
                        $result_query = mysqli_query($conn, $select_query);
                        $count_users=mysqli_num_rows($result_query);
                        echo "<h4 class='text-success'>Total Users: $count_users</h4>"

                    ?>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Phone Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        global $conn;
                        $user_query = "SELECT * FROM accounts";
                        $user_statement = mysqli_prepare($conn, $user_query);
                        mysqli_stmt_execute($user_statement);

                        $user_results = mysqli_stmt_get_result($user_statement);
                        while ($user_row = mysqli_fetch_array($user_results)) {
                            $first_name = $user_row['first_name'];
                            $last_name = $user_row['last_name'];
                            $email = $user_row['email'];
                            $username = $user_row['username'];
                            $phone_number = $user_row['phone_number'];
                            echo 
                                "<tr>
                                    <td>$first_name</td>
                                    <td>$last_name</td>
                                    <td>$email</td>
                                    <td>$username</td>
                                    <td>$phone_number</td>
                                </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
</div>