<?php
include "../db_connect.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Register</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
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
                <div class="col-sm-12 col-md-12 col-lg-8 px-0 d-sm-block left-col">
                    <img src="../img/side-image.png" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4 text-black right-col">


                    <div class="form-container">

                        <form method="post" action="registrationSuccessful.php">

                            <h3 class="text">Create<br> Account</h3>
                            <p class="registered-prompt">Already registered? <span> <a href="login.php">Login</a> </span>now</p>



                            <div class="form-outline mb-4">
                                <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" />
                            </div>

                            <div class="form-outline mb-4">
                                <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" />
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="form2Example28" class="form-control form-control-lg" placeholder="Password" name="password" />
                            </div>


                            <div class="double-form-field row mb-4">
                                <div class="col">
                                    <input type="date" class="form-control date-input" id="dob" name="dob" placeholder="Date of Birth">
                                </div>
                                <!-- <div class="col">
                                  <select class="form-select" id="gender" name="gender">
                                    <option selected>Select...</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                  </select>
                                </div> -->
                            </div>

                            <div class="form-outline mb-4">
                                <input type="number" id="form2Example28" class="form-control form-control-lg" placeholder="Phone Number" name="phone" />
                            </div>

                            <div class="mt-3">
                                <button type="submit" name="submit" class="btn register-btn">Create Account</button>
                            </div>
                        </form>
                        <?php
                        if (isset($_GET['error'])) {
                            echo '<div class="register-error-msg" id="register-error-msg">' . htmlspecialchars($_GET['error']) . '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#register-error-msg').fadeOut('slow');
            }, 1700);
        });
    </script>


</body>

</html>

<?php

?>