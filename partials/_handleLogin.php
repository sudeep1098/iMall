<?php
$showError = "false";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "_dbconnect.php";
    $userEmail = $_POST["login_email"];
    $password = $_POST["login_password"];

    $existUser = "SELECT * FROM `users` WHERE user_email = '$userEmail'";
    $result = mysqli_query($con, $existUser);
    $numRows = mysqli_num_rows($result);
    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['user_password'])) {
            session_start();
            $_SESSION['loggedIn'] = true;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['userEmail'] = $userEmail;
            header("Location: /ecommerce/index.php?loginSuccess=true");
            exit; // Add this line to prevent further execution
        } else {
            $showError = "Invalid password";
        }
    } else {
        $showError = "Invalid Email";
    }

    // Redirect to the same page with an error parameter
    header("Location: /ecommerce/index.php?loginSuccess=false&showalert=$showError");
    exit; // Add this line to prevent further execution
}
