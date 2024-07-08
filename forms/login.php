<?php
session_start();
include "../db_connect.php";
include "../helper_functions.php";
?>

<?php

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (check_empty_login_input_fields($email, $password)) {
        $_SESSION['login-error'] = "Please enter your email and password.";
    } else {
        login_patient($conn, $email, $password);

        login_users($conn, $email, $password);
    }
}

?>
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
                    <img src="../img/side-image.png" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 text-black right-col">
                    <div class="form-container">
                        <h3 class="text">Login</h3>
                        <p class="login-prompt">Already registered? <span> <a href="register.php">Register</a> </span>now</p>
                        <form method="post" action="">
                            <div class="form-outline mb-4">
                                <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" />
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="form2Example28" class="form-control form-control-lg" placeholder="Password" name="password" />
                            </div>

                            <div class="row mb-4">
                                <div class="col text-end">
                                    <!-- Simple link -->
                                    <a href="forgotPassword.php" class="forgot-text">Forgot password?</a>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" name="submit" class="btn login-btn">Login</button>
                            </div>
                        </form>
                        <?php
                        if(isset($_SESSION['login-error'])){
                            echo '<p class="login-error-msg" id="login-error-msg">' . $_SESSION['login-error'] . '</p>';
                            unset($_SESSION['login-error']);
                        }
                        ?>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                setTimeout(function() {
                                    $('#login-error-msg').fadeOut('slow');
                                }, 1700);
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </section>




</body>

</html>

<?php
