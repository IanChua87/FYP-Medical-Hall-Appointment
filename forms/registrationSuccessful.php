<?php
ob_start();
session_start();
include "../db_connect.php";
include "../helper_functions.php";
?>

<!-- this is for patient register -->
<?php
$msg = "";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $status = "NEW";
    $last_updated_by = "Admin";
    $last_updated_datetime = date("Y-m-d H:i:s");
    $payment_status = "UNPAID";
    $amount_payable = 0.00;
    $is_verified = 0;


    if (check_empty_register_input_fields($name, $email, $password, $confirm_password, $dob, $phone)) {
        $_SESSION['error'] = "All fields are required.";
        $_SESSION['form_data'] = $_POST;
        header("Location: register.php");
        exit();
    }
    if (invalid_email($email) !== false) {
        $_SESSION['error'] = "Invalid email format.";
        $_SESSION['form_data'] = $_POST;
        header("Location: register.php");
        exit();
    }

    if (invalid_name($name) !== false) {
        $_SESSION['error'] = "Only letters and white space allowed in name.";
        $_SESSION['form_data'] = $_POST;
        header("Location: register.php");
        exit();
    }

    if (invalid_phone_number($phone) !== false) {
        $_SESSION['error'] = "Only numbers allowed in phone number and must be 8 characters long.";
        $_SESSION['form_data'] = $_POST;
        header("Location: register.php");
        exit();
    }

    if (check_password_strength($password)) {
        $_SESSION['error'] = "Password must be at least 8 characters long.";
        $_SESSION['form_data'] = $_POST;
        header("Location: register.php");
        exit();
    }

    if (check_confirm_password($password, $confirm_password)) {
        $_SESSION['error'] = "Passwords do not match.";
        $_SESSION['form_data'] = $_POST;
        header("Location: register.php");
        exit();
    }

    if(check_user_old_enough($dob) !== true){
        $_SESSION['error'] = "You must be at least 18 years old to register.";
        $_SESSION['form_data'] = $_POST;
        header("Location: register.php");
        exit();
    }

    if (check_patient_exists_by_email($conn, $email) !== false) {
        $_SESSION['error'] = "User with this email already exists.";
        $_SESSION['form_data'] = $_POST;
        header("Location: register.php");
        exit();
    } else {
        if (insert_patient_details($conn, $name, $dob, $phone, $email, $password, $status, $last_updated_by, $last_updated_datetime, $payment_status, $amount_payable, $is_verified) !== false) {
            $msg = "<h2>Registration<br> successful</h2>";
        } else {
            $_SESSION['error'] = "Registration failed";
            $_SESSION['form_data'] = $_POST;
            mysqli_stmt_close($insert_stmt);
            header("Location: register.php");
            exit();
        }
    }

    if (check_patient_phone_exists($conn, $phone) !== false) {
        $_SESSION['error'] = "Phone number already exists.";
        $_SESSION['form_data'] = $_POST;
        header("Location: register.php");
        exit();
    }

    mysqli_close($conn);
}
ob_end_flush();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Registration | Successful</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
</head>

<body>
    <section class="registered vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 px-0 d-sm-block left-col">
                    <img src="../img/herb.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
                <div class="col-sm-12 col-sm-12 col-lg-4 text-black right-col">
                    <div class="verified-box">
                        <img src="../img/tick-verification.svg" alt="Tick logo symbol" style="margin-right: 10px;" />
                        <?php echo $msg ?>
                        <div class="mt-3">
                            <a href="login.php" class="btn login-btn">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>

</html>