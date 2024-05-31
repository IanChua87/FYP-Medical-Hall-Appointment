<?php
$host = "localhost:3304";
$username = "root";
$password = "";
$dbname = "fyp_sinnam";

// Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>