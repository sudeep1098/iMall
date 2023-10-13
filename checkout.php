<?php include "partials/_dbconnect.php" ?>
<?php include "partials/_header.php" ?>

<?php
if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
    $order_id = $_GET["order_id"];
    $user_id = $_SESSION["user_id"];
    $user_email = $_SESSION["userEmail"];
    list($username, $domain) = explode('@', $userEmail);
    $sql = "SELECT * from `users` where `user_id`=$user_id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $name = $row["username"];
    $user_password = $row["user_password"];
    $img = $row["img"];
    $country = $row["country"];
    $state = $row["state"];
    $phone = $row["phone"];
    $zip = $row["zip"];
    $address = $row["address"];
    $discount = 0;
    $status = "Complete";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_GET["payment"]) && $_GET["payment"] == "success") {
            $order_update_sql = "UPDATE `orders` SET `status`='$status' WHERE `order_id`=$order_id AND `user_id`=$user_id;";
            $order_update_result = mysqli_query($con, $order_update_sql);

            if ($order_update_result) {
                $delete_cart_sql = "TRUNCATE TABLE `ecommerce`.`mycart`";
                $result = mysqli_query($con, $delete_cart_sql);
                echo "<script>window.location.href = 'index.php?payment=success';</script>";
                if (!$result) {
                    echo "<script>window.location.href = 'index.php?payment=failed';</script>";
                }
            }
            if (!$order_update_result) {
                echo '<div class="alert alert-danger my-0 alert-dismissible fade show" role="alert">
                <strong>Failed</strong>to change status.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
        if (isset($_POST["checkout"])) {
            $name = $_POST["name"];
            $user_email = $_POST["user_email"];
            $state = $_POST["state"];
            $country = $_POST["country"];
            $phone = $_POST["phone"];
            $zip = $_POST["zip"];
            $address = $_POST["address"];
            $card_name = $_POST["card_name"];
            $card_no = $_POST["card_no"];

            $exp_date = $_POST["exp_date"];
            $payment_method = $_POST["paymentMethod"];
            $cvv = $_POST["cvv"];

            $sql = "UPDATE `users` SET `username`='$name', `user_email`='$user_email',`state`='$state', `country`='$country',`zip`='$zip',`address`='$address', `phone`='$phone' WHERE `user_id`='$user_id'";
            $result = mysqli_query($con, $sql);

            $card_sql = "INSERT INTO `card_details` (`order_id`, `card_user_id`, `card_name`, `card_no`, `card_exp_date`, `card_cvv`, `payment_method`, `time`) VALUES ('$order_id', '$user_id', '$card_name', '$card_no', '$exp_date', '$cvv', '$payment_method', current_timestamp());";
            $card_result = mysqli_query($con, $card_sql);
            if (!$card_result) {
                echo '<div class="alert alert-danger my-0 alert-dismissible fade show" role="alert">
                <strong>Failed</strong>Please add all cart details.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
        if (isset($_POST["discount"])) {
            $entered_discount_code = $_POST["discount"];
            if ($entered_discount_code === "sudeep") {

                $sql = "SELECT `discount_applied` FROM `orders` WHERE `order_id` = '$order_id'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
                $discount_applied = $row['discount_applied'];

                if ($discount_applied === '0') {

                    $discount = 5;
                    // Apply the discount
                    $sql = "UPDATE `orders` SET `amount_due` = `amount_due` - $discount, `discount_applied` = '1' WHERE `order_id` = '$order_id'";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                        echo '<div class="alert alert-success alert-dismissible" role="alert">
                        <div>Discount applied!</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                    }
                } else {
                    echo '<div class="alert alert-warning alert-dismissible" role="alert">
                    <div>Discount has already been applied to this order.</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                }
            }
        }
    }

    $order_sql = "SELECT * from `orders` where `order_id`=$order_id";
    $order_result = mysqli_query($con, $order_sql);
    $order_row = mysqli_fetch_assoc($order_result);
    $invoice_no = $order_row["invoice_no"];
    $amount_due = $order_row["amount_due"];

    $cart_sql = "SELECT * FROM `mycart` WHERE host_ip = '$hostIp' AND `cart_user_id`='$user_id';";
    $cart_result = mysqli_query($con, $cart_sql);
    $cart_noofrows = mysqli_num_rows($cart_result);
}
?>

<?php
echo '<main class="container">
    <div class="py-5 text-center">
        <h2>Payment</h2>
    </div>

    <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Your cart</span>
                <span class="badge bg-primary rounded-pill">' . $cart_noofrows . '</span>
            </h4>
            <ul class="list-group mb-3">';




while ($cart_row = mysqli_fetch_assoc($cart_result)) {
    $cart_name = $cart_row["cart_name"];
    $cart_price = $cart_row["cart_price"];

    echo '<li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                        <h6 class="my-0">' . $cart_name . '</h6>
                        <small class="text-body-secondary">Brief description</small>
                    </div>
                    <span class="text-body-secondary">' . $cart_price . '</span>
                </li>';
}
echo '<li class="list-group-item d-flex justify-content-between bg-body-tertiary">                  
                    <div class="text-success">
                        <h6 class="my-0">Promo code</h6>
                        <small>EXAMPLECODE</small>
                    </div>
                    <span class="text-success">-$' . $discount . '</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong>' . $amount_due . '</strong>
                </li>
            </ul>

            <form class="card p-2" method="post" action="#paymentModal">
                <div class="input-group">
                    <input type="text" class="form-control" name="discount"  placeholder="Promo code">
                    <button type="submit"  class="btn btn-secondary">Redeem</button>
                </div>
            </form>
        </div>
        <div class="col-md-7 col-lg-8">
            <h4 class="mb-3">Billing address</h4>
            <form class="needs-validation" action="checkout.php?order_id=' . $order_id . '&payment=success" method="post"  novalidate>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="" name="name" value="' . $name . '" required>
                        <div class="invalid-feedback">
                            Valid name is required.
                        </div>
                    </div>


                    <div class="col-12">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">@</span>
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="' . $username . '" required>
                            <div class="invalid-feedback">
                                Your username is required.
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label">Email
                        <input type="email" class="form-control" id="email" name="user_email" value="' . $user_email . '" placeholder="you@example.com">
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="phone" class="form-label">Phone
                        <input type="phone" class="form-control" id="phone" name="phone" value="' . $phone . '" placeholder="">
                        <div class="invalid-feedback">
                            Please enter a valid phone for contact.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" value="' . $address . '" id="address" placeholder="" required>
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="address2" class="form-label">Address 2 <span
                                class="text-body-secondary">(Optional)</span></label>
                        <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                    </div>

                    <div class="col-md-5">
                        <label for="country" class="form-label">Country</label>
                        <select class="form-select" name= "country" type="submit" required>
                            <option>Choose...</option>
                            <option>USA</option>
                            <option selected>India</option>
                            <option>UK</option>
                            <option>Germany</option>
                            <option>France</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid country.
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="state" class="form-label">State</label>
                        <select class="form-select" id="state" name= "state" type="submit" required>
                            <option>Choose...</option>
                            <option selected>Haryana</option>
                            <option>Ambala</option>
                            <option>Punjab</option>
                            <option>Rajasthan</option>
                            <option>Benglore</option>
                        </select>
                        <div class="invalid-feedback">
                            Please provide a valid state.
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="zip" class="form-label">Zip</label>
                        <input type="text" class="form-control" id="zip" name="zip" value="' . $zip . '" placeholder="" required>
                        <div class="invalid-feedback">
                            Zip code required.
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h4 class="mb-3">Payment</h4>

                <div class="my-3">
                    <div class="form-check">
                        <input id="credit" name="paymentMethod" type="radio" value="UPI" class="form-check-input" checked required>
                        <label class="form-check-label" for="credit">Credit card</label>
                    </div>
                    <div class="form-check">
                        <input id="debit" name="paymentMethod" type="radio" value="Debit card" class="form-check-input" required>
                        <label class="form-check-label" for="debit">Debit card</label>
                    </div>
                    <div class="form-check">
                        <input id="paypal" name="paymentMethod" type="radio" value="PayPal" class="form-check-input" required>
                        <label class="form-check-label" for="paypal">PayPal</label>
                    </div>
                </div>

                <div class="row gy-3">
                    <div class="col-md-6">
                        <label for="cc-name" class="form-label">Name on card</label>
                        <input type="text" class="form-control" id="cc-name" name="card_name"  placeholder="" required>
                        <small class="text-body-secondary">Full name as displayed on card</small>
                        <div class="invalid-feedback">
                            Name on card is required
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="cc-number" class="form-label">Credit card number</label>
                        <input type="text" class="form-control" id="cc-number" name="card_no"  placeholder="" required>
                        <div class="invalid-feedback">
                            Credit card number is required
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="cc-expiration" class="form-label">Invoice no.</label>
                        <input type="text" class="form-control" id="cc-expiration" name="invoice" value="' . $invoice_no . '" placeholder="" required>
                        <div class="invalid-feedback">
                            Invoice no. required
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="cc-expiration" class="form-label">Expiration</label>
                        <input type="text" class="form-control" id="cc-expiration" name="exp_date"  placeholder="" required>
                        <div class="invalid-feedback">
                            Expiration date required
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="cc-cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cc-cvv" name="cvv"  placeholder="" required>
                        <div class="invalid-feedback">
                            Security code required
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <button class="w-100 btn btn-primary btn-lg mb-4" name="checkout" type="submit" >
                Continue to checkout
                </button>
        </div>
    </div>
</main>';


?>
<?php include "partials/_footer.php" ?>