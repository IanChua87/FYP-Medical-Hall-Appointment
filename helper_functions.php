<?php
function check_empty_register_input_fields($name, $email, $password, $dob, $phone)
{
    if (empty($name) || empty($email) || empty($password) || empty($dob) || empty($phone)) {
        return true;
    } else {
        return false;
    }
}

function invalid_email($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function invalid_name($name)
{
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        return true;
    } else {
        return false;
    }
}

function invalid_phone_number($phone)
{
    if (!preg_match("/^[0-9]*$/", $phone)) {
        return true;
    } else {
        return false;
    }
}

function check_password_strength($password)
{
    if (strlen($password) < 8) {
        return "Password must be at least 8 characters long.";
    }
    // if(!preg_match("/^[0-9]*$/", $password)){
    //     return "Password must contain at least one number.";
    // }
    // if(!preg_match("/[A-Z]/", $password)){
    //     return "Password must contain at least one uppercase letter.";
    // }
    // if(!preg_match("/[a-z]/", $password)){
    //     return "Password must contain at least one lowercase letter.";
    // }
    // if (!preg_match('/[!@#$%^&*()\-_=+{}[\]|;:\'",.<>\/?]/', $password)) {
    //     return "Password must include at least one special character.";
    // }
}

function check_patient_exists_by_email($conn, $email)
{
    $p_query = "SELECT * FROM patient WHERE patient_email = ?";
    $patient_stmt = mysqli_prepare($conn, $p_query);

    if (!$patient_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($patient_stmt, "s", $email);
        mysqli_stmt_execute($patient_stmt);
        $p_result = mysqli_stmt_get_result($patient_stmt);

        if($p_user_data = mysqli_fetch_assoc($p_result)){
            return $p_user_data;
        } 
        else {
            return false;
        }
    }
}

function login_patient($conn, $email, $password)
{
    if (check_patient_exists_by_email($conn, $email) !== false) {
        $p_user_data = check_patient_exists_by_email($conn, $email);
        if(password_verify($password, $p_user_data['patient_password'])){
            $_SESSION['patient_id'] = $p_user_data['patient_id'];
            header("Location: ../index.php");
            exit();
        } else{
            $_SESSION['login-error'] = "Invalid password, please try again";
            return $_SESSION['login-error'];
        }
    } else{
        $_SESSION['login-error'] = "Email not found, please try again";
        return $_SESSION['login-error'];
    }
}

function check_users_exists_by_email($conn, $email)
{
    $u_query = "SELECT * FROM users WHERE user_email = ?";
    $user_stmt = mysqli_prepare($conn, $u_query);

    if (!$user_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($user_stmt, "s", $email);
        mysqli_stmt_execute($user_stmt);
        $u_result = mysqli_stmt_get_result($user_stmt);

        if ($u_user_data = mysqli_fetch_assoc($u_result)) {
            return $u_user_data;  
        } else {
            return false;
        }
    }
}

function login_users($conn, $email, $password)
{
    if (check_users_exists_by_email($conn, $email) !== false) {
        $u_user_data = check_users_exists_by_email($conn, $email);
        if(password_verify($password, $u_user_data['user_password'])){
            if ($u_user_data['role'] == "Admin") {
                $_SESSION['admin_id'] = $u_user_data['user_id'];
                $_SESSION['admin_role'] = $u_user_data['role'];
                header("Location: ../adminDashboard.php");
                exit();
            } else if ($u_user_data['role'] == "Doctor") {
                $_SESSION['doctor_id'] = $u_user_data['user_id'];
                header("Location: ../index.php");
                exit();
            }

        } else{
            $_SESSION['login-error'] = "Invalid password, please try again";
            return $_SESSION['login-error'];
        }
    } else{
        $_SESSION['login-error'] = "Email not found, please try again";
        return $_SESSION['login-error'];
    }
}

function insert_patient_details($conn, $name, $dob, $phone, $email, $hashed_password, $status, $last_updated_by, $last_updated_datetime, $payment_status, $amount_payable, $is_verified)
{
    $insert = "INSERT INTO patient (patient_name, patient_dob, patient_phoneNo, patient_email, patient_password, patient_status, last_updated_by, last_updated_datetime, payment_status, amount_payable, is_verified) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($insert_stmt, "ssisssssssi", $name, $dob, $phone, $email, $hashed_password, $status, $last_updated_by, $last_updated_datetime, $payment_status, $amount_payable, $is_verified);

    //execute the prepared statement
    mysqli_stmt_execute($insert_stmt);
}

function update_patient_password($conn, $password)
{
    $update = "UPDATE patient SET patient_password = ? WHERE patient_id = ?";
    $update_stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($update_stmt, "si", $password, $_SESSION['patient_id']);

    //execute the prepared statement
    mysqli_stmt_execute($update_stmt);
}

function check_empty_login_input_fields($email, $password)
{
    if (empty($email) || empty($password)) {
        return true;
    } else {
        return false;
    }
}

function check_empty_reset_password_input_fields($email, $oldPassword, $newPassword)
{
    if (empty($email) || empty($oldPassword) || empty($newPassword)) {
        return true;
    } else {
        return false;
    }
}
