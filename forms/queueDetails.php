<?php
session_start();
include "../db_connect.php";


if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
if(isset($_GET['queue_no'])){
    $queue_no = $_GET['queue_no'];
} else{
    header("Location: checkQueue.php");
    exit();

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Queue Details</title>
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
</head>

<body>
    <div class="queue" id="queue">
        <div class="queue-container">
            <div class="queue-wrapper">
                <h1 class="queue-title">Queue Details</h1>
                <div class="queue_no-wrapper">
                    <h2 class="queue_no"><?php echo $queue_no ?></h2>
                </div>
                <div class="buttons">
                    <a href="checkQueue.php" class="back-btn">Go Back</a>
                </div>
            </div>
            <?php include '../sessionMsg.php' ?>
        </div>
    </div>
</body>

</html>