<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Logged Out | Successful</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
</head>

<body>
<section class="loggedout vh-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 px-0 d-sm-block left-col">
                <img src="../img/side-image.png" alt="Login image" class="w-100 vh-100"
                     style="object-fit: cover; object-position: left;">
            </div>
            <div class="col-sm-12 col-md-12 col-lg-4 text-black right-col">
                <div class="verified-box">
                    <h2>Logged Out</h2>
                    <p>You have been logged out. Please login again.</p>
                    <div class="mt-5">
                        <a href="login.php" class="btn login-btn">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


</body>

</html>

<?php
