<?php
include "../db_connect.php";
?>

<!-- this is for doctor/admin -->
<?php
$msg = "";
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];


    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
        header("Location: staffRegister.php?error=" . urlencode($error));
        exit();
    } 
    else {
        //prepared statement for checking if user already exists
        $u_query = "SELECT * FROM users WHERE user_email = ? AND user_password = ?";
        $user_stmt = mysqli_prepare($conn, $u_query);
        mysqli_stmt_bind_param($user_stmt, "ss", $username, $email);
        mysqli_stmt_execute($user_stmt);
        $u_queryResult = mysqli_stmt_get_result($user_stmt);


        if (mysqli_num_rows($u_queryResult) > 0) {
            $u_row = mysqli_fetch_assoc($u_queryResult);

            if ($u_row['user_name'] == $name) {
                $error = "User with this name already exists.";
            } else if ($u_row['user_email'] == $email) {
                $error = "User with this email already exists.";
            }
            header("Location: staffRegister.php?error=" . urlencode($error));
            exit();
        } 
        else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //prepared statement for inserting user into database, for security purpose
            $insert = "INSERT INTO users (user_name, user_email, user_password, role) 
                    VALUES (?, ?, ?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert);
            mysqli_stmt_bind_param($insert_stmt, "ssss", $name, $email, $hashed_password, $role);

            //execute the prepared statement
            if (mysqli_stmt_execute($insert_stmt)) {
                $msg = "<h2>Staff<br> Registration successful</h2>";
            } else {
                $error = "Registration failed";
                header("Location: staffRegister.php?error=" . urlencode($error));
                exit();
            }
        }

        mysqli_stmt_close($insert_stmt);
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Staff Registration | Successful</title>
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