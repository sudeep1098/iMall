<?php include "partials/_dbconnect.php" ?>
<?php
include "partials/_header.php";
?>

<?php
echo '<style>
.container {
    background: #f5f5f5;
    margin-top: 20px;
}

.ui-w-80 {
    width: 80px !important;
    height: auto;
}

.btn-default {
    border-color: rgba(24, 28, 33, 0.1);
    background: rgba(0, 0, 0, 0);
    color: #4E5155;
}

label.btn {
    margin-bottom: 0;
}

.btn-outline-primary {
    border-color: #26B4FF;
    background: transparent;
    color: #26B4FF;
}

.btn {
    cursor: pointer;
}

.text-light {
    color: #babbbc !important;
}

.btn-twitter {
    border-color: rgba(0, 0, 0, 0);
    background: #CD5C08;
    color: #fff;
}
.btn-facebook {
    border-color: rgba(0, 0, 0, 0);
    background: #3B5998;
    color: #fff;
}

.btn-instagram {
    border-color: rgba(0, 0, 0, 0);
    background: #000;
    color: #fff;
}

.card {
    background-clip: padding-box;
    box-shadow: 0 1px 4px rgba(24, 28, 33, 0.012);
}

.row-bordered {
    overflow: hidden;
}

.account-settings-fileinput {
    position: absolute;
    visibility: hidden;
    width: 1px;
    height: 1px;
    opacity: 0;
}

.account-settings-links .list-group-item.active {
    font-weight: bold !important;
}

html:not(.dark-style) .account-settings-links .list-group-item.active {
    background: transparent !important;
}

.account-settings-multiselect~.select2-container {
    width: 100% !important;
}

.light-style .account-settings-links .list-group-item {
    padding: 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}

.light-style .account-settings-links .list-group-item.active {
    color: #4e5155 !important;
}

.material-style .account-settings-links .list-group-item {
    padding: 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}

.material-style .account-settings-links .list-group-item.active {
    color: #4e5155 !important;
}

.dark-style .account-settings-links .list-group-item {
    padding: 0.85rem 1.5rem;
    border-color: rgba(255, 255, 255, 0.03) !important;
}

.dark-style .account-settings-links .list-group-item.active {
    color: #fff !important;
}

.light-style .account-settings-links .list-group-item.active {
    color: #4E5155 !important;
}

.light-style .account-settings-links .list-group-item {
    padding: 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}
</style>';

$accountDeleted = false;
$img_alert = false;
$pass_alert = false;


