<?php
// $host = "localhost:3304";
// $username = "root";
// $password = "";
// $dbname = "fyp_sin_nam";

// // Create connection
// $conn = mysqli_connect($host, $username, $password, $dbname);

// // Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }


$conn = mysqli_init();

mysqli_ssl_set($conn, NULL, NULL, "", NULL, NULL);

$host = 'sinnammed001server.mysql.database.azure.com';
$username = 'turkdhuewv';
$password = 'RYzd9GjQ43$Y56RZ';
$database = 'fyp_sin_nam';
$port = 3306;

mysqli_real_connect($conn, $host, $username, $password, $database, $port, NULL, MYSQLI_CLIENT_SSL);
