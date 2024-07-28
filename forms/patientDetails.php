<?php
ob_start();
session_start();
include "../db_connect.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Patient</title>
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        th,
        td {
            word-wrap: break-word;
        }

        #dt-length-0 {
            padding: 4px 8px;
        }

        #dt-length-0 label {
            font-size: 10px;
        }

        .session-msg-success {
            margin-top: 20px;
        }

        #sidebar{
            min-height: 1200px;
        }
    </style>
</head>

<body>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                scrollX: false,
                "pagingType": "numbers",
                "pageLength": 10,
                "lengthMenu": [10, 20, 40, 60],
                "searching": true,
                "info": false,
                "lengthChange": true,
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
                <li class=""><a href="../adminDashboard.php" class="text-decoration-none outer"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li class="active"><a href="patientDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-bed"></i> View Patient</a></li>
                <li class=""><a href="appointmentDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-calendar-check"></i> View Appointment</a></li>
                <li class=""><a href="staffDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-user-doctor"></i> View Staff</a></li>
                <li class=""><a href="settings.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Settings</a></li>
                <li class=""><a href="viewHoliday.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Holiday</a></li>
                <li class=""><a href="contactDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-envelope"></i> View Contact</a></li>
                <div class="sidebar-separator"></div>
                <li class="mt-auto"><a href="loggedOutSuccessful.php" class="text-decoration-none logout-btn outer"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </div>

        <div class="content" id="content">
            <div class="patient-table stripped">
                <div class="container-fluid">
                    <div class="search-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="text-center">Patient Details</h2>
                            <a href='addPatient.php' class='btn add-btn'>Add</a>
                        </div>
                    </div>
                    <div class="table-card">

                        <div class="table-responsive">
                            <table class="table m-0" id="table">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">DOB</th>
                                        <th scope="col">Phone No</th>
                                        <th scope="col">Email</th>
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
                                                echo "<td class='affect'>" . $row['patient_name'] . "</td>";
                                                echo "<td class='affect'>" . date("d/m/Y", strtotime($row['patient_dob'])) . "</td>";
                                                echo "<td class='affect'>" . $row['patient_phoneNo'] . "</td>";
                                                echo "<td class='affect'>" . $row['patient_email'] . "</td>";
                                                echo "<td class='affect'>" . $row['patient_status'] . "</td>";
                                                echo "<td class='affect'>" . $row['payment_status'] . "</td>";
                                                echo "<td class='affect'>" . $row['amount_payable'] . "</td>";
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
                                </tbody>
                            </table>
                        </div>


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
                    <?php include '../sessionMsg.php' ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
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

    </script>
</body>

</html>