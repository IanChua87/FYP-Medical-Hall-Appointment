<?php
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
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $confirm_password = $_POST['confirm_password'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $status = "New";
    $last_updated_by = "Admin";
    $last_updated_datetime = date("Y-m-d H:i:s");
    $payment_status = "Unpaid";
    $amount_payable = 50.00;
    $is_verified = 0;


    if (check_empty_register_input_fields($name, $email, $password, $confirm_password, $dob, $phone)) {
        $_SESSION['error'] = "All fields are required.";
        $_SESSION['form_data'] = $_POST;
        header("Location: register.php");
        exit();
    } else {
        if (invalid_email($email) !== false) {
            $_SESSION['error'] = "Invalid email format.";
            $_SESSION['form_data'] = $_POST;
            header("Location: register.php");
            exit();
        }

        if (invalid_name($name) !== false){
            $_SESSION['error'] = "Only letters and white space allowed in name.";
            $_SESSION['form_data'] = $_POST;
            header("Location: register.php");
            exit();
        }

        if (invalid_phone_number($phone) !== false){
            $_SESSION['error'] = "Only numbers allowed in phone number.";
            $_SESSION['form_data'] = $_POST;
            header("Location: register.php");
            exit();
        }

        if (check_password_strength($password)){
            $_SESSION['error'] = "Password must be at least 8 characters long.";
            $_SESSION['form_data'] = $_POST;
            header("Location: register.php");
            exit();
        }

        if(check_confirm_password($password, $confirm_password)){
            $_SESSION['error'] = "Passwords do not match.";
            $_SESSION['form_data'] = $_POST;
            header("Location: register.php");
            exit();
        }

        if(check_patient_exists_by_email($conn, $email) !== false){
            $_SESSION['error'] = "User with this email already exists.";
            $_SESSION['form_data'] = $_POST;
            header("Location: register.php");
            exit();
        } else {
            if(insert_patient_details($conn, $name, $dob, $phone, $email, $hashed_password, $status, $last_updated_by, $last_updated_datetime, $payment_status, $amount_payable, $is_verified) !== false){
                $msg = "<h2>Registration<br> successful</h2>";
            } else {
                $_SESSION['error'] = "Registration failed";
                $_SESSION['form_data'] = $_POST;
                mysqli_stmt_close($insert_stmt);
                header("Location: register.php");
                exit();
            }
    
            else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                //prepared statement for inserting user into database, for security purpose
                $insert = "INSERT INTO patient (patient_name, patient_dob, patient_phoneNo, patient_email, patient_password, patient_status, last_updated_by, last_updated_datetime, payment_status, amount_payable) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $insert_stmt = mysqli_prepare($conn, $insert);
                mysqli_stmt_bind_param($insert_stmt, "ssssssssss", $name, $dob, $phone, $email, $hashed_password, $status, $last_updated_by, $last_updated_datetime, $payment_status, $amount_payable);
    
                //execute the prepared statement
                if (mysqli_stmt_execute($insert_stmt)) {
                    $msg = "<h2>Registration<br> successful</h2>";
                } else {
                    $error = "Registration failed";
                    header("Location: register.php?error=" . urlencode($error));
                    exit();
                }
            }
        }

        mysqli_close($conn);
    }
}
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
                        <img src="../img/tick-verification.svg" alt="Tick logo symbol" />
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