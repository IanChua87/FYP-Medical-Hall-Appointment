<?php
session_start();
include "../db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Patient</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../style.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
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
                <li class=""><a href="../adminDashboard.php" class="text-decoration-none"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li class=""><a href="lastQueueNo.php" class="text-decoration-none"><i class="fa-solid fa-hourglass-start"></i> Last Queue No.</a></li>
                <li class=""><a href="staffDetails.php" class="text-decoration-none"><i class="fa-solid fa-user-doctor"></i> Staff Table</a></li>
                <li class="active"><a href="patientDetails.php" class="text-decoration-none"><i class="fa-solid fa-bed"></i> Patient Table</a></li>
                <li class=""><a href="appointmentDetails.php" class="text-decoration-none"><i class="fa-solid fa-calendar-check"></i> Appointment Table</a></li>
                <div class="sidebar-separator"></div>
                <li class=""><a href="editSettings.php" class="text-decoration-none"><i class="fa-solid fa-gear"></i> Settings</a></li>
            </ul>
        </div>
        <div class="content" id="content">
            <?php include '../adminNavbar.php' ?>
            <div class="patient-table">
                <div class="container">
                    <h2 class="text-center">Patient Details</h2>
                    <div class="table-responsive">
                        <table class="table table-striped" id="table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">Patient Name</th>
                                    <th scope="col">Patient DOB</th>
                                    <th scope="col">Patient Phone No</th>
                                    <th scope="col">Patient Email</th>
                                    <th scope="col">Patient Status</th>
                                    <th scope="col">Payment Status</th>
                                    <th scope="col">Amount Payable</th>
                                    <th scope="col-2">Take Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM patient ORDER BY patient_id ASC";
                                $patient_stmt = mysqli_prepare($conn, $query);
                                if (!$patient_stmt) {
                                    die("Failed to prepare statement");
                                } else {
                                    mysqli_stmt_execute($patient_stmt);
                                    $result = mysqli_stmt_get_result($patient_stmt);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['patient_name'] . "</td>";
                                            echo "<td>" . $row['patient_dob'] . "</td>";
                                            echo "<td>" . $row['patient_phoneNo'] . "</td>";
                                            echo "<td>" . $row['patient_email'] . "</td>";
                                            echo "<td>" . $row['patient_status'] . "</td>";
                                            echo "<td>" . $row['payment_status'] . "</td>";
                                            echo "<td>" . $row['amount_payable'] . "</td>";
                                            echo "<td>
                                                    <div class='buttons'>
                                                        <a href='editPatient.php?patient_id=" . $row['patient_id'] . "' class='btn edit-btn'>Edit</a>
                                                        <a href='deletePatient.php' class='btn delete-btn' data-bs-toggle='modal' data-bs-target='#delete-modal' data-id='" . $row['patient_id'] . "'>Delete</a>
                                                    </div>
                                                </td>";

                                            echo "</tr>";
                                        }
                                    }
                                }
                                ?>
                                <a href='addPatient.php' class='btn add-btn'>Add</a>
                            </tbody>
                        </table>
                        <?php include '../sessionMsg.php' ?>

                        <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="delete-modal-label" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="delete-modal-label">Warning<span>!</span></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="modal-text">Are you sure you want to delete the patient record? <br> This action cannot be undone.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="doDeletePatient.php" id="delete-form" method="POST">
                                            <input type="hidden" name="patient_id" id="patient_id" value="">
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


    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var patientId = $(this).data('id');
                $('#patient_id').val(patientId);
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

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#session-msg-success').fadeOut('slow');
            }, 1700);
            
        });
    </script>
</body>

</html>