<?php
ob_start();
session_start();
include "db_connect.php";
include "helper_functions.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}

// Query setup
$count_query = [
    "SELECT COUNT(appointment_status) AS cancelled_appointment_count FROM appointment WHERE appointment_status = 'CANCELLED'",
    "SELECT COUNT(appointment_status) AS upcoming_appointment_count FROM appointment WHERE appointment_status = 'UPCOMING'",
];

// Fetch data
$data = [];
$data['cancelled'] = getCount($conn, $count_query[0]);
$data['upcoming'] = getCount($conn, $count_query[1]);

$labels = ["Booked", "Cancelled"];
$data_values = [$data['upcoming'], $data['cancelled']];

// Close connection
mysqli_close($conn);

// foreach($count_query as $query){
//     $result = mysqli_query($conn, $query);
//     $data = mysqli_fetch_assoc($result);
//     $patients[] = $data['patient_count'];
//     $staff[] = $data['staff_count'];
//     $appointments[] = $data['appointments_count'];
// }
ob_end_flush();
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
        .info:hover,
        .p-table-row:hover {
            cursor: pointer;
        }

        #table {
            border: none;
        }
        #sidebar{
            min-height: 880px;
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
                <li class=""><a href="forms/patientDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-bed"></i> View Patient</a></li>
                <li class=""><a href="forms/appointmentDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-calendar-check"></i> View Appointment</a></li>
                <li class=""><a href="forms/staffDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-user-doctor"></i> View Staff</a></li>
                <li class=""><a href="forms/settings.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Settings</a></li>
                <li class=""><a href="forms/viewHoliday.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Holiday</a></li>
                <li class=""><a href="forms/contactDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-envelope"></i> View Contact</a></li>
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
                            <div class="card mb-4 h-100 info" data-href="forms/settings.php">
                                <div class="row g-0 d-flex align-items-center">
                                    <div class="col-md-4 col-sm-12">
                                        <i class="fa-solid fa-gear"></i>
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <div class="card-body">
                                            <h5 class="card-title">View Settings</h5>
                                            <p class="card-text">View the settings field that's can be edited to affect the website</p>
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
                                            <p class="card-text">Staff can be added, deleted and modified if needed</p>
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
                                    <h5 class="card-title">Number of Patient</h5>
                                    <canvas id="myChart" height="80"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        import {
            Colors
        } from 'chart.js';
        Chart.register(Colors);
    </script>

    <script>
    $(document).ready(function() {
        // Initialize the chart
        const ctx = document.getElementById('myChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                        label: 'Number of patients cancelling an appointment vs Number of patients having an appointment',
                        data: <?php echo json_encode($data_values); ?>,
                        borderWidth: 0,
                        backgroundColor: ['#28a745', '#007bff', '#ffc107']
                    },
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'black', // Y-axis label color (red)
                            font: {
                                size: 14 // Change font size if needed
                            }
                        },
                        title: {
                            display: true,
                            text: 'Number of Items',
                            color: '#682924' // Y-axis title color (red)
                        }
                    },
                    x: {
                        ticks: {
                            color: 'black',
                            font: {
                                size: 13 // Change font size if needed
                            }
                        },
                        title: {
                            display: true,
                            text: 'Categories',
                            color: '#682924',
                            font:{
                                size: 16
                            },
                            padding: {
                                top: 30
                            }
                        }
                    }
                    
                },
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: 'black', 
                            font: {
                                size: 16
                            }
                        }
                    }
                }
            }
        });
    });
</script>


    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                var userId = $(this).data('id');
                $('#user_id').val(userId);
            });

            $('.yes-btn').on('click', function() {
                $('#delete-form').submit();
            });

            $(".info").click(function() {
                window.location.href = $(this).data("href");
            });
        });
    </script>
</body>

</html>