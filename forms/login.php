<?php
session_start();
include "../db_connect.php";
?>

<?php
$error = "";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please enter your email and password.";
    } else {
        $login_success = false;


        // Query to fetch user data from the database
        $p_query = "SELECT * FROM patient WHERE patient_email=?";

        $patient_stmt = mysqli_prepare($conn, $p_query);

        if (!$patient_stmt) {
            die("Failed to prepare statement");
        } else {
            mysqli_stmt_bind_param($patient_stmt, "s", $email);
            mysqli_stmt_execute($patient_stmt);
            $p_result = mysqli_stmt_get_result($patient_stmt);
            $p_user = mysqli_num_rows($p_result);

            // Verify password and set session if login is successful
            if ($p_user > 0) {
                $p_user_data = mysqli_fetch_assoc($p_result);

                if (password_verify($password, $p_user_data['patient_password'])) {
                    $_SESSION['patient_id'] = $p_user_data['patient_id'];
                    $login_success = true;
                    header("Location: ../index.php");
                    exit();
                }
            }
            mysqli_stmt_close($patient_stmt);
        }


        $u_query = "SELECT * FROM users WHERE user_email=?";

        $user_stmt = mysqli_prepare($conn, $u_query);

        if (!$user_stmt) {
            die("Failed to prepare statement");
        } else {
            mysqli_stmt_bind_param($user_stmt, "s", $email);
            mysqli_stmt_execute($user_stmt);
            $u_result = mysqli_stmt_get_result($user_stmt);
            $u_user = mysqli_num_rows($u_result);

            // Verify password and set session if login is successful
            if ($u_user > 0) {
                $u_user_data = mysqli_fetch_assoc($u_result);

                if (password_verify($password, $u_user_data['user_password'])) {
                    if ($u_user_data['role'] == "Admin") {
                        $_SESSION['admin_id'] = $u_user_data['user_id'];
                        $_SESSION['admin_role'] = $u_user_data['role'];
                        $login_success = true;
                        header("Location: ../adminDashboard.php");
                        exit();
                    } else if ($u_user_data['role'] == "Doctor") {
                        $_SESSION['doctor_id'] = $u_user_data['user_id'];
                        $login_success = true;
                        header("Location: ../index.php");
                        exit();
                    }
                }
            }
            mysqli_stmt_close($user_stmt);
        }
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
                    <img src="../img/medical-herbs-img.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
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
                        <?php if (!empty($error)) {
                            echo '<p class="login-error-msg" id="login-error-msg">' . $error . '</p>';
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
