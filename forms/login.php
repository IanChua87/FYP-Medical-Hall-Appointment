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
<section class="login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 px-0 d-sm-block left-col">
                <img src="../img/side-image.png" alt="Login image" class="w-100 vh-100"
                     style="object-fit: cover; object-position: left;">
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 text-black right-col">
                <div class="form-container">
                    <h3 class="text">Login</h3>

                    <form method="post" action="../index.php">
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="email" class="form-control form-control-lg" placeholder="Email" />
                        </div>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="password" id="form2Example28" class="form-control form-control-lg"
                                   placeholder="Password" />
                        </div>

                        <div class="row mb-4">
                            <div class="col d-flex">
                                <!-- Checkbox -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                                    <label class="form-check-label rem-me-label" for="form2Example31"> Remember me </label>
                                </div>
                            </div>

                            <div class="col text-end">
                                <!-- Simple link -->
                                <a href="#!" class="forgot-text">Forgot password?</a>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn login-btn">Login</button>
                        </div>
                    </form>
                </div>
                <!-- <div class="copyright d-flex align-items-center justify-content-center">
                    <p class="copyright-text">@ 2024. All right reserved</p>
                </div> -->
            </div>
        </div>
    </div>
</section>


</body>

</html>

<?php
