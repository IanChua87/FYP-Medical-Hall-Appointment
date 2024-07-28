<?php
ob_start();
session_start();
include "../db_connect.php";
include "../helper_functions.php";
?>

<?php

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (check_empty_login_input_fields($email, $password)) {
        $_SESSION['login-error'] = "Please enter your email and password.";
        header("Location: login.php");
        exit();
    }

    if(check_users_exists_by_email($conn, $email) === false && check_patient_exists_by_email($conn, $email) === false){
        $_SESSION['login-error'] = "Email not found.";
        header("Location: login.php");
        exit();
    }

    if (login_patient($conn, $email, $password)) {
        header("Location: ../P_index.php");
        exit();
    } 

    if (login_users($conn, $email, $password)) {
        header("Location: ../adminDashboard.php");
        exit();
    }

    if(!login_patient($conn, $email, $password) && !login_users($conn, $email, $password)){
        $_SESSION['login-error'] = "Invalid email or password.";
        header("Location: login.php");
        exit();
    }

    header("Location: login.php");
    exit();
}
ob_end_flush();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Login</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
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
                <a class="btn sign-up-btn" href="register.php" role="button">Sign Up</a>
                <a class="btn login-btn" href="login.php" role="button">Login</a>
            </ul>';
    }

    echo '    </div>
        </div>
    </nav>';
    ?>
    <section class="login">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 px-0 d-sm-block left-col">
                    <img src="../img/side-img.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 text-black right-col">
                    <div class="form-container">
                        <h3 class="text">Login</h3>
                        <p class="login-prompt">Already registered? <span> <a href="register.php">Register</a> </span>now</p>
                        <form method="post" action="login.php">
                            <div class="form-outline mb-4">
                                <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" />
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="form2Example28" class="form-control form-control-lg" placeholder="Password" name="password" />
                            </div>

                            <div class="row mb-4">
                                <div class="col text-end">

                                    <a href="forgotPassword.php" class="forgot-text">Forgot password?</a>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" name="submit" class="btn login-btn">Login</button>
                            </div>
                        </form>
                        <?php
                        if (isset($_SESSION['login-error'])) {
                            echo '<p class="login-error-msg" id="login-error-msg">' . $_SESSION['login-error'] . '</p>';
                            unset($_SESSION['login-error']);
                        }
                        ?>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                setTimeout(function() {
                                    $('#login-error-msg').fadeOut('slow');
                                }, 2500);
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </section>




</body>

</html>