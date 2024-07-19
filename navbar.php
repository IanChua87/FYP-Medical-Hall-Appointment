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