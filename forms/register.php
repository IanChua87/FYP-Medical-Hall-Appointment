<?php
session_start();
include "../db_connect.php";

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];


unset($_SESSION['error']);
unset($_SESSION['form_data']);
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



                            <div class="form-outline mb-3">
                                <input type="text" class="form-control form-control-lg mb-1" placeholder="Name" name="name" />
                                <p class="text-end">No using numbers for the name, for eg. Xavier Lee</p>
                            </div>

                            <div class="form-outline mb-3">
                                <input type="text" class="form-control form-control-lg mb-1" placeholder="Email" name="email" />
                                <p class="text-end">Use '@' for valid email format</p>
                            </div>

                            <div class="form-outline mb-3">
                                <input type="password" id="password" class="form-control form-control-lg mb-1" placeholder="Password" name="password" />
                                <p>Length must be at least 8 characters long, containing upper, lower cases, numbers and special characters</p>
                            </div>

                            <div class="form-outline mb-5">
                                <input type="password" id="confirm_password" class="form-control form-control-lg mb-1" placeholder="Confirm Password" name="confirm_password" />
                            </div>


                            <div class="double-form-field row mb-3">
                                <div class="col">
                                    <div class="form-outline">
                                        <input type="text" class="form-control date-input mb-1" id="dob" name="dob" placeholder="Date of Birth">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-outline">
                                        <input type="text" id="form2Example28" class="form-control form-control-lg mb-1" placeholder="Phone Number" name="phone" />
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" name="submit" class="btn register-btn">Create Account</button>
                            </div>
                        </form>

                        <div class="register-error-msg" id="register-error-msg">
                            <?php echo $error ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#register-error-msg').fadeOut('slow');
            }, 1700);
        });
    </script>

    <script>
        $(function() {
            $("#dob").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                dateFormat: "yy-mm-dd"
            });
        });
    </script>


</body>

</html>

<?php

?>