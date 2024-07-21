<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services Herb Prescription</title>
    <?php include 'links.php'; ?>
    <link rel="stylesheet" href="style.css" />
    <style>
    </style>
</head>

<body>
    <!--navbar-->
    <?php
    echo '
    <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
    <a class="navbar-brand" href="index.php">
        Logo
    </a>

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
            <a class="nav-link" href="index.php#about">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="servicesDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Services
          </a>
          <ul class="dropdown-menu" aria-labelledby="servicesDropDown">
            <li><a class="dropdown-item" href="servicesTCM.php">Personalized TCM Consultations</a></li>
            <li><a class="dropdown-item" href="servicesPrescription.php">Customized Chinese Herbal Prescriptions</a></li>
          </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php#operating-hours">Opening Hours</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php#contact">Contact</a>
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


    <section class="herbs">
        <div class="herbs-box">
            <div class="herb-content-top">
                <h1 class="text-center">Chinese Herbal Prescription</h1>
                <div class="herbs-img-group d-flex align-items-center justify-content-center">
                    <img src="img/herbImg1.png" class="herbal-img-1" alt="herb img 1">
                    <img src="img/herbImg2.png" class="herbal-img-2" alt="herb img 2">
                </div>
                <h2 class="herb-text text-center mt-5">
                    Our TCM clinic provides personalized Chinese herbal<br> prescriptions tailored to your specific health needs. Our<br> herbal medicine services include:
                </h2>
                <div class="down-icon text-center"><i class="fa-solid fa-angle-down"></i></div>
            </div>

            <div class="herb-content-bottom">
                <h2 class="herb-text text-center">
                    <span class="fw-bold">Comprehensive Herbal Formulations:</span> Based on a detailed<br> consultation, our practitioners create customized herbal<br> blends to address your individual health concerns.
                </h2>
                <h2 class="herb-text text-center">
                    <span class="fw-bold">Natural Healing:</span> Utilizing high-quality herbs to treat a variety<br> of conditions such as digestive issues, respiratory problems,<br> hormonal imbalances, and chronic illnesses.
                </h2>
                <h2 class="herb-text text-center">
                    <span class="fw-bold">Holistic Health Improvement:</span> Herbs work synergistically to<br> restore balance and support your body’s natural healing<br> processes.
                </h2>
                <h3 class="summary text-center">
                    Our practitioners are knowledgeable in the art and science of<br> Chinese herbal medicine, ensuring safe and<br> effective treatments.
                </h3>
            </div>
        </div>
    </section>

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
                            <a class="nav-link" href="index.php#hero">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#services">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#operating-hours">Opening Hours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#contact">Contact</a>
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