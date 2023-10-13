<?php include "partials/_dbconnect.php" ?>
<?php include "partials/_header.php" ?>

<?php
if (isset($_GET["all_products"]) && $_GET["all_products"] == null) {

    $sql = "SELECT * FROM `products` ORDER BY RAND()";
    $result = mysqli_query($con, $sql);
    echo '<div class="album mb-5 w-100 h-100 py-4 bg-body-tertiary">
    <h1 class="text-center mb-4">All Products</h1>
    <div class="container">
        <span></span>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';


    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row["product_id"];
        $product_name = $row["product_name"];
        $product_price = $row["product_price"];
        $product_thread_id = $row["product_thread_id"];
        $timestamp = $row["timestamp"];


        echo   '<div class="col">
                <div class="card shadow-sm">
                    <img class="bd-placeholder-img card-img-top" width="100%" height="225"
                        src="https://source.unsplash.com/500x400/?' . $product_name . '" preserveAspectRatio="xMidYMid slice"
                        focusable="false">
                    <div class="card-body">
                        <h3 class="fw-bold">' . $product_name . '</h3>
                        <p class="card-text">Price - $' . $product_price . '</p>
                        <div class="d-flex justify-content-between align-items-center">
                        <form action="products.php?thread_id=' . $product_thread_id . '&product_id=' . $product_id . '" method="post">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">Add to cart</button>
                                <a class="text-decoration-none btn btn-sm btn-outline-secondary" type="submit" href="cart.php">View Cart</a>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>';
    }

    echo '</div>
    </div>
</div>';
}
?>

<?php
$user_id = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_GET["product_id"];

    if (isset($_SESSION["loggedIn"]) && ($_SESSION["loggedIn"] == true)) {
        $user_id = $_SESSION["user_id"];
    }
    // Get the product_id from the form
    $sql = "SELECT * FROM `products` WHERE product_id = $product_id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $product_name = $row["product_name"];
    $product_price = $row["product_price"];
    $timestamp = $row["timestamp"];

    $product_exists = "SELECT cart_product_id FROM `mycart` WHERE cart_product_id= '$product_id' AND host_ip = '$hostIp' AND `cart_user_id`='$user_id' ";
    $exists_query = mysqli_query($con, $product_exists);
    $numofrows = mysqli_num_rows($exists_query);
    if ($numofrows > 0) {
        $sql = "UPDATE `mycart` SET `quantity` = `quantity` + 1 WHERE `cart_product_id` = $product_id AND host_ip = '$hostIp' AND `cart_user_id`='$user_id' ;";
        $result = mysqli_query($con, $sql);
    } else {
        $sql = "INSERT INTO `mycart` (`cart_name`, `cart_price`,`quantity`,`host_ip`, `cart_product_id`, `cart_user_id`, `timestamp`)
             VALUES ('$product_name', '$product_price','1','$hostIp', '$product_id', '$user_id', current_timestamp());";

        $result = mysqli_query($con, $sql);
    }
    if ($result) {
        echo '<div class="alert alert-success my-0 alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Added to your cart.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    } else {
        echo '<div class="alert alert-danger my-0 alert-dismissible fade show" role="alert">
<strong>Fail!</strong>failed to add to cart.
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
}

?>

<?php
if (!isset($_GET["all_products"])) {
    $id = $_GET["thread_id"];
    $sql = "SELECT * FROM `threads` where thread_id=$id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $thread_title = $row["thread_title"];

    echo '<div class="album w-100 h-100 py-5 bg-body-tertiary">
        <h1 class="text-center mb-4">' . $thread_title . '</h1>
    <div class="container">
    <span></span>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';

    $sql = "SELECT * FROM `products` WHERE product_thread_id = $id ORDER BY RAND()";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row["product_id"];
        $product_name = $row["product_name"];
        $product_price = $row["product_price"];
        $timestamp = $row["timestamp"];


        echo   '<div class="col">
                <div class="card shadow-sm">
                    <img class="bd-placeholder-img card-img-top" width="100%" height="225"
                        src="https://source.unsplash.com/500x400/?' . $product_name . '" preserveAspectRatio="xMidYMid slice"
                        focusable="false">
                    <div class="card-body">
                        <h3 class="fw-bold">' . $product_name . '</h3>
                        <p class="card-text">Price - $' . $product_price . '</p>
                        <div class="d-flex justify-content-between align-items-center">
                        <form action="products.php?thread_id=' . $id . '&product_id=' . $product_id . '" method="post">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">Add to cart</button>
                                <a class="text-decoration-none btn btn-sm btn-outline-secondary" type="submit" href="cart.php">View Cart</a>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>';
    }

    echo '</div>
    </div>
</div>';
}
?>

<?php include "partials/_footer.php" ?>