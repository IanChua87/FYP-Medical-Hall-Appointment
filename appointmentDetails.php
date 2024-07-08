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
    <title>Admin | Appointment</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include 'links.php'; ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <style>
        #sidebar.active {
            left: 0;
            width: 300px;
        }

        #sidebar {
            max-width: 300px;
            position: fixed;
            top: 0;
            left: -300px;
            height: 100vh;
            background: #682924;
            z-index: 999;
            transition: all 0.3s;
        }

        #content.active {
            margin-left: 300px;
        }

        #content{
            width: 100%;
            transition: margin-left 0.3s ease;
            margin-left: 0;
        }
    </style>
</head>

<body>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "pagingType": "numbers",
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 75],
            });
        });
    </script>
    <div class="main-content d-flex">
        <div class="sidebar" id="sidebar">
            <div class="header-box px-3 mt-2 mb-2 d-flex align-items-center justify-content-between">
                <h1 class="header">Sin Nam</h1>
                <!-- <button class="btn close-btn"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <ul class="mt-3">
                <li class=""><a href="#" class="text-decoration-none"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li class=""><a href="lastQueueNo.php" class="text-decoration-none"><i class="fa-solid fa-hourglass-start"></i> Last Queue No.</a></li>
                <li class=""><a href="staffDetails.php" class="text-decoration-none"><i class="fa-solid fa-user-doctor"></i> Edit Staff</a></li>
                <li class=""><a href="patientDetails.php" class="text-decoration-none"><i class="fa-solid fa-bed"></i> Edit Patient</a></li>
                <li class="active"><a href="appointmentDetails.php" class="text-decoration-none"><i class="fa-solid fa-calendar-check"></i> Edit Appointment</a></li>
                <div class="sidebar-separator"></div>
                <li class=""><a href="editSettings.php" class="text-decoration-none"><i class="fa-solid fa-gear"></i> Edit Settings</a></li>
            </ul>
        </div>
        <div class="content" id="content">
            <?php include 'adminNavbar.php' ?>
            <div class="appointment-table">
                <div class="container">
                    <h2 class="text-center">Appointment Details</h2>
                    <div class="table-responsive">
                        <table class="table table-striped" id="table">
                            <thead class="table-primary">
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Phone No.</th>
                                    <th>Appointment Date</th>
                                    <th>Appointment Time</th>
                                    <th>Status</th>
                                    <th>Take Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                $query = "SELECT * FROM patient P INNER JOIN appointment A ON P.patient_id = A.patient_id WHERE A.appointment_status != 'Completed' ORDER BY appointment_id ASC";
                                $appointment_stmt = mysqli_prepare($conn, $query);
                                if (!$appointment_stmt) {
                                    die("Failed to prepare statement");
                                } else {
                                    mysqli_stmt_execute($appointment_stmt);
                                    $result = mysqli_stmt_get_result($appointment_stmt);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $id = $row['appointment_id'];
                                            echo "<tr>";
                                            echo "<td>" . $row['patient_name'] . "</td>";
                                            echo "<td>" . $row['patient_phoneNo'] . "</td>";
                                            echo "<td>" . $row['appointment_date'] . "</td>";
                                            echo "<td>" . $row['appointment_start_time'] . "</td>";
                                            echo "<td>" . $row['appointment_status'] . "</td>";
                                            echo "<td>
                                            <div class='buttons'>
                                                <a href='editAppointment.php?appointment_id=" . $row['appointment_id'] . "' class='btn edit-btn'>Edit</a>
                                                <button class='btn delete-btn' data-bs-toggle='modal' data-bs-target='#delete-modal' data-id='" . $row['appointment_id'] . "'>Delete</button>
                                            </div>
                                        </td>";
                                            echo "</tr>";
                                        }
                                    }
                                }
                                ?>
                                <a href='addAppointment.php' class='btn add-btn'>Add</a>
                            </tbody>
                        </table>

                        <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="delete-modal-label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="delete-modal-label">Warning<span>!</span></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="modal-text">Are you sure you want to delete the appointment record? <br> This action cannot be undone.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="doDeleteAppointment.php" id="delete-form" method="POST">
                                            <input type="hidden" name="appointment_id" id="appointment_id" value="">
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
</body>

<script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function() {
            var appointmentId = $(this).data('id');
            $('#appointment_id').val(appointmentId);
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

<?php include 'sessionMsg.php' ?>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#session-msg').fadeOut('slow');
        }, 1700);
    });
</script>


</html>