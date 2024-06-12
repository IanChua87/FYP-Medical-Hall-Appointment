<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        #sidebar {
            min-width: 300px;
            max-width: 300px;
            background: #682924;
        }

        #sidebar .header {
            color: #f9f9f9;
            font-size: 36px;
            font-weight: 600;
        }

        .hidden-sidebar {
            display: none;
        }

        .hidden-sidebar ul {
            opacity: 0;
            transition: opacity 0.5s;
        }

        #sidebar a {
            color: #f9f9f9;
        }

        #sidebar .btn {
            color: #f9f9f9;
            font-size: 30px;
        }

        #sidebar ul {
            padding-left: 0;
        }

        #sidebar ul li {
            list-style: none;
            padding: 12px 24px;
            margin-bottom: 8px;
        }

        #sidebar ul li.active {
            background-color: #333;
        }

        #sidebar ul li.active a {
            color: #CFA61E;
        }

        #sidebar ul li:hover {
            background-color: #333;
        }

        #sidebar ul li a {
            font-size: 18px;
        }

        #sidebar ul li a .fa-solid {
            margin-right: 12px;
            font-size: 16px;
        }

        .sidebar-separator {
            height: 1px;
            background-color: #f9f9f9;
            margin: 16px;
        }

        .content {
            width: 100%;
        }

        .content .navbar {
            background-color: #333;
            color: #f9f9f9;
            width: 100%;
        }

        .content .navbar .logout-btn {
            color: #f9f9f9;
            background-color: #CFA61E;
            padding: 6px 16px;
        }

        .close-btn {
            border: none;
        }

        .close-btn .fa-bars {
            font-size: 24px;
            color: #f9f9f9;
        }

        .admin-box {
            padding: 0 50px;
        }

        .admin-box h2 {
            font-size: 48px;
            font-weight: 600;
            margin: 24px 0;
        }

        .admin-box .edit-btn {
            background-color: #CFA61E;
            padding: 6px 20px;
            color: #f9f9f9;
            font-size: 16px;
            margin-right: 10px;
        }

        .admin-box .delete-btn {
            background-color: #682924;
            padding: 6px 20px;
            color: #f9f9f9;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="main-container d-flex">
        <div class="sidebar" id="sidebar">
            <div class="header-box px-3 mt-2 mb-2 d-flex align-items-center justify-content-between">
                <h1 class="header">Sin Nam</h1>
                <!-- <button class="btn close-btn"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <ul class="mt-2">
                <li class="active"><a href="#" class="text-decoration-none"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li class=""><a href="#" class="text-decoration-none"><i class="fa-solid fa-hourglass-start"></i> Last Queue No.</a></li>
                <li class=""><a href="#" class="text-decoration-none"><i class="fa-solid fa-user-doctor"></i> Edit Doctor</a></li>
                <li class=""><a href="#" class="text-decoration-none"><i class="fa-solid fa-bed"></i> Edit Patient</a></li>
                <li class=""><a href="#" class="text-decoration-none"><i class="fa-solid fa-calendar-check"></i> Edit Appointment</a></li>
                <div class="sidebar-separator"></div>
                <li class=""><a href="#" class="text-decoration-none"><i class="fa-solid fa-gear"></i> Edit Settings</a></li>
            </ul>
        </div>

        <div class="content" id="content">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <button class="btn close-btn"><i class="fa-solid fa-bars"></i></button>
                    <div class="collapse navbar-collapse" id="navbarMenu">
                        <ul class="nav navbar-nav ms-auto">
                            <a class="btn logout-btn" href="forms/loggedOutSuccessful.php" role="button">Logout</a>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="section">
                <div class="admin-box">
                    <h2>Admin Dashboard</h2>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="card mb-4">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="img/doctor-ill.jpg" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">
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
                        <div class="card mb-4">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="img/doctor-ill.jpg" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">
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
                            <div class="card mb-4">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="img/doctor-ill.jpg" class="img-fluid rounded-start" alt="...">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">Edit Patient</h5>
                                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="card mb-4">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="img/doctor-ill.jpg" class="img-fluid rounded-start" alt="...">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">Edit Appointment</h5>
                                                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
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
                                                <th scope="row">1</th>
                                                <td>John Doe</td>
                                                <td>john@example.com</td>
                                                <td>Admin</td>
                                                <td>
                                                    <button class="btn edit-btn">Edit</button>
                                                    <button class="btn delete-btn">Delete</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Jane Smith</td>
                                                <td>jane@example.com</td>
                                                <td>User</td>
                                                <td>
                                                    <button class="btn edit-btn">Edit</button>
                                                    <button class="btn delete-btn">Delete</button>
                                                </td>
                                            </tr>
                                            <!-- Add more rows as needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function() {
            // Click event listener for close button
            $(".close-btn").click(function() {
                $("#sidebar").toggleClass("hidden-sidebar");
            });
        });
    </script>

</body>

</html>