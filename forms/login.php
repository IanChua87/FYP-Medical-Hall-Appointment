<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
<section class="login vh-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 px-0 d-none d-sm-block">
                <img src="../img/side-image.png" alt="Login image" class="w-100 vh-100"
                     style="object-fit: cover; object-position: left;">
            </div>
            <div class="col-sm-4 text-black right-col">
                <div class="form-container">
                    <h3 class="text">Login</h3>
                    <form>
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
                            <a href="../index.php" class="btn login-btn">Login</a>
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
