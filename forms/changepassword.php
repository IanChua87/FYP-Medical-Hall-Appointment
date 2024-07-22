<?php
ob_start();
session_start();

include "../db_connect.php";

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Change Password</title>
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

<!--navbar-->
<?php include '../navbar.php'; ?>

<div class="container mt-5">
    <?php
    if (isset($_GET['error'])) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
    }
    if (isset($_GET['message'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars($_GET['message']) . '</div>';
    }
    ?>
</div>

<?php
ob_end_flush();
 ?>
<section class="d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-12 col-lg-6 text-black right-col">
                <div class="form-container-password">
                    <form id="passwordForm" method="post" action="dochangepassword.php">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" value="<?php echo htmlspecialchars($patient_name); ?>" hidden/>
                        </div>
                        <h2 class="text">Change Password</h2>
                        <br>
                        <div class="form-outline mb-4">
                        <label for="newpassword">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span> New Password:
                                <span class="required-text">(required)</span>
                        </label>
                        <input type="password" id="idPassword" class="form-control form-control-lg" placeholder="Password" name="newpassword" required/>
                        </div>
                        <div class="form-outline mb-4">
                        <label for="cfmpassword">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span> Confirm Password:
                                <span class="required-text">(required)</span>
                        </label>
                        <input type="password" id="idPasswordConfirm" class="form-control form-control-lg" placeholder="Password" name="cfmpassword" required/>
                        </div>
                        <br>
                        <div class="row mt-3">
                            <div class="col-6">
                            <a href="../P_index.php" class="btn back-btn">Back</a>
                            </div>
                            <div class="col-6">
                                <button type="submit" id="saveButton" class="btn save-btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<br>


</body>

</html>