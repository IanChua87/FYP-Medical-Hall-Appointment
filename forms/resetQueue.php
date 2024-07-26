<?php
include '../db_connect.php';
include '../helper_functions.php';

reset_queue_number_for_next_day($conn);

mysqli_close($conn);