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
    <title>Admin Dashboard</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include 'links.php'; ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../style.css" />
    <style>
        .info:hover, .p-table-row:hover{
            cursor: pointer;
        }

        #table{
            border: none;
        }

    </style>

</head>

<body>
    <div class="main-content d-flex 100-vh">
        <div class="sidebar" id="sidebar">
            <div class="header-box px-3 mt-2 mb-2 d-flex align-items-center justify-content-between">
                <h1 class="header">Sin Nam</h1>
                <!-- <button class="btn close-btn"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <ul class="mt-3">
                <li class="active"><a href="adminDashboard.php" class="text-decoration-none outer"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li class=""><a href="forms/checkQueue.php" class="text-decoration-none outer"><i class="fa-solid fa-hourglass-start"></i> Check Queue No.</a></li>
                <li class=""><a href="forms/staffDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-user-doctor"></i> View Staff</a></li>
                <li class=""><a href="forms/patientDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-bed"></i> View Patient</a></li>
                <li class=""><a href="forms/appointmentDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-calendar-check"></i> View Appointment</a></li>
                <li class=""><a href="forms/settings.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Settings</a></li>
                <div class="sidebar-separator"></div>
                <li class="mt-auto"><a href="forms/loggedOutSuccessful.php" class="text-decoration-none logout-btn outer"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </div>

        <div class="content" id="content">
            <div class="section">
                <div class="container-fluid">
                    <div class="header-title-bg">
                        <h2 class="text-center">Admin Dashboard</h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card mb-4 h-100 info" data-href="forms/checkQueue.php">
                                <div class="row g-0 d-flex align-items-center">
                                    <div class="col-md-4 col-sm-12">
                                        <i class="fas fa-list-ol"></i>
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <div class="card-body">
                                            <h5 class="card-title">View Queue No.</h5>

                                            <p class="card-text">Check the last appointment queue number of current day</p>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card mb-4 h-100 info" data-href="forms/patientDetails.php">
                                <div class="row g-0 d-flex align-items-center">
                                    <div class="col-md-4 col-sm-12">
                                        <i class="fas fa-hospital-user"></i>
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <div class="card-body">
                                            <h5 class="card-title">View Patient</h5>
                                            <p class="card-text">Patient's personal particulars can be viewed, added, updated and deleted</p>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card mb-4 h-100 info" data-href="forms/appointmentDetails.php">
                                <div class="row g-0 d-flex align-items-center">
                                    <div class="col-md-4 col-sm-12">
                                        <i class="fa-solid fa-calendar-check"></i>
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <div class="card-body">
                                            <h5 class="card-title">View Appointment</h5>
                                            <p class="card-text">Appointment can be added, deleted and modified if needed</p>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card mb-4 h-100 info" data-href="forms/staffDetails.php">
                                <div class="row g-0 d-flex align-items-center">
                                    <div class="col-md-4 col-sm-12">
                                        <i class="fa-solid fa-user-tie"></i>
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <div class="card-body">
                                            <h5 class="card-title">View Staff</h5>
                                            <p class="card-text">Appointment can be added, deleted and modified if needed</p>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card p-table-row">
                                <div class="card-body">
                                    <h5 class="card-title">Patient Table</h5>
                                    <?php
                                    $patient_arr = [];

                                    $p_query = "SELECT * FROM patient ORDER BY patient_id ASC";

                                    $patient_stmt = mysqli_prepare($conn, $p_query);

                                    if (!$patient_stmt) {
                                        die("Failed to prepare statement");
                                    } else {
                                        mysqli_stmt_execute($patient_stmt);
                                        $p_result = mysqli_stmt_get_result($patient_stmt);

                                        if (mysqli_num_rows($p_result) > 0) {
                                            while ($row = mysqli_fetch_assoc($p_result)) {
                                                $patient_arr[] = $row;
                                            }
                                        }
                                    }
                                    ?>
                                    <table class="table table-striped mt-4">
                                        <thead class="table-primary">
                                            <tr>
                                                <th scope="col">Name</th>

                                                <th scope="col">Phone No</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Patient Status</th>
                                                <th scope="col">Payment Status</th>
                                                <th scope="col">Amount Payable</th>
                                                <th scope="col">Take Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <?php
                                                for ($i = 0; $i < count($patient_arr); $i++) {

                                                ?>
                                                    <td><?php echo $patient_arr[$i]['patient_name'] ?></td>
                                                    <td><?php echo $patient_arr[$i]['patient_phoneNo'] ?></td>
                                                    <td><?php echo $patient_arr[$i]['patient_email'] ?></td>
                                                    <td><?php echo $patient_arr[$i]['patient_status'] ?></td>
                                                    <td><?php echo $patient_arr[$i]['payment_status'] ?></td>
                                                    <td><?php echo $patient_arr[$i]['amount_payable'] ?></td>
                                                    <td>

                                                            <div class="buttons">
                                                                <a href="forms/editPatient.php?patient_id=<?php echo $patient_arr[$i]['patient_id'] ?>" class="btn edit-btn">Edit</a>
                                                                <a href="forms/deletePatient.php" class="btn delete-btn" data-bs-toggle="modal" data-bs-target="#delete-modal" data-id="<?php echo $patient_arr[$i]['patient_id'] ?>">Delete</a>
                                                            </div>
                                                        
                                                    </td>
                                            </tr>
                                        </tbody>
                                    <?php
                                                }
                                    ?>
                                    </table>

                                    <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="delete-modal-label" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" style="color: #ff4b3e" id="delete-modal-label">Warning</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="modal-text">Are you sure you want to delete the staff record? <br> This action cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="forms/doDeleteStaff.php" id="delete-form" method="POST">
                                                        <input type="hidden" name="user_id" id="user_id" value="">
                                                        <button type="submit" class="btn yes-btn">Yes</button>
                                                        <button type="button" class="btn no-btn" data-bs-dismiss="modal">No</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var userId = $(this).data('id');
                $('#user_id').val(userId);
            });

            $('.yes-btn').on('click', function() {
                $('#delete-form').submit();
            });
        });

        $(document).ready(function(){
            $(".info").click(function() {
                window.location.href = $(this).data("href");
            });
        });

        // $('#sidebarToggle').on('click', function() {
        //     $('#sidebar').toggleClass('active');
        //     $('#content').toggleClass('active');
        // });
    </script>

</body>

</html>