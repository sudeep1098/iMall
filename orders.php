<?php
include "partials/_dbconnect.php";
include "partials/_header.php";

if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
    $user_id = $_SESSION["user_id"];

    // Handle order deletion
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
        $order_id = $_POST["order_id"];
        $sql = "DELETE FROM `orders` WHERE `order_id`='$order_id'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            echo '<div class="alert alert-success my-0 alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Deleted Order successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
    $sql = "SELECT * FROM `orders` WHERE user_id=$user_id";
    $result = mysqli_query($con, $sql);
    $numofrows = mysqli_num_rows($result);
    if ($numofrows > 0) {
        // Fetch and display the orders
        echo '<div class="container my-4 mx-auto w-75">
        <h1 class="text-center mt-5">My Orders</h1>
        <table class="table">
            <thead>
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
                <td>' . $status . '</td>';
            if ($status != "Complete") {
                echo '<td>
                    <a class="btn btn-primary" href="checkout.php?order_id=' . $order_id . '">Confirm</a>
                </td>';
            }
            echo '<td>
                    <form action="orders.php" method="post">
                        <input type="hidden" name="order_id" value="' . $order_id . '">
                        <button class="btn btn-danger" type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>';
        }
        echo '</tbody>
        </table>
    </div>';
    } else {
        echo '<div class="container py-4 mt-4">
    <div class="p-5 mb-4 bg-body-tertiary rounded-4">
        <div class="container-fluid text-center py-5">
            <h2 class="text-center">Your Order List is empty.</h2>
            <p class=" fs-4">You have not purchased any product.</p>
        </div>
    </div>
</div>';
    }
} else {
    echo '<div class="container py-3 mt-4">
        <div class="p-5 mb-4 bg-body-tertiary rounded-4">
            <div class="container-fluid text-center py-5">
                <h1 class="display-5 fw-bold">Please Login or Signup</h1>
                <p class="fs-4">Without signup or login, this page is unavailable.</p>
            </div>
        </div>
    </div>';
}
?>
<div class="position-absolute bottom-0 container-fluid">
    <?php include "partials/_footer.php" ?>
</div>