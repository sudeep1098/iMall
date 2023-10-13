<?php session_start(); ?>
<?php $hostIp = $_SERVER['SERVER_ADDR']; ?>
<?php include "_dbconnect.php"; ?>
<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="https://getbootstrap.com/docs/5.3/assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iMall - Buy anything! </title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dropdowns/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <meta name="theme-color" content="#712cf9">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>
    <script src="https://kit.fontawesome.com/084f6e564a.js" crossorigin="anonymous"></script>
</head>


<body>
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
        </symbol>
    </svg>
    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
                <use href="#circle-half"></use>
            </svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                        <use href="#sun-fill"></use>
                    </svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                        <use href="#moon-stars-fill"></use>
                    </svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                        <use href="#circle-half"></use>
                    </svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em">
                        <use href="#check2"></use>
                    </svg>
                </button>
            </li>
        </ul>
    </div>

    <?php
    echo '<nav class=" navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid mx-auto" style="width:90%">
        <a class="navbar-brand" href="index.php">iMall</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">My Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="products.php?all_products">All Products</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle me-3" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu">';

    $sql = "SELECT * from `categories`";
    $result = mysqli_query($con, $sql);
    $numofrows = mysqli_num_rows($result);
    $randomNumber = rand(1, $numofrows);
    while ($row = mysqli_fetch_assoc($result)) {
        $cat_id = $row["category_id"];
        $cat_name = $row["category_name"];
        echo '<li><a class="dropdown-item" href="threadlist.php?catid=' . $cat_id . '">' . $cat_name . '</a></li>';
    }
    echo '<li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="threadlist.php?catid=' . $randomNumber . '">Random Category</a></li>
                        </ul>
                    </li>';

    echo '
    <form class="d-flex justify-content-between align-items-center " role="search" method="get" action="search.php">
        <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    ';


    $user_id = 0;
    if (isset($_SESSION["loggedIn"]) && ($_SESSION["loggedIn"] == true)) {
        $user_id = $_SESSION["user_id"];
        $sql = "UPDATE `mycart` SET `cart_user_id` = $user_id WHERE host_ip = '$hostIp' AND `cart_user_id`=0;";
        $result = mysqli_query($con, $sql);
    }

    $sql = "SELECT * FROM `mycart` WHERE host_ip = '$hostIp' AND `cart_user_id`='$user_id';";
    $result = mysqli_query($con, $sql);
    $numofrows = mysqli_num_rows($result);
    if ($numofrows > 0) {
        echo   '<li class="nav-item ">
        <a class="nav-link ps-3 mx-1 px-2" href="cart.php"><i class="fa-solid fa-cart-shopping"><span class="rounded-5 text-light"> ' . $numofrows . '</span></i></a>
    </li>';
    } else {
        echo   '<li class="nav-item ">
        <a class="nav-link ms-4 px-2 mx-1" href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
    </li>';
    }
    if (isset($_SESSION["loggedIn"]) && ($_SESSION["loggedIn"] == true)) {
        $user_id = $_SESSION["user_id"];
    }
    $sql = "SELECT * FROM `orders` WHERE user_id=$user_id";
    $result = mysqli_query($con, $sql);
    $numofrows = mysqli_num_rows($result);
    if ($numofrows > 0) {
        echo   '<li class="nav-item ">
        <a class="nav-link pe-0 mx-1 px-2" href="orders.php">My Orders <span class="rounded-5 text-light">' . $numofrows . '</span></a>
    </li>';
    } else {
        echo '<li class="nav-item ">
                <a class="nav-link px-2 mx-2" href="orders.php">My Orders</a>
        </li></ul>';
    }

    //   Button trigger modal
    if (isset($_SESSION["loggedIn"]) && ($_SESSION["loggedIn"] == true)) {
        $user_id = $_SESSION["user_id"];
        $userEmail = $_SESSION["userEmail"];
        list($username, $domain) = explode('@', $userEmail);
        echo '
                <a href="profile.php" class="btn btn-dark mx-2 ms-3" type="submit">Welcome ' . $username . '</a>
                <a href="partials/_handlelogout.php" class="btn btn-primary ms-3" type="submit">Logout</a>
                ';
    } else {

        echo '
        <div class="mx-2">
                    <button type="button" class="btn btn-primary me-3" style="width:5rem" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Login
                    </button>
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#signupModal">
                        Signup
                    </button>
                </div>';
    }

    echo '</div>
        </div>
    </nav>';
    ?>
    <?php include "partials/_loginmodal.php" ?>
    <?php include "partials/_signupmodal.php" ?>

    <?php
    if (isset($_GET['signupSuccess']) && ($_GET['signupSuccess'] == "true")) {

        echo '<div class="alert alert-success my-0 alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your account is signed up.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    if (isset($_GET['signupSuccess']) && $_GET['signupSuccess'] == "false") {
        $showalert = $_GET['showalert'];
        echo '<div class="alert alert-warning my-0 alert-dismissible fade show" role="alert">
        <strong>Failed to Signup!</strong> ' . $showalert . '.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if (isset($_GET['loginSuccess']) && $_GET['loginSuccess'] == "true") {
        echo '<div class="alert alert-success my-0 alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your account is logged in.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if (isset($_GET['loginSuccess']) && $_GET['loginSuccess'] == "false") {
        $showalert = $_GET['showalert'];
        echo '<div class="alert alert-warning my-0 alert-dismissible fade show" role="alert">
        <strong>Failed to Login!</strong> ' . $showalert . '.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if (isset($_GET["payment"]) && $_GET["payment"] == "success") {
        echo '<div class="alert alert-success my-0 alert-dismissible fade show" role="alert">
        <strong>Order Complete</strong> Your order will be arriving soon.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close""></button>
    </div>
    ';
    }
    if (isset($_GET["payment"]) && $_GET["payment"] == "failed") {
        echo '<div class="alert alert-warning my-0 alert-dismissible fade show" role="alert">
        <strong>Order Failed</strong> Some unexpected problem occured please try again.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close""></button>
    </div>
    ';
    }
    ?>