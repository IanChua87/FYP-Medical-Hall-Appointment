<?php
include '../db_connect.php';
include '../helper_functions.php';

cancel_past_appointments($conn);

mysqli_close($conn);