<?php
session_start();
include "../db_connect.php";
include '../helper_functions.php';


if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if (check_contact_us_input_fields($name, $email, $message)) {
        $_SESSION['contact_error'] = "Please fill in all fields.";
        $_SESSION['form_data'] = $_POST;
        header("Location: ../index.php#contact");
        exit();
    }
    
    if (invalid_name($name)) {
        $_SESSION['contact_error'] = "Only letters and white space allowed in name.";
        header("Location: ../index.php#contact");
        exit();
    }
    
    if (invalid_email($email)) {
        $_SESSION['contact_error'] = "Invalid email format.";
        header("Location: ../index.php#contact");
        exit();
    }

    // Insert data into contact table
    $sql = "INSERT INTO contact (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    $stmt->close();

    // $to = "chuaxiangyuian@gmail.com";
    // $subject = "Contact Us Form Submission from $name";
    // $headers = "From: $email\r\n";
    // $headers .= "Reply-To: $email\r\n";
    // $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // $email_message = "Name: $name\n";
    // $email_message .= "Email: $email\n\n";
    // $email_message .= "Message:\n$message\n";
    
    // if (mail($to, $subject, $email_message, $headers)) {
    //     echo "Thank you for contacting us!";
    // } else {
    //     echo "Sorry, something went wrong. Please try again.";
    // }

} 
$conn->close();



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Message Sent | Successful</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
</head>

<body>
    <!-- 'header.php' contains header content -->
    <section class="contacted">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 px-0 d-sm-block left-col">
                    <img src="../img/side-img.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4 text-black right-col">
                    <div class="verified-box">
                        <img src="../img/tick-verification.svg" alt="Tick logo symbol" />
                        <h2>Message sent <br>successfully</h2>
                        <div class="mt-3">
                            <a href="../index.php" class="btn back-to-home-btn">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>

</html>

<?php
