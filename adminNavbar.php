<?php

echo '
<nav class="navbar navbar-expand-lg custom-nav">
    <div class="container">
        <a class="navbar-brand" href="#">Logo</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Queue No</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Doctor Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Patient Details</a>
                </li>
            </ul>';

if (isset($_SESSION['admin_id'])) {
    echo '<ul class="nav navbar-nav">
            <a class="btn logout-btn" href="forms/loggedOutSuccessful.php" role="button">Logout</a>
          </ul>';
} else {
    echo '<ul class="nav navbar-nav">
            <a class="btn sign-up-btn" href="forms/register.php" role="button">Sign Up</a>
            <a class="btn login-btn" href="forms/login.php" role="button">Login</a>
          </ul>';
}

echo '    </div>
    </div>
</nav>';