<?php
ob_start();
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
ob_end_flush();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Forgot</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
</head>

<?php include '../navbar.php'; ?>

<body>
    <section class="forgot-password vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 px-0 d-none d-sm-block">
                    <img src="../img/side-image.png" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
                <div class="col-sm-4 text-black right-col">
                    <div class="form-container">
                        <h3 class="text">Forgot Password</h3>
                        <form method="post" action="doforgotPassword.php">
                            <div data-mdb-input-init class="form-outline mb-5">
                                <input type="email" class="form-control form-control-lg" placeholder="Email" />
                            </div>


                            <!-- Simple link -->
                            <a href="login.php" class="forgot-text">Remember password?</a>

                            <div class="mt-3">
                                <button type="submit" name="submit" class="btn reset-btn">Reset Password</button>
                            </div>
                        </form>
                        <div class="reset-password-error-msg" id="register-error-msg">
                            <?php echo $error ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

</html>

<?php
