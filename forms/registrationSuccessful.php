<?php
include "../db_connect.php";
?>

<?php
$msg = "";
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];

    $status = "new";
    $last_updated_by = "admin";
    $last_updated_datetime = date("Y-m-d H:i:s");
    $payment_status = "unpaid";
    $amount_payable = 0;


    if (empty($name) || empty($email) || empty($password) || empty($dob) || empty($phone)) {
        $error = "All fields are required.";
        header("Location: register.php?error=" . urlencode($error));
        exit();
    } else {
        //prepared statement for checking if user already exists
        $d_query = "SELECT * FROM patient WHERE patient_name = ? AND patient_email = ?";
        $stmt = mysqli_prepare($conn, $d_query);
        mysqli_stmt_bind_param($stmt, "ss", $name, $email);
        mysqli_stmt_execute($stmt);
        $queryResult = mysqli_stmt_get_result($stmt);



        if (mysqli_num_rows($queryResult) > 0) {
            $row = mysqli_fetch_assoc($queryResult);

            if ($row['patient_name'] == $name) {
                $error = "User with this name already exists.";
            } elseif ($row['patient_email'] == $email) {
                $error = "User with this email already exists.";
            }
            header("Location: register.php?error=" . urlencode($error));
            exit();
        } else {
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
        mysqli_stmt_close($stmt);
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