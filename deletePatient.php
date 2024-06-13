<?php 
session_start();
include "db_connect.php";
?>

<?php 
if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Delete Patient</title>
</head>
<body>
    
</body>
</html>