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
    <title>Admin | Patient</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include 'links.php'; ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style.css" />
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
    <section class="patient-table">
        <div class="container">
            <h2 class="text-center">Patient Details</h2>
            <div class="table-responsive">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th scope="col">Patient ID</th>
                            <th scope="col">Patient Name</th>
                            <th scope="col">Patient DOB</th>
                            <th scope="col">Patient Phone No</th>
                            <th scope="col">Patient Email</th>
                            <th scope="col">Patient Status</th>
                            <th scope="col">Last Updated By</th>
                            <th scope="col">Last Updated Datetime</th>
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
                                    echo "<td>" . $row['patient_id'] . "</td>";
                                    echo "<td>" . $row['patient_name'] . "</td>";
                                    echo "<td>" . $row['patient_dob'] . "</td>";
                                    echo "<td>" . $row['patient_phoneNo'] . "</td>";
                                    echo "<td>" . $row['patient_email'] . "</td>";
                                    echo "<td>" . $row['patient_status'] . "</td>";
                                    echo "<td>" . $row['last_updated_by'] . "</td>";
                                    echo "<td>" . $row['last_updated_datetime'] . "</td>";
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
    </section>

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

    <?php include 'sessionMsg.php' ?>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#session-msg').fadeOut('slow');
            }, 1700);
        });
    </script>
</body>

</html>