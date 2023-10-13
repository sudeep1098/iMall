<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    include "_dbconnect.php";
    $email = $_POST["signup_email"];
    $password = $_POST["signup_password"];
    $cPass = $_POST["cPass"];

    // Initialize variables
    $success = "true";
    $showalert = "";

    // Sanitize the email input
    $email = mysqli_real_escape_string($con, $email);

    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $success = "false";
        $showalert = "Invalid email format";
        header("Location: /index.php?showalert=$showalert&signupSuccess=$success");
        exit(); // Exit to prevent further execution
    }

    // Check if the email already exists
    $existssql = "SELECT user_email FROM `users` WHERE user_email = '$email'";
    $result = mysqli_query($con,$existssql);

    if (mysqli_num_rows($result) > 0) {
        $success = "false";
        $showalert = "Email already exists";
        header("Location: /index.php?showalert=$showalert&signupSuccess=$success");
        exit(); // Exit to prevent further execution
    }
    // Check if passwords match
    else{ 
        if($password === $cPass) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users` (`user_email`, `user_password`, `timestamp`) VALUES ('$email', '$hash', current_timestamp())";
        $result = mysqli_query($con,$sql);

        if ($result) {
            header("Location: /index.php?signupSuccess=$success");
        } else {
            $success = "false";
            $showalert = "Registration failed";
            header("Location: /index.php?showalert=$showalert&signupSuccess=$success");
        }
    } else {
        $success = "false";
        $showalert = "Passwords do not match";
        header("Location: /index.php?showalert=$showalert&signupSuccess=$success");
        }
    }
}
?>