if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
    $userId = $_SESSION["user_id"];
    $user_email = $_SESSION["userEmail"];
    if (isset($_GET["account"]) && $_GET["account"] == "deleted") {
        $sql = "DELETE FROM `users` WHERE `user_id` = $userId";
        $result = mysqli_query($con, $sql);

        if ($result) {
            session_unset();
            session_destroy();
            $accountDeleted = true;
        }
    }
    if ($accountDeleted) {
        echo '<div class="alert alert-success my-0 alert-dismissible fade show" role="alert">
                <strong>Account Deleted!</strong> Your account has been successfully deleted.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }

    list($username, $domain) = explode('@', $userEmail);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userId = $_SESSION["user_id"];
        $user_email = $_SESSION["userEmail"];
        $name = $_POST["name"];
        $user_email = $_POST["user_email"];
        $state = $_POST["state"];
        $country = $_POST["country"];
        $phone = $_POST["phone"];
        $zip = $_POST["zip"];
        $address = $_POST["address"];
        $sql = "UPDATE `users` SET `username`='$name', `user_email`='$user_email',`state`='$state', `country`='$country',`zip`='$zip',`address`='$address', `phone`='$phone' WHERE `user_id`='$userId'";
        $result = mysqli_query($con, $sql);

        // if (isset($_POST["delete_account"])) {

        if (isset($_POST["no"])) {
            $header = '<a class="list-group-item list-group-item-action active" data-toggle="list"
            href="#account-general">General</a>';
        }



        if (isset($_FILES["image"]) && isset($_POST["upload"])) {
            $img_name = $_FILES["image"]["name"];
            $img_size = $_FILES["image"]["size"];
            $tmp_name = $_FILES["image"]["tmp_name"];
            $error = $_FILES["image"]["error"];

            if ($error === 0) {
                if ($img_size > 125000) {
                    $img_alert = '<div class="alert alert-danger my-0 alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>Sorry file size too large.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                } else {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
                    $allowed_exs = array("jpg", "jpeg", "png");

                    if (in_array($img_ex_lc, $allowed_exs)) {
                        $new_img_name = uniqid("IMG-", true) . "." . $img_ex_lc;
                        $img_upload_path = "C:/xampp/htdocs/Ecommerce/user_images/" . $new_img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);

                        //update into database 
                        $sql = "UPDATE `users` SET `img`='$new_img_name' WHERE `user_id`='$userId'";
                        $result = mysqli_query($con, $sql);
                        if (!$result) {
                            $img_alert = '<div class="alert alert-danger my-0 alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>Upload failed.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        }
                    } else {
                        $img_alert = '<div class="alert alert-danger my-0 alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>You cant upload file of this type.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                }
            }
        }


        if (isset($_POST["password"]) && $_POST["new_password"] && $_POST["confirm_password"]) {
            $password = $_POST["password"];
            $new_password = $_POST["new_password"];
            $confirm_password = $_POST["confirm_password"];

            $sql = "SELECT user_password FROM `users` WHERE `user_id` = '$userId'";
            $result = mysqli_query($con, $sql);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $verify_password = password_verify($password, $row["user_password"]);

                if ($verify_password) {
                    if ($new_password == $confirm_password) {
                        $hash = password_hash($new_password, PASSWORD_DEFAULT);
                        $update_sql = "UPDATE `users` SET `user_password`='$hash' WHERE `user_id`='$userId'";
                        $update_result = mysqli_query($con, $update_sql);

                        if (!$update_result) {

                            $pass_alert = '<div class="alert alert-danger my-0 alert-dismissible fade show" role="alert">
                            <strong>Error Updating Password!</strong>There was an error updating your password.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                        }
                    } else {
                        $pass_alert = '<div class="alert alert-danger my-0 alert-dismissible fade show" role="alert">
                    <strong>Passwords do not match!</strong>Please make sure your new passwords match.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    }
                } else {

                    $pass_alert = '<div class="alert alert-danger my-0 alert-dismissible fade show" role="alert">
                    <strong>Wrong password!</strong>Check your current password again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            }
        }

        // Display success message only if user details update is successful

        if (!$accountDeleted) {
            if ($result) {
                if ($pass_alert) {
                    echo $pass_alert;
                } else {

                    echo '<div class="alert alert-success my-0 alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Successfully updated account details.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                }
            } else {
                echo '<div class="alert alert-danger my-0 alert-dismissible fade show" role="alert">
                <strong>Failed!</strong> Failed to update account details.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
        }
    }
    if (!$accountDeleted) {
        $sql = "SELECT * FROM `users` WHERE user_id = '$userId'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        $name = $row["username"];
        $user_email = $row["user_email"];
        $user_password = $row["user_password"];
        $img = $row["img"];
        $country = $row["country"];
        $state = $row["state"];
        $phone = $row["phone"];
        $zip = $row["zip"];
        $address = $row["address"];


        echo '
    <form class="form form-control" action="profile.php" method="post" enctype="multipart/form-data">
    
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4 text-center text-dark">
            Account settings
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Change password</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-info">Info</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-connections">Connections</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                                href="#account-delete">Account delete</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">';
        if ($img_alert) {
            echo $img_alert;
        }
        echo '<div class="card-body media align-items-center">';
        $img_sql = "SELECT img from `users` where user_id= '$userId'";
        $img_result = mysqli_query($con, $img_sql);
        $img_row = mysqli_fetch_assoc($img_result);
        $img = $img_row["img"];
        if ($img_result) {
            echo '<img src="user_images/' . $img . '" alt="" class="d-block ui-w-80">';
        }
        if (!$img) {
            echo '<img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="d-block ui-w-80">';
        }

        echo '<div class="media-body ml-4">
                                    <label class="btn btn-outline-primary">
                                        Upload new photo
                                        <input type="file" name="image"  class="account-settings-fileinput">
                                    </label> &nbsp;
                                    <button type="submit" class="btn btn-info md-btn-flat" name="upload">Set image</button>
                                    <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control mb-1" name="username" value="' . $username . '">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="' . $name . '">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">E-mail</label>
                                    <input type="text" class="form-control mb-1" name="user_email" value="' . $user_email . '">
                                </div>
                            
                            </div>
                        </div>';

        echo '<div class="tab-pane fade" id="account-change-password">
                    <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Current password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">New password</label>
                                    <input type="password" name="new_password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Repeat new password</label>
                                    <input type="password" name="confirm_password" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-info">
                            <div class="card-body pb-2">
                        
                                <div class="form-group">
                                    <label class="form-label mt-4">State</label>
                                    <select class="custom-select" name= "state" type="submit">
                                        <option>Haryana</option>
                                        <option selected>Ambala</option>
                                        <option>Punjab</option>
                                        <option>Rajasthan</option>
                                        <option>Benglore</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mt-4">Country</label>
                                    <select class="custom-select" name= "country" type="submit">
                                        <option>USA</option>
                                        <option selected>India</option>
                                        <option>UK</option>
                                        <option>Germany</option>
                                        <option>France</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Zip code</label>
                                    <input type="text" class="form-control" name="zip" value="' . $zip . '">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" value="' . $address . '">
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="' . $phone . '">
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="account-connections">
                            <div class="card-body">
                                <button type="button" class="btn btn-twitter">Connect to
                                    <strong>Twitter</strong></button>
                            </div>
                            <hr class="border-light m-0">

                            <div class="card-body">
                                <button type="button" class="btn btn-facebook">Connect to
                                    <strong>Facebook</strong></button>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <button type="button" class="btn btn-instagram">Connect to
                                    <strong>Instagram</strong></button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-delete">
                            <div class="card-body text-center" style="margin-top:5rem;"> 
                                <h4>Are you sure you want to delete this account</h4>
                                <a type="submit" href="profile.php?account=deleted" name="delete_account" class="btn btn-warning">
                                    <strong>Yes</strong></a>
                                <button class="btn btn-light" type="submit" name="no"><strong>No</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3 mb-5">
            <button type="submit" class="btn btn-primary">Save changes</button>&nbsp;
            <a href="profile.php"><button type="button" class="btn btn-default">Cancel</button></a>
        </div>
    </div>
            </div>
        </div>
        </form>
        ';
    } else {
        echo '<div class="container py-3 mt-4">
    <div class="p-5 mb-4 bg-body-tertiary rounded-4">
        <div class="container-fluid text-center py-5">
            <h1 class="display-5 fw-bold">Please Login or Signup</h1>
            <p class=" fs-4">Without signup or login this page is unavailable.</p>
        </div>
    </div>
</div>';
    }
} else {
    echo '<div class="container py-3 mt-4">
<div class="p-5 mb-4 bg-body-tertiary rounded-4">
    <div class="container-fluid text-center py-5">
        <h1 class="display-5 fw-bold">Please Login or Signup</h1>
        <p class=" fs-4">Without signup or login this page is unavailable.</p>
    </div>
</div>
</div>';
}
?>


<div style="display: none;">
    <?php include "partials/_footer.php" ?></div>