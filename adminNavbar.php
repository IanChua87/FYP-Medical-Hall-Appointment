<?php

echo '
<nav class="navbar navbar-expand-lg admin-nav" id="admin-nav">
    <div class="container">
            <button class="navbar-toggler" type="button" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="forms/settings.php">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="forms/lastQueueNo.php">Queue No</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Doctor Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="forms/appointmentDetails.php">Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="patientDetails.php">Patient Details</a>
                </li>
            </ul>';

if (isset($_SESSION['admin_id'])) {
    echo '<div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle nav-profile"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="forms/editprofile.php">Edit Profile</a></li>
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