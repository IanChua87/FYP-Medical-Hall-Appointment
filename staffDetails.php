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
    <title>Admin | Staff</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include 'links.php'; ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <style>
        .pagination .page-item.active .page-link {
            background-color: #682924;
            border: none;
        }

        .pagination .page-item.active .page-link:hover {
            background-color: #A34039;
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
                "color": "red"

            });
        });
    </script>
    <section class="staff-table">
        <div class="container">
            <h2 class="text-center">Staff Details</h2>
            <div class="table-responsive">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr class="table-head">
                            <th scope="col">Staff ID</th>
                            <th scope="col">Staff Name</th>
                            <th scope="col">Staff Email</th>
                            <!-- <th scope="col">Staff Password</th> -->
                            <th scope="col">Role</th>
                            <th scope="col">Take Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM users ORDER BY user_id ASC";
                        $user_stmt = mysqli_prepare($conn, $query);
                        if (!$user_stmt) {
                            die("Failed to prepare statement");
                        } else {
                            mysqli_stmt_execute($user_stmt);
                            $result = mysqli_stmt_get_result($user_stmt);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr class='table-body'>";
                                    echo "<td>" . $row['user_id'] . "</td>";
                                    echo "<td>" . $row['user_name'] . "</td>";
                                    echo "<td>" . $row['user_email'] . "</td>";
                                    echo "<td>" . $row['role'] . "</td>";
                                    if ($row['role'] == 'Doctor') {
                                        echo "<td>
                                        <div class='buttons'>
                                            <a href='editStaff.php?user_id=" . $row['user_id'] . "' class='btn edit-btn'>Edit</a>
                                            <a href='doDeleteStaff.php' class='btn delete-btn' data-bs-toggle='modal' data-bs-target='#delete-modal' data-id='" . $row['user_id'] . "'>Delete</a>
                                        </div>
                                    </td>";

                                        echo "</tr>";
                                    } else{
                                        echo "<td>
                                        <div class='buttons'>
                                            <a href='editStaff.php?user_id=" . $row['user_id'] . "' class='btn edit-btn'>Edit</a>
                                        </div>
                                    </td>";
                                    }
                                }
                            }
                        }
                        ?>
                        <a href='addStaff.php' class='btn add-btn'>Add</a>
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
    </section>

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