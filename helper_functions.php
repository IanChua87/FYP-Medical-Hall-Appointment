<?php
function check_empty_register_input_fields($name, $email, $password, $confirm_password, $dob, $phone)
{
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($dob) || empty($phone)) {
        return true;
    } else {
        return false;
    }
}

function check_empty_patient_input_fields($name, $email, $password, $dob, $phone)
{
    if (empty($name) || empty($email) || empty($password) || empty($dob) || empty($phone)) {
        return true;
    } else {
        return false;
    }
}

function check_empty_users_input_fields($name, $email, $password, $role)
{
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        return true;
    } else {
        return false;
    }
}

function check_empty_appointment_input_fields($email, $date, $time)
{
    if (empty($email) || empty($date) || empty($time)) {
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

function check_confirm_password($password, $confirm_password)
{
    if ($password !== $confirm_password) {
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

        if ($p_user_data = mysqli_fetch_assoc($p_result)) {
            return $p_user_data;
        } else {
            return false;
        }
    }
}

function check_appointment_exists_by_id($conn, $appointment_id)
{
    $p_query = "SELECT * FROM appointment WHERE appointment_id = ?";
    $appointment_stmt = mysqli_prepare($conn, $p_query);

    if (!$appointment_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($appointment_stmt, "i", $appointment_id);
        mysqli_stmt_execute($appointment_stmt);
        $a_result = mysqli_stmt_get_result($appointment_stmt);

        if ($a_user_data = mysqli_fetch_assoc($a_result)) {
            return $a_user_data;
        } else {
            return false;
        }
    }
}

function check_patient_exists_by_id($conn, $patient_id)
{
    $p_query = "SELECT * FROM patient WHERE patient_id = ?";
    $patient_stmt = mysqli_prepare($conn, $p_query);

    if (!$patient_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($patient_stmt, "i", $patient_id);
        mysqli_stmt_execute($patient_stmt);
        $p_result = mysqli_stmt_get_result($patient_stmt);

        if ($p_user_data = mysqli_fetch_assoc($p_result)) {
            return $p_user_data;
        } else {
            return false;
        }
    }
}

function check_relation_exists_by_appointment_id($conn, $appointment_id)
{
    $r_query = "SELECT * FROM relation WHERE appointment_id = ?";
    $relation_stmt = mysqli_prepare($conn, $r_query);

    if (!$relation_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($relation_stmt, "i", $appointment_id);
        mysqli_stmt_execute($relation_stmt);
        $r_result = mysqli_stmt_get_result($relation_stmt);

        if ($r_user_data = mysqli_fetch_assoc($r_result)) {
            return $r_user_data;
        } else {
            return false;
        }
    }
}

function login_patient($conn, $email, $password)
{
    if (check_patient_exists_by_email($conn, $email) !== false) {
        $p_user_data = check_patient_exists_by_email($conn, $email);
        if (password_verify($password, $p_user_data['patient_password'])) {
            $_SESSION['patient_id'] = $p_user_data['patient_id'];
            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['login-error'] = "Invalid password, please try again";
            return $_SESSION['login-error'];
        }
    } else {
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

function check_users_exists_by_id($conn, $user_id)
{
    $u_query = "SELECT * FROM users WHERE user_id = ?";
    $user_stmt = mysqli_prepare($conn, $u_query);

    if (!$user_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($user_stmt, "i", $user_id);
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
        if (password_verify($password, $u_user_data['user_password'])) {
            if ($u_user_data['role'] == "Admin") {
                $_SESSION['admin_id'] = $u_user_data['user_id'];
                $_SESSION['admin_role'] = $u_user_data['role'];
                header("Location: ../adminDashboard.php");
                exit();
            } else if ($u_user_data['role'] == "Doctor") {
                $_SESSION['doctor_id'] = $u_user_data['user_id'];
                header("Location: ../doctor_welcome_page.php");
                exit();
            }
        } else {
            $_SESSION['login-error'] = "Invalid password, please try again";
            return $_SESSION['login-error'];
        }
    } else {
        $_SESSION['login-error'] = "Email not found, please try again";
        return $_SESSION['login-error'];
    }
}

function insert_patient_details($conn, $name, $dob, $phone, $email, $hashed_password, $status, $last_updated_by, $last_updated_datetime, $payment_status, $amount_payable, $is_verified)
{
    $insert = "INSERT INTO patient (patient_name, patient_dob, patient_phoneNo, patient_email, patient_password, patient_status, last_updated_by, last_updated_datetime, payment_status, amount_payable, is_verified) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($insert_stmt, "ssisssssssi", $name, $dob, $phone, $email, $hashed_password, $status, $last_updated_by, $last_updated_datetime, $payment_status, $amount_payable, $is_verified);

    //execute the prepared statement
    if (mysqli_stmt_execute($insert_stmt)) {
        return true;
    } else {
        return false;
    }
}

function insert_users_details($conn, $name, $email, $hashed_password, $role)
{
    $insert = "INSERT INTO users (user_name, user_email, user_password, role) VALUES (?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($insert_stmt, "ssis", $name, $email, $hashed_password, $role);

    //execute the prepared statement
    mysqli_stmt_execute($insert_stmt);
}

function insert_appointment_details($conn, $date, $start_time, $end_time, $status, $booked_by, $current_time, $patient_id, $queue_no, $remark)
{
    $insert = "INSERT INTO appointment (appointment_date, appointment_start_time, appointment_end_time, appointment_status, booked_by, booked_datetime, patient_id, queue_no, appointment_remarks) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($insert_stmt, "sssssssis", $date, $start_time, $end_time, $status, $booked_by, $current_time, $patient_id, $queue_no, $remark);

    //execute the prepared statement
    mysqli_stmt_execute($insert_stmt);
}

function insert_relation_details($conn, $name, $appointment_id)
{
    $insert = "INSERT INTO relation (relation_name, appointment_id) VALUES (?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($insert_stmt, "si", $name, $appointment_id);

    //execute the prepared statement
    mysqli_stmt_execute($insert_stmt);
}

function update_patient_details($conn, $dob, $phone, $email, $payment_status, $amount_payable, $patient_id)
{
    $update = "UPDATE patient SET patient_dob = ?, patient_phoneNo = ?, patient_email = ?, payment_status = ?, amount_payable = ? WHERE patient_id = ?";
    $update_stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($update_stmt, "ssssdi", $dob, $phone, $email, $payment_status, $amount_payable, $patient_id);

    //execute the prepared statement
    mysqli_stmt_execute($update_stmt);
}

function update_appointment_details($conn, $date, $start_time, $end_time, $status, $current_time, $queue_no, $appointment_id)
{
    $update = "UPDATE appointment SET appointment_date = ?, appointment_start_time = ?, appointment_end_time = ?, appointment_status = ?, booked_datetime = ?, queue_no = ? WHERE appointment_id = ?";
    $update_stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($update_stmt, "sssssii", $date, $start_time, $end_time, $status, $current_time, $queue_no, $appointment_id);

    //execute the prepared statement
    mysqli_stmt_execute($update_stmt);
}

function update_users_details($conn, $name, $email, $user_id)
{
    $update = "UPDATE users SET user_name = ?, user_email = ? WHERE user_id = ?";
    $update_stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($update_stmt, "ssi", $name, $email, $user_id);

    //execute the prepared statement
    mysqli_stmt_execute($update_stmt);
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

function check_empty_patient_reset_password_field($password, $confirm_password)
{
    if (empty($password) || empty($confirm_password)) {
        return true;
    } else {
        return false;
    }
}

function check_password_match($password, $confirm_password)
{
    if ($password !== $confirm_password) {
        return true;
    } 
    else {
        return false;
    }
}