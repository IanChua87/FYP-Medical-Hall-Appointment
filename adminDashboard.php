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
    <link rel="stylesheet" href="style.css" />
    
</head>

<body>
    <div class="main-content d-flex">
        <div class="sidebar" id="sidebar">
            <div class="header-box px-3 mt-2 mb-2 d-flex align-items-center justify-content-between">
                <h1 class="header">Sin Nam</h1>
                <!-- <button class="btn close-btn"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <ul class="mt-3">
                <li class="active"><a href="#" class="text-decoration-none"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li class=""><a href="lastQueueNo.php" class="text-decoration-none"><i class="fa-solid fa-hourglass-start"></i> Last Queue No.</a></li>
                <li class=""><a href="staffDetails.php" class="text-decoration-none"><i class="fa-solid fa-user-doctor"></i> Edit Staff</a></li>
                <li class=""><a href="patientDetails.php" class="text-decoration-none"><i class="fa-solid fa-bed"></i> Edit Patient</a></li>
                <li class=""><a href="appointmentDetails.php" class="text-decoration-none"><i class="fa-solid fa-calendar-check"></i> Edit Appointment</a></li>
                <div class="sidebar-separator"></div>
                <li class=""><a href="editSettings.php" class="text-decoration-none"><i class="fa-solid fa-gear"></i> Edit Settings</a></li>
            </ul>
        </div>

        <div class="content" id="content">
            <?php include 'adminNavbar.php' ?>
            <div class="section">
                <div class="admin-box">
                    <h2>Admin Dashboard</h2>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="card mb-4 h-100 info">
                                <div class="row g-0">
                                    <div class="col-md-4 col-sm-12">
                                        <img src="img/queue (2).svg" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <div class="card-body">
                                            <h5 class="card-title">Queue No.</h5>
                                            <p class="card-text">Admin can check the last appointment queue number of the patient</p>
                                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="card mb-4 h-100 info">
                                <div class="row g-0">
                                    <div class="col-md-4 col-sm-12">
                                        <img src="img/doctor.svg" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <div class="card-body">
                                            <h5 class="card-title">Edit Doctor</h5>
                                            <p class="card-text">Admin can have access to patient details </p>
                                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="card mb-4 h-100 info">
                                <div class="row g-0">
                                    <div class="col-md-4 col-sm-12">
                                        <img src="img/patient-mask.svg" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <div class="card-body">
                                            <h5 class="card-title">Edit Patient</h5>
                                            <p class="card-text">Patient's personal information such as password and phone number can be updated</p>
                                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="card mb-4 h-100 info">
                                <div class="row g-0">
                                    <div class="col-md-4 col-sm-12">
                                        <img src="img/appointment.svg" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <div class="card-body">
                                            <h5 class="card-title">Edit Appointment</h5>
                                            <p class="card-text">Admin can manage the appointment of patients such as adding, deleting or updating it on their behalf if they don't know how to do so.</p>
                                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">User Table</h5>
                                    <?php
                                    $users_arr = [];

                                    $u_query = "SELECT user_id, user_name, user_email, role FROM users";

                                    $user_stmt = mysqli_prepare($conn, $u_query);

                                    if (!$user_stmt) {
                                        die("Failed to prepare statement");
                                    } else {
                                        mysqli_stmt_execute($user_stmt);
                                        $u_result = mysqli_stmt_get_result($user_stmt);

                                        if (mysqli_num_rows($u_result) > 0) {
                                            while ($row = mysqli_fetch_assoc($u_result)) {
                                                $users_arr[] = $row;
                                            }
                                        }
                                    }
                                    ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <!-- <th scope="row">1</th>
                                                <td>John Doe</td>
                                                <td>john@example.com</td>
                                                <td>Admin</td>
                                                <td> -->
                                                <?php
                                                for ($i = 0; $i < count($users_arr); $i++) {

                                                ?>
                                                    <td><?php echo $users_arr[$i]['user_id'] ?></td>
                                                    <td><?php echo $users_arr[$i]['user_name'] ?></td>
                                                    <td><?php echo $users_arr[$i]['user_email'] ?></td>
                                                    <td><?php echo $users_arr[$i]['role'] ?></td>
                                                    <td>
                                                        <?php
                                                        if ($users_arr[$i]['role'] == 'Doctor') {
                                                            echo '<a href="editStaff.php?user_id=' . $users_arr[$i]['user_id'] . '" class="btn edit-btn">Edit</a>';
                                                            echo '<a href="doDeleteStaff.php" class="btn delete-btn" data-bs-toggle="modal" data-bs-target="#delete-modal" data-id="' . $users_arr[$i]['user_id'] . '">Delete</a>';
                                                        }
                                                        ?>
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
                                                    <h5 class="modal-title" id="delete-modal-label">Warning<span>!</span></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="modal-text">Are you sure you want to delete the staff record? <br> This action cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="doDeleteStaff.php" id="delete-form" method="POST">
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
        
        $('#sidebarToggle').on('click', function() {
            $('#sidebar').toggleClass('active');
            $('#content').toggleClass('active');
        });
    </script>

</body>

</html>