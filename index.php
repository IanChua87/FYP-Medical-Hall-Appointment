<?php
// Include database connection file
include "db_connect.php";

// Initialize an empty array to store the settings values
$opening_days = array();

// Define the SQL query to fetch the settings_value from the settings table
$sql = "SELECT settings_value FROM settings WHERE settings_key = 'opening_days'";

// Execute the query
if ($result = $conn->query($sql)) {
    // Fetch the result row by row
    while ($row = $result->fetch_assoc()) {
        // Add the settings_value to the array
        $opening_days = explode(',', $row['settings_value']); // Assuming opening_days are stored as a comma-separated string
    }

    // Free result set
    $result->free();
} else {
    // Handle query execution error
    echo "Error: " . $conn->error;
}

// Initialize variable to store the weekday open time
$weekday_open_time = '';

// Define the SQL query to fetch the settings_value from the settings table
$sql = "SELECT settings_value FROM settings WHERE settings_key = 'weekday_open_time'";

// Execute the query
if ($result = $conn->query($sql)) {
    // Check if a row is returned
    if ($result->num_rows > 0) {
        // Fetch the result (assuming only one row is expected)
        $row = $result->fetch_assoc();
        $weekday_open_time = $row['settings_value'];
    } else {
        // Handle case where no rows are returned
        echo "No rows found";
    }

    // Free result set
    $result->free();
} else {
    // Handle query execution error
    echo "Error: " . $conn->error;
}

// Initialize variable to store the weekday close time
$weekday_close_time = '';

// Define the SQL query to fetch the settings_value from the settings table
$sql = "SELECT settings_value FROM settings WHERE settings_key = 'weekday_close_time'";

// Execute the query
if ($result = $conn->query($sql)) {
    // Check if a row is returned
    if ($result->num_rows > 0) {
        // Fetch the result (assuming only one row is expected)
        $row = $result->fetch_assoc();
        $weekday_close_time = $row['settings_value'];
    } else {
        // Handle case where no rows are returned
        echo "No rows found";
    }

    // Free result set
    $result->free();
} else {
    // Handle query execution error
    echo "Error: " . $conn->error;
}

// Initialize variable to store the weekend open time
$weekend_open_time = '';

// Define the SQL query to fetch the settings_value from the settings table
$sql = "SELECT settings_value FROM settings WHERE settings_key = 'weekend_open_time'";

// Execute the query
if ($result = $conn->query($sql)) {
    // Check if a row is returned
    if ($result->num_rows > 0) {
        // Fetch the result (assuming only one row is expected)
        $row = $result->fetch_assoc();
        $weekend_open_time = $row['settings_value'];
    } else {
        // Handle case where no rows are returned
        echo "No rows found";
    }

    // Free result set
    $result->free();
} else {
    // Handle query execution error
    echo "Error: " . $conn->error;
}

// Initialize variable to store the weekend close time
$weekend_close_time = '';

// Define the SQL query to fetch the settings_value from the settings table
$sql = "SELECT settings_value FROM settings WHERE settings_key = 'weekend_close_time'";

