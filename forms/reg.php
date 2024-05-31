<?php
include "../db_connect.php";
?>


<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];

    $msg = "";
    $error = "";

    if (empty($name) || empty($email) || empty($password) || empty($dob) || empty($phone)) {
        $error = "All fields are required.";
    } else {
        //prepared statement for checking if user already exists
        $query = "SELECT * FROM patient WHERE patient_name = ? AND patient_email = ?";
        $stmt = mysqli_prepare($conn, $query);
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
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //prepared statement for inserting user into database, for security purpose
            $insert = "INSERT INTO patient (patient_name, patient_dob, patient_phoneNo, patient_email, patient_password) 
                   VALUES (?, ?, ?, ?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert);
            //bind parameters to the prepared statement
            mysqli_stmt_bind_param($insert_stmt, "sssss", $name, $dob, $phone, $email, $hashed_password);

            //execute the prepared statement
            if (mysqli_stmt_execute($insert_stmt)) {
                $msg = "<h2>Registration<br> successful</h2>";
            } else {
                $error = "Registration failed";
            }
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} 
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
                    <?php if (!empty($error)) { ?>
                        <div class="form-container">

                            <form method="post">

                                <h3 class="text">Create<br> Account</h3>
                                <p class="registered-prompt">Already registered? <span> <a href="login.php">Login</a> </span>now</p>

                                <div class="form-outline mb-4">
                                    <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" />
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" />
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="form2Example28" class="form-control form-control-lg"
                                        placeholder="Password" name="password" />
                                </div>

                                <div class="double-form-field row mb-4">
                                    <div class="col">
                                    <input type="date" class="form-control date-input" id="dob" name="dob">
                                    </div>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="number" id="form2Example28" class="form-control form-control-lg"
                                        placeholder="Phone Number" name="phone" />
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn register-btn">Create Account</button>
                                </div>
                            </form>
                            <?php echo $error; ?>
                        </div>
                        

                    <?php } 

                    elseif (!empty($msg)) { ?>
                        <div class="verified-box">
                            <img src="../img/tick-verification.svg" alt="Tick logo symbol" />
                            <?php echo $msg ?>
                            <div class="mt-3">
                                <a href="login.php" class="btn login-btn">Login</a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="form-container">

                            <form method="post">

                                <h3 class="text">Create<br> Account</h3>
                                <p class="registered-prompt">Already registered? <span> <a href="login.php">Login</a> </span>now</p>

                                <div class="form-outline mb-4">
                                    <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" />
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" />
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="form2Example28" class="form-control form-control-lg"
                                        placeholder="Password" name="password" />
                                </div>

                                <div class="double-form-field row mb-4">
                                    <div class="col">
                                    <input type="date" class="form-control date-input" id="dob" name="dob">
                                    </div>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="number" id="form2Example28" class="form-control form-control-lg"
                                        placeholder="Phone Number" name="phone" />
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn register-btn">Create Account</button>
                                </div>
                            </form>
                        </div>
                    <?php } ?>
                </div>




</body>

</html>

<?php
?>