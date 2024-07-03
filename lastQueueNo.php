<?php
session_start();
include "db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}

$q_query = "SELECT * FROM appointment WHERE appointment_date = CURDATE()
ORDER BY queue_no DESC 
LIMIT 1";
$queue_stmt = mysqli_prepare($conn, $q_query);
if(!$queue_stmt){
    die("Failed to prepare statement");
} else{
    mysqli_stmt_execute($queue_stmt);
    $result = mysqli_stmt_get_result($queue_stmt);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $queue_no = $row['queue_no'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Queue No.</title>
    <?php include 'links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
</head>
<body>
    <?php include 'adminNavbar.php'; ?>
    <div class="queue-no">
        <h1>Queue No.</h1>
        <div class="queue-box">
            <h2>Now Serving</h2>
            <div class="queue-wrapper">
                <h3><?php echo $queue_no ?></h3>
            </div>
        </div>
    </div>
</body>
</html>