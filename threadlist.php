<?php include "partials/_dbconnect.php" ?>
<?php include "partials/_header.php" ?>

<?php
$id = $_GET["catid"];

$sql = "SELECT * FROM `categories` where category_id= $id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$cat_name = $row["category_name"];
echo '<div class="album  w-100 h-100 py-5 bg-body-tertiary">
    <h1 class="text-center mb-4">' . $cat_name . '</h1>
    
    <div class="container">
    
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';

$sql = "SELECT * FROM `threads` WHERE thread_cat_id= $id";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $thread_id = $row["thread_id"];
    $thread_title = $row["thread_title"];
    $thread_desc = $row["thread_desc"];
    $timestamp = $row["timestamp"];

    echo   '<div class="col">
                <div class="card shadow-sm">
                    <img class="bd-placeholder-img card-img-top" width="100%" height="225"
                        src="https://source.unsplash.com/500x400/?' . $thread_title . '" preserveAspectRatio="xMidYMid slice"
                        focusable="false">
                    <div class="card-body">
                        <h3 class="fw-bold">' . $thread_title . '</h3>
                        <p class="card-text">' . $thread_desc . '</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="text-decoration-none btn btn-sm btn-outline-secondary" type="submit" href="products.php?thread_id=' . $thread_id . '">view</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
}
?>
</div>
</div>
</div>


<?php include "partials/_footer.php" ?>