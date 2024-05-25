<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Register</title>
    <link rel="stylesheet" href="../Stylesheet/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>
    <section class="register vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 px-0 d-none d-sm-block">
                    <img src="../img/side-image.png" alt="Login image" class="w-100 vh-100"
                         style="object-fit: cover; object-position: left;">
                </div>
                <div class="col-sm-4 text-black right-col">


                    <div class="form-container">

                        <form>

                            <h3 class="text">Create<br> Account</h3>
                            <p class="registered-prompt">Already registered? <span> <a href="login.html">Login</a> </span>now</p>

                            <div class="form-outline mb-4">
                                <input type="text" class="form-control form-control-lg" placeholder="Name" />
                            </div>

                            <div class="form-outline mb-4">
                                <input type="email" class="form-control form-control-lg" placeholder="Email" />
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="form2Example28" class="form-control form-control-lg"
                                    placeholder="Password" />
                            </div>


                            <div class="double-form-field row mb-4">
                                <div class="col">
                                  <input type="date" class="form-control date-input" id="dob" name="dob">
                                </div>
                                <div class="col">
                                  <select class="form-select" id="gender" name="gender">
                                    <option selected>Select...</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                  </select>
                                </div>
                              </div>

                            <div class="form-outline mb-4">
                                <input type="number" id="form2Example28" class="form-control form-control-lg"
                                    placeholder="Phone Number" />
                            </div>

                            <div class="mt-3">
                                <a href="registrationSuccessful.php" class="btn register-btn">Create Account</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>

</html>

<?php

?>