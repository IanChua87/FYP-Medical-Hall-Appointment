<?php
include "../db_connect.php";
?>

<?php
$error = "";
// Check if the form is submitted
session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please enter your email and password.";
    } else {

        // Query to fetch user data from the database
        $p_query = "SELECT * FROM patient WHERE patient_email=? && patient_password=?";

        $patient_stmt = mysqli_prepare($conn, $p_query);

        if (!$patient_stmt) {
            die("Failed to prepare statement");
        } else {
            mysqli_stmt_bind_param($patient_stmt, "ss", $email, $password);
            mysqli_stmt_execute($patient_stmt);
            $p_result = mysqli_stmt_get_result($patient_stmt);
            $p_user = mysqli_num_rows($p_result);

            // Verify password and set session if login is successful
            if ($p_user > 0) {
                $p_user_data = mysqli_fetch_assoc($p_result);

                $_SESSION['patient_id'] = $p_user_data['patient_id'];
                header("Location: ../index.php");
                exit();
            } else {
                $error = "Invalid email or password. Please try again.";
            }
        }


        $d_query = "SELECT * FROM doctor WHERE doctor_email=? && doctor_password=?";

        $doctor_stmt = mysqli_prepare($conn, $d_query);

        if (!$doctor_stmt) {
            die("Failed to prepare statement");
        } else {
            mysqli_stmt_bind_param($doctor_stmt, "ss", $email, $password);
            mysqli_stmt_execute($doctor_stmt);
            $d_result = mysqli_stmt_get_result($doctor_stmt);
            $d_user = mysqli_num_rows($d_result);

            // Verify password and set session if login is successful
            if ($d_user > 0) {
                $d_user_data = mysqli_fetch_assoc($d_result);

                $_SESSION['doctor_id'] = $d_user_data['doctor_id'];
                header("Location: ../index.php");
                exit();
            } else {
                $error = "Invalid email or password. Please try again.";
            }
        }


        $a_query = "SELECT * FROM 'admin' WHERE admin_email=? && admin_password=?";

        $admin_stmt = mysqli_prepare($conn, $a_query);

        if (!$admin_stmt) {
            die("Failed to prepare statement");
        } else {
            mysqli_stmt_bind_param($admin_stmt, "ss", $email, $password);
            mysqli_stmt_execute($admin_stmt);
            $a_result = mysqli_stmt_get_result($admin_stmt);
            $a_user = mysqli_num_rows($a_result);

            // Verify password and set session if login is successful
            if ($a_user > 0) {
                $a_user_data = mysqli_fetch_assoc($a_result);

                $_SESSION['admin_id'] = $a_user_data['admin_id'];
                header("Location: ../index.php");
                exit();
            } else {
                $error = "Invalid email or password. Please try again.";
            }
        }


        mysqli_stmt_close($doctor_stmt);
        mysqli_stmt_close($patient_stmt);
        mysqli_stmt_close($admin_stmt);
        mysqli_close($conn);
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
                    <img src="../img/herb.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
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
                                <div class="col d-flex">
                                    <!-- Checkbox -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                                        <label class="form-check-label rem-me-label" for="form2Example31"> Remember me </label>
                                    </div>
                                </div>

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
