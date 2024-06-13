<?php
$host = "127.0.0.1:3307";
$username = "root";
$password = "";
$dbname = "fyp_sin_nam";

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>