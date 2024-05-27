<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Forgot</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
</head>

<body>
    <section class="forgot-password vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 px-0 d-none d-sm-block">
                    <img src="../img/side-image.png" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
                <div class="col-sm-4 text-black right-col">
                    <div class="form-container">
                        <h3 class="text">Reset Password</h3>
                        <form method="post" action="../index.php">
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" class="form-control form-control-lg" placeholder="Email" />
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="form2Example28" class="form-control form-control-lg" placeholder="Password" />
                            </div>

                            <!-- Simple link -->
                            <a href="login.php" class="forgot-text">Remember password?</a>

                            <div class="mt-3">
                                <button type="submit" class="btn reset-btn">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>

</html>

<?php
