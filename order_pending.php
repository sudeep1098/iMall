<?php
include "partials/_dbconnect.php";
include "partials/_header.php";

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
    $user_id = $_SESSION["user_id"];

    $sql = "SELECT SUM(cart_price * quantity) AS total_price, SUM(quantity) AS total_quantity FROM mycart WHERE host_ip = '$hostIp' AND `cart_user_id`='$user_id';";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $totalPrice = $row['total_price'];
    $total_quantity = $row['total_quantity'];
    $status = "Incomplete";
    // Generate a random invoice number
    $min = 100000; // Smallest 6-digit number
    $max = 9999999; // Largest 7-digit number
    $invoice_no = mt_rand($min, $max);

    $sql = "SELECT * FROM `mycart` WHERE host_ip = '$hostIp' AND `cart_user_id`='$user_id';";
    $result = mysqli_query($con, $sql);
    $total_products = mysqli_num_rows($result);


    // Insert a new order into the orders table
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["order"])) {
            $sql = "INSERT INTO `orders` (`user_id`,`invoice_no`, `amount_due`,`total_products`, `status`, `date`) VALUES ('$user_id','$invoice_no', '$totalPrice','$total_products' ,'$status', current_timestamp());";
            $result = mysqli_query($con, $sql);
        }
        if (isset($_POST["delete"])) {
            $order_id = $_POST["order_id"];
            $sql = "DELETE FROM `orders` WHERE `order_id`='$order_id';";
            $result = mysqli_query($con, $sql);
            if ($result) {
                echo '<div class="alert alert-success my-0 alert-dismissible fade show" role="alert">
                        <strong>Success!</strong>Deleted Order successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            }
        }
    }

    // Fetch and display the orders
    echo '<table class="table container my-4 mx-auto w-75">
        <thead>
            <h1 class="text-center mt-5">My Orders</h1>
            <tr>
                <th scope="col">Order No</th>
                <th scope="col">Amount Due</th>
                <th scope="col">Invoice Number</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>';

    $sql = "SELECT * FROM `orders` WHERE user_id=$user_id AND invoice_no=$invoice_no";
    $result = mysqli_query($con, $sql);

    $count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $count++;
        $order_id = $row["order_id"];
        $amount_due = $row["amount_due"];
        $invoice_no = $row["invoice_no"];
        $date = $row["date"];
        $status = $row["status"];


        echo '<tr>
                <td>' . $count . '</td>
                <td>' . $amount_due . '</td>
                <td>' . $invoice_no . '</td>
                <td>' . $date . '</td>
                <td>' . $status . '</td>
                <td>
                    <a class="btn btn-primary" type="submit" href="checkout.php?order_id=' . $order_id . '">Confirm</a>
                    </td>
                    <form action="order_pending.php" method="post">
                        <input type="hidden" name= "order_id" value="' . $order_id . '">
                        <td><button class="btn btn-danger" type="submit" name="delete">Delete</button>
                    </form></td>
            </tr>';
    }
    echo '</tbody>
        </table>';
} else {
    echo '<div class="container py-3 mt-4">
        <div class="p-5 mb-4 bg-body-tertiary rounded-4">
            <div class="container-fluid text-center py-5">
                <h1 class="display-5 fw-bold">Please Login or Signup</h1>
                <p class=" fs-4">Without signup or login, this page is unavailable.</p>
            </div>
        </div>
    </div>';
}
?>
<div class="position-absolute bottom-0 container-fluid">
    <?php include "partials/_footer.php" ?></div>