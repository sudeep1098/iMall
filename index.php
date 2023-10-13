<?php include "partials/_dbconnect.php" ?>
<?php include "partials/_header.php" ?>

<div id="carouselExampleIndicators" class="carousel slide">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/slider1.jpg" class="d-block w-100" height="500" alt="...">
        </div>
        <div class="carousel-item">
            <img src="img/slider2.jpg" class="d-block w-100" height="500" alt="...">
        </div>
        <div class="carousel-item">
            <img src="img/slider3.jpg" class="d-block w-100" height="500" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<?php

echo
'<div class="album w-100 h-100 py-5 bg-body-tertiary">
    <h1 class="text-center mb-4 mt-1">All Categories</h1>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">';
        
$sql = "SELECT * FROM `categories`";
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $catid = $row["category_id"];
    $catname = $row["category_name"];
    $catdesc = $row["category_desc"];

    echo   '<div class="col">
                <div class="card shadow-sm">
                    <img class="bd-placeholder-img card-img-top" width="100%" height="225"
                        src="https://source.unsplash.com/500x400/?' . $catname . '" preserveAspectRatio="xMidYMid slice"
                        focusable="false">
                    <div class="card-body">
                        <h3 class="fw-bold">' . $catname . '</h3>
                        <p class="card-text">' . $catdesc . '</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a class="text-decoration-none btn btn-sm btn-outline-secondary" type="submit" href="threadlist.php?catid=' . $catid . '">view</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
}

echo "</div>
</div>
</div>";

?>



<?php include "partials/_footer.php" ?>