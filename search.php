<?php include "partials/_dbconnect.php" ?>
<?php include "partials/_header.php" ?>


<?php
$searchResult = $_GET["search"];
if ($searchResult) {

    $sql = "SELECT * FROM `products` where product_name LIKE '%$searchResult%'";
    $result = mysqli_query($con, $sql);
    $numofrows = mysqli_num_rows($result);
    $noResult = true;
    if ($numofrows != 0) {
        echo '<div class="album w-100 h-100 py-5 bg-body-tertiary">
    <div class="container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    ';
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $noResult = false;
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
                            <p class="card-text">' . $product_price . '</p>
                            <div class="d-flex justify-content-between align-items-center">
                            <form action="products.php?thread_id=' . $product_thread_id . '&product_id=' . $product_id . '" method="post">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">Add to cart</button>
                                <a class="text-decoration-none btn btn-sm btn-outline-secondary" type="submit" href="cart.php">Buy</a>
                            </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            ';
    }
    if ($numofrows != 0) {
        echo '
        </div>
        </div>
        </div>';
    }
}
if ($noResult) {
    echo '<div class="container" style="margin-top: 3rem;">
    <h1 class="text-center">Search results</h1>
    <div class="p-5 mb-4 bg-body-tertiary rounded-5">
        <div class="container-fluid text-center py-5">
            <h1 class="display-5 fw-bold">No Search Result</h1>
            <p class=" fs-4">Try something different.</p>
        </div>
    </div>
</div>';
}
?>

<div class="position-absolute bottom-0 container-fluid">
    <?php include "partials/_footer.php" ?></div>