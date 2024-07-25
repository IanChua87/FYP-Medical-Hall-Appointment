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
    </style>
</head>

<body>
    <div class="main-content d-flex 100-vh">
        <div class="sidebar" id="sidebar">
            <div class="header-box px-3 mt-2 mb-2 d-flex align-items-center justify-content-between">
                <h1 class="header">Sin Nam</h1>
            </div>
            <ul class="mt-3">
                <li class="active"><a href="adminDashboard.php" class="text-decoration-none outer"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li class=""><a href="forms/queueDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-hourglass-start"></i> Check Queue No.</a></li>
                <li class=""><a href="forms/staffDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-user-doctor"></i> View Staff</a></li>
                <li class=""><a href="forms/patientDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-bed"></i> View Patient</a></li>
                <li class=""><a href="forms/appointmentDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-calendar-check"></i> View Appointment</a></li>
                <li class=""><a href="forms/settings.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Settings</a></li>
                <li class=""><a href="forms/viewHoliday.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Holiday</a></li>
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
                labels: ['Patient', 'Appointment', 'Staff'],
                datasets: [{
                        label: '# ongoing patients and appointments',
                        data: [12, 19, 3],
                        borderWidth: 0,
                        backgroundColor: ['#28a745', '#007bff', '#ffc107']
                    },
                    {
                        label: '# completed patients and appointments',
                        data: [10, 15, 5],
                        borderWidth: 0,
                        backgroundColor: ['#28a745', '#007bff', '#ffc107']
                    }
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
                            color: '#black', // X-axis label color (red)
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
                            // X-axis title color (red)
                        }
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: 'hsl(210, 6%, 58%)', // Legend label color (red)
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

            // Fetch data and render Chart.js chart
            // $.ajax({
            //     url: 'fetch_patient_data.php',
            //     method: 'GET',
            //     dataType: 'json',
            //     success: function(data) {
            //         const labels = data.map(item => item.date);
            //         const values = data.map(item => item.patient_count);

            //         const ctx = $('#myChart')[0].getContext('2d');
            //         new Chart(ctx, {
            //             type: 'bar',
            //             data: {
            //                 labels: labels,
            //                 datasets: [{
            //                     label: 'Number of Patients',
            //                     data: values,
            //                     backgroundColor: 'rgba(75, 192, 192, 0.2)',
            //                     borderColor: 'rgba(75, 192, 192, 1)',
            //                     borderWidth: 1
            //                 }]
            //             },
            //             options: {
            //                 scales: {
            //                     y: {
            //                         beginAtZero: true
            //                     }
            //                 }
            //             }
            //         });
            //     },
            //     error: function(xhr, status, error) {
            //         console.error('Error fetching data:', error);
            //     }
            // });
        });
    </script>
</body>

</html>