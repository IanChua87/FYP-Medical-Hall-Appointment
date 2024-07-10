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
        $query = "SELECT * FROM patient WHERE patient_email=? && patient_password=?";
        $stmt = mysqli_prepare($conn, $query);
        if (!$stmt) {
            die("Failed to prepare statement");
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $email, $password);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_num_rows($result);

            // Verify password and set session if login is successful
            if ($user > 0) {
                $user_data = mysqli_fetch_assoc($result);

                $_SESSION['patient_id'] = $user_data['patient_id'];
                header("Location: ../P_index.php");
                exit();
            } else {
                $error = "Invalid email or password. Please try again.";
            }
        }
        mysqli_stmt_close($stmt);
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
                        };
                        ?>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                setTimeout(function() {
                                    $('#login-error-msg').fadeOut('slow');
                                }, 3000);
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
