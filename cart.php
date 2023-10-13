<?php
include "partials/_dbconnect.php";
include "partials/_header.php";

// Get the host IP
$hostIp = $_SERVER['SERVER_ADDR'];
$user_id = 0;

if (isset($_SESSION["loggedIn"]) && ($_SESSION["loggedIn"] == true)) {
    $user_id = $_SESSION["user_id"];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the product_id from the form
    $cart_product_id = $_GET["cart_product_id"];
    $cart_quantity = $_POST["quantity"];

    if (isset($_POST["remove"])) {
        // Remove item from cart
        if (!$cart_quantity) {
            $sql = "DELETE FROM `mycart` WHERE `cart_product_id` = '$cart_product_id' AND host_ip = '$hostIp' AND `cart_user_id`='$user_id';";
            $result = mysqli_query($con, $sql);
        } else {
            $sql = "UPDATE `mycart` SET `quantity` = `quantity` - $cart_quantity WHERE `cart_product_id` = '$cart_product_id' AND host_ip = '$hostIp' AND `cart_user_id`='$user_id' ;";
            $result = mysqli_query($con, $sql);
            $sql1 = "SELECT * FROM `mycart` WHERE `cart_product_id` = '$cart_product_id' AND host_ip = '$hostIp' AND `cart_user_id`='$user_id';";
            $result1 = mysqli_query($con, $sql1);
            $row1 = mysqli_fetch_assoc($result1);
            $quantity = $row1["quantity"];
            if ($cart_quantity == 0 || $quantity <= 0) {
                $sql = "DELETE FROM `mycart` WHERE `cart_product_id` = '$cart_product_id' AND host_ip = '$hostIp' AND `cart_user_id`='$user_id';";
                $result = mysqli_query($con, $sql);
            }
            if ($result) {
                echo '<div class="alert alert-success my-0 alert-dismissible fade show" role="alert">
            <strong>Success!</strong> removed from your cart.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            } else {
                echo '<div class="alert alert-danger my-0 alert-dismissible fade show" role="alert">
            <strong>Fail!</strong>failed to remove from cart.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
        }
    }

    if (isset($_POST["update"])) {
        // Update item quantity in cart
        $sql = "SELECT * FROM `mycart` WHERE `cart_product_id` = $cart_product_id AND host_ip = '$hostIp' AND `cart_user_id`='$user_id' ;";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $cart_name = $row["cart_name"];
        $cart_price = $row["cart_price"];

        // Insert updated quantity of the same product
        for ($i = 0; $i < $cart_quantity; $i++) {
            $sql = "UPDATE `mycart` SET `quantity` = `quantity` + 1 WHERE `cart_product_id` = $cart_product_id AND host_ip = '$hostIp' AND `cart_user_id`='$user_id';";
            $result = mysqli_query($con, $sql);
            if (!$result) {
                echo '<div class="alert alert-danger my-0 alert-dismissible fade show" role="alert">
                <strong>Failed!</strong> failed to update cart.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                break; // Stop if insertion fails
            }
        }

        echo '<div class="alert alert-success my-0 alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Successfully updated cart.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}


// Fetch and display cart items for the matching host IP
$sql = "SELECT * FROM `mycart` WHERE host_ip = '$hostIp' AND `cart_user_id`='$user_id';";
$result = mysqli_query($con, $sql);
$numofrows = mysqli_num_rows($result);
$count = 0;

if ($numofrows > 0) {
    echo '<table class="table container-fluid w-75 mx-auto">
            <h1 class="text-center mb-5 mt-5">Your Shopping Cart</h1>
            <thead>
                <tr>
                    <th scope="col">Sno.</th>
                    <th>Product</th>
                    <th>Total</th>
                    <th>Quantity</th>
                    <th >How many to add or remove?</th>
                    <th style="padding-left: 8rem; padding-right: 0; width: 25px;">Action</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        $count++;
        $cart_id = $row["cart_id"];
        $cart_product_id = $row["cart_product_id"];
        $cart_name = $row["cart_name"];
        $cart_price = $row["cart_price"];
        $cart_quantity = $row["quantity"];
        $timestamp = $row["timestamp"];

        echo '<tr>
        <tr>
        <th scope="row">' . $count . '</th>
        <td>' . $cart_name . '</td>
        <td>' . $cart_price * $cart_quantity . '</td>
        <td style="padding-left:30px">' . $cart_quantity . '</td>
        <form action="cart.php?cart_product_id=' . $cart_product_id . '" method="post">
        <td><input type="number" min="0" step="1" class="text-center" name="quantity" placeholder="0"></td>
        <td style="padding-right: 0;"><button type="submit" class="btn btn-danger" name="remove">Remove from cart</button></td>
        <td class="px-0"><button type="submit" class="btn btn-primary px-4" name="update">Update cart</button></td>
        </form>';
    }

    // Calculate total price
    $sql = "SELECT SUM(cart_price * quantity) AS total_price, SUM(quantity) AS total_quantity FROM mycart WHERE host_ip = '$hostIp' AND `cart_user_id`='$user_id';";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $totalPrice = $row['total_price'];
    $total_quantity = $row['total_quantity'];

    echo '<tr>
            <th></th>
            <th>Sub Total</th>
            <th>' . $totalPrice . '</th>
            <th style="padding-left:30px">' . $total_quantity . '</th>
            <th></th>
            <th><a class="btn btn-outline-primary px-5" href="products.php?all_products" class="text-decoration-none">Return</a></th>
            <form action="order_pending.php" method="post">
            <th class="px-0"><button class="btn btn-success" type="submit" name="order" class="text-decoration-none">Continue Buying</button></th>
        </form>
        </tr>
        </tbody>
        </table>';
} else {
    // No items in the cart
    echo '<div class="container py-4 mt-4">
    <div class="p-5 mb-4 bg-body-tertiary rounded-4">
        <div class="container-fluid text-center py-5">
            <h2 class="text-center">Your cart is empty.</h2>
            <p class=" fs-4">Please add products to your cart.</p>
        </div>
    </div>
</div>';
}

?>


<div class="position-absolute bottom-0 container-fluid">
    <?php include "partials/_footer.php" ?></div>