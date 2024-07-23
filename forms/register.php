<?php
session_start();
include "../db_connect.php";

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];


unset($_SESSION['error']);
unset($_SESSION['form_data']);

// echo "<script>console.log('PHP Error Message:', '" . addslashes($error) . "');</script>";
?>

<!-- this is for patient register -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Register</title>
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
    <style>
        /* img{
            width: 100%;
            height: 100%;
        }

        .register-btn{
            background-color: #CFA61E;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.3s;
        } */
    </style>
</head>

<body>
    <?php

    echo '
<nav class="navbar navbar-expand-lg">
    <div class="container"> ' ?>
    <?php if (!isset($_SESSION["patient_id"])) { ?>
        <a class="navbar-brand" href="../index.php">
            <img src="../svg/Sin_Nam_Med_Hall_Logo.svg" alt="Logo" class="navbar-logo">
        </a>
    <?php } else { ?>
        <a class="navbar-brand" href="../P_index.php">
            <img src="../svg/Sin_Nam_Med_Hall_Logo.svg" alt="Logo" class="navbar-logo">
        </a>
    <?php } ?>
    <?php echo '
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
            <a class="nav-link" href="../index.php#about">About</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="servicesDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Services
            </a>
            <ul class="dropdown-menu" aria-labelledby="servicesDropDown">
                <li><a class="dropdown-item" href="../servicesTCM.php">Personalized TCM Consultations</a></li>
                <li><a class="dropdown-item" href="../servicesPrescription.php">Customized Chinese Herbal Prescriptions</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../index.php#operating-hours">Opening Hours</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../index.php#contact">Contact</a>
        </li>
    <?php } else { ?>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="../P_index.php">Home</a>
        </li>
    <?php } ?>
    <?php echo '
                
              
            </ul>; ' ?>
    <?php
    if (isset($_SESSION['patient_id'])) {
        echo '
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="apptDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Appointment
    </a>
    <ul class="dropdown-menu" aria-labelledby="apptDropdown">
        <li><a class="dropdown-item" href="booking.php">Book Appointment</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="viewappointment.php">View Appointment</a></li>
    </ul>
</div>
<div class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-person-circle"></i>
    </a>
    <ul class="dropdown-menu" aria-labelledby="userDropdown">
        <li><a class="dropdown-item" href="editprofile.php">Edit Profile</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="changepassword.php">Change Password</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="loggedOutSuccessful.php">Logout</a></li>
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
    <section class="register">
        <div class="container-fluid h-100">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 px-0 d-sm-block left-col">
                    <img src="../img/side-img.jpg" alt="Login image">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4 px-0 text-black right-col">
                    <div class="form-container">
                        <a href="../index.php" class="home-link">Home</a>
                        <h3 class="text">Create Account</h3>
                        <p class="registered-prompt">Already registered? <span><a href="login.php">Login</a></span> now</p>
                        <form method="post" action="registrationSuccessful.php">
                            <div class="form-outline mb-3">
                                <label for="name">
                                    <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Name:
                                    <span class="required-text">(required)</span>
                                </label>
                                <input type="text" class="form-control form-control-lg mb-1" placeholder="Name" name="name" id="name" value="<?php echo isset($form_data['name']) ? $form_data['name'] : '' ?>" />
                            </div>

                            <div class="form-outline mb-3">
                                <label for="email">
                                    <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Email:
                                    <span class="required-text">(required)</span>
                                </label>
                                <input type="text" class="form-control form-control-lg mb-1" placeholder="Email" name="email" value="<?php echo isset($form_data['email']) ? $form_data['email'] : '' ?>" />
                            </div>

                            <div class="form-outline mb-3">
                                <label for="password">
                                    <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Password:
                                    <span class="required-text">(required)</span>
                                </label>
                                <input type="password" id="password" class="form-control form-control-lg" placeholder="Password" name="password" />
                            </div>

                            <div class="form-outline mb-3">
                                <label for="confirm_password">
                                    <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Confirm Password:
                                    <span class="required-text">(required)</span>
                                </label>
                                <input type="password" id="confirm_password" class="form-control form-control-lg" placeholder="Confirm Password" name="confirm_password" />
                            </div>

                            <div class="double-form-field row mb-3">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-outline mb-3">
                                        <label for="dob">
                                            <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Date of Birth:
                                            <span class="required-text">(required)</span>
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="dob" name="dob" placeholder="Date of Birth" />
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-outline mb-3">
                                        <label for="phone">
                                            <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Phone Number:
                                            <span class="required-text">(required)</span>
                                        </label>
                                        <input type="text" id="phone" class="form-control form-control-lg" placeholder="Phone Number" name="phone" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" name="submit" class="btn register-btn">Create Account</button>
                            </div>
                        </form>
                        <p class="reg-error-msg" id="reg-error-msg"><?php echo $error ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#reg-error-msg').fadeOut('slow');
            }, 1700);
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#dob").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                dateFormat: "yy-mm-dd",
                maxDate: new Date()
            });
        });
    </script>

</body>

</html>