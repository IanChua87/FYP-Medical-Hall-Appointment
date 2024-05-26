
<?php
// navbar details are included in this snippet, so if you want to use this snippet in your project, you need to include the links in your php file. This snippet includes Bootstrap 5 CSS and JS, Google Fonts, and Bootstrap Icons. You can copy and paste this snippet into your HTML file to include the necessary links.
echo '
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">Logo</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#hero">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Booking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                <a class="btn sign-up-btn" href="forms/register.php" role="button">Sign Up</a>
                <a class="btn login-btn" href="forms/login.php" role="button">Login</a>
            </ul>
        </div>
    </div>
</nav>';
