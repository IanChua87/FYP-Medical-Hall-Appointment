<?php
session_start();
include "../db_connect.php";

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];


unset($_SESSION['error']);
unset($_SESSION['form_data']);
?>

<!-- this is for patient register -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Register</title>
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
    <style>
        .register-error-msg {
            color: red;
            font-size: 14px;
            margin-top: 10px;
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
                            <p class="registered-prompt">Already registered? <span><a href="login.php">Login</a></span> now</p>

                            <div class="form-outline mb-3">
                                <label for="name">
                                    <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Name:
                                    <span class="required-text">(required)</span>
                                </label>
                                <input type="text" class="form-control form-control-lg mb-1" placeholder="Name" name="name" id="name" value="<?php echo isset($form_data['name']) ? $form_data['name'] : '' ?>" />
                            </div>

                            <div class="form-outline mb-3">
                                <label for="email">
                                    <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Email:
                                    <span class="required-text">(required)</span>
                                </label>
                                <input type="text" class="form-control form-control-lg mb-1" placeholder="Email" name="email" value="<?php echo isset($form_data['email']) ? $form_data['email'] : '' ?>" />
                            </div>

                            <div class="form-outline mb-3">
                                <label for="password">
                                    <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Password:
                                    <span class="required-text">(required)</span>
                                </label>
                                <input type="password" id="password" class="form-control form-control-lg mb-1" placeholder="Password" name="password" />
                            </div>

                            <div class="form-outline mb-3">
                                <label for="confirm_password">
                                    <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Confirm Password:
                                    <span class="required-text">(required)</span>
                                </label>
                                <input type="password" id="confirm_password" class="form-control form-control-lg mb-1" placeholder="Confirm Password" name="confirm_password" />
                            </div>

                            <div class="double-form-field row mb-3">
                                <div class="col">
                                    <div class="form-outline">
                                        <label for="dob">
                                            <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Date of Birth:
                                            <span class="required-text">(required)</span>
                                        </label>
                                        <input type="text" class="form-control date-input mb-1" id="dob" name="dob" placeholder="Date of Birth" value="<?php echo isset($form_data['dob']) ? $form_data['dob'] : '' ?>">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-outline">
                                        <label for="phone">
                                            <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Phone Number:
                                            <span class="required-text">(required)</span>
                                        </label>
                                        <input type="text" id="phone" class="form-control form-control-lg mb-1" placeholder="Phone Number" name="phone" value="<?php echo isset($form_data['phone']) ? $form_data['phone'] : '' ?>" />
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


