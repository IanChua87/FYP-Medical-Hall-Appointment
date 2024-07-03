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



                            <div class="form-outline mb-4">
                                <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" />
                            </div>

                            <div class="form-outline mb-4">
                                <input type="text" class="form-control form-control-lg" placeholder="Email" name="email" />
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="form2Example28" class="form-control form-control-lg" placeholder="Password" name="password" />
                            </div>


                            <div class="double-form-field row mb-4">
                                <div class="col">
                                    <input type="text" class="form-control date-input" id="dob" name="dob" placeholder="Date of Birth">
                                </div>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="text" id="form2Example28" class="form-control form-control-lg" placeholder="Phone Number" name="phone" />
                            </div>

                            <div class="mt-3">
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


    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>


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