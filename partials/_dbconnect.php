<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "ecommerce";

$con = mysqli_connect($server, $username, $password, $database);

if (!$con) {
    die("Failed to connect to db");
}