// Execute the query
if ($result = $conn->query($sql)) {
    // Check if a row is returned
    if ($result->num_rows > 0) {
        // Fetch the result (assuming only one row is expected)
        $row = $result->fetch_assoc();
        $weekend_close_time = $row['settings_value'];
    } else {
        // Handle case where no rows are returned
        echo "No rows found";
    }

    // Free result set
    $result->free();
} else {
    // Handle query execution error
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();

// Initialize arrays for weekdays and weekends
$weekdays = array();
$weekends = array();

// Define arrays of weekdays and weekends for comparison
$weekday_names = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
$weekend_names = array("Saturday", "Sunday");

// Separate the days
foreach ($opening_days as $day) {
    $day = trim($day); // Trim any extra whitespace
    if (in_array($day, $weekday_names)) {
        $weekdays[] = $day;
    } elseif (in_array($day, $weekend_names)) {
        $weekends[] = $day;
    }
}

// Sort the days according to their natural order
$days_of_week = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");

$weekdays = array_intersect($days_of_week, $weekdays);
$weekends = array_intersect($days_of_week, $weekends);

// Get start and end of weekdays and weekends
$weekday_start = reset($weekdays); // First element
$weekday_end = end($weekdays);     // Last element

$weekend_start = reset($weekends); // First element
$weekend_end = end($weekends);     // Last element

$weekend_display = ($weekend_start == $weekend_end) ? $weekend_start : $weekend_start . "-" . $weekend_end;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Main</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include 'links.php'; ?>
    <link rel="stylesheet" href="style.css" />
</head>

<body>


    <!--navbar-->
    <?php

    echo '
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">Logo</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto">'; ?>
    <?php if (!isset($_SESSION["patient_id"])) { ?>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#about">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#services">Services</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#contact">Contact</a>
        </li>
    <?php } else { ?>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../P_index.php">Home</a>
        </li>
    <?php } ?>
    <?php echo '
                
              
            </ul>; ' ?>
    <?php
    if (isset($_SESSION['patient_id'])) {
        echo '
        <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Appointment
                </a>
            <ul class="dropdown-menu" aria-labelledby="apptDropdown">
                <li><a class="dropdown-item" href="forms/booking.php">Book Appointment</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="forms/viewappointment.php">View Appointment</a></li>
            </ul>
        </div>
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="forms/editprofile.php">Edit Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="forms/changepassword.php">Change Password</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="forms/loggedOutSuccessful.php">Logout</a></li>
            </ul>
        </div>';
    } else {
        echo '<ul class="nav navbar-nav">
            <a class="btn sign-up-btn" href="forms/register.php" role="button">Sign Up</a>
            <a class="btn login-btn" href="forms/login.php" role="button">Login</a>
          </ul>';
    }

    echo '    </div>
    </div>
</nav>';
    ?>



    <!--hero start-->
    <section class="hero" id="hero">
        <div class="container">
            <div class="hero-text">
                <h1>Providing quality <br>care and <br>convenience for all</h1>
                <p>Sin Nam Medical Hall is a Chinese Medical Hall with <br> more than 60 years of history. It specializes in <br> Traditional Chinese medicine and professional <br> consulation services.</p>
                <div class="mt-3">
                    <a href="#about" class="btn learn-more-btn">Learn More</a>
                </div>
            </div>
        </div>
    </section>
    <!--hero end-->




    <!--about start-->
    <section class="about" id="about">
        <div class="about-box">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6 left-col">
                    <div class="about-details mt-3">
                        <h2>About Us</h2>
                        <p>At Sim Nam Medical Hall, we pride ourselves on <br> a rich history and legacy that spans over multiple <br> generations. Established with a vision to provide <br> exceptional and professional healthcare services, <br> we have been serving the community for <br> decades, earning the trust and respect <br> of our patients.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6 right-col">
                    <img src="img/Mr Desmond Sin.jpg" alt="about-section" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
    <!--about end-->



    <!--services start-->
    <section class="services" id="services">
        <div class="services-box">
            <h2 class="text-center">Our Services</h2>
            <div class="row row-md-2 g-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100">
                        <img src="img/medical-herbs.png" class="card-img-top img-fluid" alt="consultation img">
                        <div class="card-body">
                            <h5 class="card-title">Personalized TCM Consultations</h5>
                            <p class="card-text">Our expert practitioners provide comprehensive health assessments and personalized treatment plans based on Traditional Chinese Medicine principles. Discover how TCM addresses health concerns and promote overall wellness.</p>
                            <a href="#" class="btn learn-more-btn mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100">
                        <img src="img/accupuncture.png" class="card-img-top img-fluid" alt="acupuncture img">
                        <div class="card-body">
                            <h5 class="card-title">Effective Acupuncture Treatments </h5>
                            <p class="card-text">Experience the benefits of acupuncture for pain relief, stress reduction, and enhanced well-being. Our skilled acupuncturists use precise techniques to restore balance and improve your health naturally.</p>
                            <a href="#" class="btn learn-more-btn mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card h-100">
                        <img src="img/medical-herbs.png" class="card-img-top img-fluid" alt="chinese herbs img">
                        <div class="card-body">
                            <h5 class="card-title">Customized Chinese Herbal Prescriptions</h5>
                            <p class="card-text">Receive tailored herbal formulations designed to address your specific health needs. Our high-quality, natural herbal prescriptions support your body’s healing processes and promote holistic health.</p>
                            <a href="#" class="btn learn-more-btn mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--services end-->



    <!--operating hours-->
    <section class="operating-hours" id="operating-hours">
        <div class="operating-box">
            <div class="row">
                <div class="col-12 col-md-5 col-lg-5">
                    <h2>Opening Hours</h2>
                    <h3><?php echo $weekday_start . "-" . $weekday_end ?></h3>
                    <p class="mb-4"><?php echo $weekday_open_time . "-" . $weekday_close_time ?></p>
                    <h3><?php echo $weekend_display ?></h3>
                    <p class="mb-0"><?php echo $weekend_open_time . "-" . $weekend_close_time ?></p>
                </div>
            </div>
        </div>
    </section>
    <!--operating hours start-->


    <!--contact start-->
    <section class="contact" id="contact">
        <h2 class="text-center">Contact Us</h2>
        <div class="contact-box">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-6">
                    <form action="forms/contact.php" method="post">
                        <div class="mb-3">
                            <input type="text" class="form-control-lg" name="name" placeholder="Name">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control-lg" name="email" placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control feedback-field" name="message" rows="6" placeholder="Feedback"></textarea>
                        </div>
                        <a class="btn submit-btn" href="forms/contactSuccessful.php" role="button">Submit</a>
                    </form>
                </div>

                <div class="col-12 col-md-12 col-lg-6">
                    <img src="img/contact-img.png" alt="contact-img">
                </div>
            </div>
        </div>
    </section>
    <!--contact end-->



    <!--footer start-->
    <footer class="footer">
        <div class="footer-box">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-3">
                <img src="../svg/Sin_Nam_Med_Hall_Logo.svg" alt="Logo" class="navbar-logo">
                </div>
                <div class="col-12 col-md-12 col-lg-6">
                    <ul class="nav justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link" href="#hero">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#services">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-md-12 col-lg-3">
                    <div class="contact-details">
                        <div class="address">
                            <i class="bi bi-geo-alt-fill"></i>
                            <p>#01-101 Yishun Street 71, Block 729, Singapore 760729</p>
                        </div>
                        <div class="phone">
                            <i class="bi bi-telephone-fill"></i>
                            <p>6257 0881</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-separator"></div>
            <p class="copyright-text mb-0">&copy; Sin Nam Medical Hall. All rights reserved.</p>
        </div>
    </footer>
    <!--footer end-->

</body>

</html>