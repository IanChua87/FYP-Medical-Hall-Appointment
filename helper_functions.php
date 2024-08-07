<?php
function check_empty_register_input_fields($name, $email, $password, $confirm_password, $dob, $phone)
{
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($dob) || empty($phone)) {
        return true;
    } else {
        return false;
    }
}

function check_empty_add_patient_input_fields($name, $email, $password, $dob, $phone)
{
    if (empty($name) || empty($email) || empty($password) || empty($dob) || empty($phone)) {
        return true;
    } else {
        return false;
    }
}

function check_empty_edit_patient_input_fields($name, $email, $dob, $phone, $payment_status)
{
    if (empty($name) || empty($email) || empty($dob) || empty($phone) || empty($payment_status)) {
        return true;
    } else {
        return false;
    }
}

function check_empty_edit_appointment_input_fields($start_time)
{
    if (empty($start_time)) {
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

function check_empty_edit_users_input_fields($name, $email)
{
    if (empty($name) || empty($email)) {
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

function check_contact_us_input_fields($name, $email, $message)
{
    if (empty($name) || empty($email) || empty($message)) {
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
    // Check if the phone number starts with 8 or 9 and is followed by 7 digits
    if (!preg_match("/^[89][0-9]{7}$/", $phone)) {
        return true;
    } else {
        return false;
    }
}


function invalid_number($number)
{
    if (!preg_match("/^[0-9]*$/", $number)) {
        return true;
    } else {
        return false;
    }
}

function invalid_date($date)
{
    if (!preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $date)) {
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

function check_email_exists_in_db($conn, $email, $patient_id)
{
    $p_query = "SELECT * FROM patient WHERE patient_email = ? AND patient_id != ?";
    $patient_stmt = mysqli_prepare($conn, $p_query);

    if (!$patient_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($patient_stmt, "si", $email, $patient_id);
        mysqli_stmt_execute($patient_stmt);
        $p_result = mysqli_stmt_get_result($patient_stmt);

        if ($p_user_data = mysqli_fetch_assoc($p_result)) {
            return $p_user_data;
        } else {
            return false;
        }
    }
}

function check_user_old_enough($dob)
{
    $today = new DateTime(date("Y-m-d"));
    $dob = new DateTime($dob);
    $age = $today->diff($dob)->y;

    // Return true if the user is 18 or older
    if ($age >= 18) {
        return true;
    } else {
        return false;
    }
}


function check_patient_phone_exists($conn, $phone)
{
    $p_query = "SELECT * FROM patient WHERE patient_phoneNo = ?";
    $patient_stmt = mysqli_prepare($conn, $p_query);

    if (!$patient_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($patient_stmt, "i", $phone);
        mysqli_stmt_execute($patient_stmt);
        $p_result = mysqli_stmt_get_result($patient_stmt);

        if ($p_user_data = mysqli_fetch_assoc($p_result)) {
            return $p_user_data;
        } else {
            return false;
        }
    }
}

function check_phone_exists_in_db($conn, $phone, $patient_id)
{
    $p_query = "SELECT * FROM patient WHERE patient_phoneNo = ? AND patient_id != ?";
    $patient_stmt = mysqli_prepare($conn, $p_query);

    if (!$patient_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($patient_stmt, "ii", $phone, $patient_id);
        mysqli_stmt_execute($patient_stmt);
        $p_result = mysqli_stmt_get_result($patient_stmt);

        if ($p_user_data = mysqli_fetch_assoc($p_result)) {
            return $p_user_data;
        } else {
            return false;
        }
    }
}


function check_patient_password($conn, $password, $patient_id)
{
    $p_query = "SELECT * FROM patient WHERE patient_password = ? AND patient_id = ?";
    $patient_stmt = mysqli_prepare($conn, $p_query);

    if (!$patient_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($patient_stmt, "si", $password, $patient_id);
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

function check_appointment_exists_by_queue_no($conn, $queue_no)
{
    $a_query = "SELECT * FROM appointment WHERE queue_no = ?";
    $appointment_stmt = mysqli_prepare($conn, $a_query);

    if (!$appointment_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($appointment_stmt, "i", $queue_no);
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
        if ($password === $p_user_data['patient_password']) {
            $_SESSION['patient_id'] = $p_user_data['patient_id'];
            return true;
        } else {
            return false;
        }
    } else {
        return false;
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
        if ($password === $u_user_data['user_password']) {
            if ($u_user_data['role'] == "Admin") {
                $_SESSION['admin_id'] = $u_user_data['user_id'];
                $_SESSION['admin_role'] = $u_user_data['role'];
                header("Location: ../adminDashboard.php");
                exit();
            } else if ($u_user_data['role'] == "Doctor") {
                $_SESSION['doctor_id'] = $u_user_data['user_id'];
                header("Location: ../d_index.php");
                exit();
            }
        } else {
            return false;
        }
    }
}

function insert_patient_details($conn, $name, $dob, $phone, $email, $password, $status, $last_updated_by, $last_updated_datetime, $payment_status, $amount_payable, $is_verified)
{
    $insert = "INSERT INTO patient (patient_name, patient_dob, patient_phoneNo, patient_email, patient_password, patient_status, last_updated_by, last_updated_datetime, payment_status, amount_payable, is_verified) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($insert_stmt, "ssisssssssi", $name, $dob, $phone, $email, $password, $status, $last_updated_by, $last_updated_datetime, $payment_status, $amount_payable, $is_verified);

    //execute the prepared statement
    if (mysqli_stmt_execute($insert_stmt)) {
        return true;
    } else {
        return false;
    }
}

function insert_users_details($conn, $name, $email, $password, $role)
{
    $insert = "INSERT INTO users (user_name, user_email, user_password, role) VALUES (?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($insert_stmt, "ssss", $name, $email, $password, $role);

    //execute the prepared statement
    mysqli_stmt_execute($insert_stmt);
}

function insert_appointment_details($conn, $date, $start_time, $end_time, $status, $booked_by, $current_time, $patient_id, $queue_no, $remark)
{
    try {
        $start_time_24 = convert_to_24_hour_format($start_time);
        $end_time_24 = convert_to_24_hour_format($end_time);
    } catch (Exception $e) {
        echo "Error in time conversion: " . $e->getMessage();
        return false;
    }

    $insert = "INSERT INTO appointment (appointment_date, appointment_start_time, appointment_end_time, appointment_status, booked_by, booked_datetime, patient_id, queue_no, appointment_remarks) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert);

    mysqli_stmt_bind_param($insert_stmt, "ssssssiis", $date, $start_time_24, $end_time_24, $status, $booked_by, $current_time, $patient_id, $queue_no, $remark);

    //execute the prepared statement
    mysqli_stmt_execute($insert_stmt);
}

function convert_to_24_hour_format($time_12_hour)
{
    if (strpos($time_12_hour, 'AM') !== false || strpos($time_12_hour, 'PM') !== false) {
        $dateTime = DateTime::createFromFormat('h:i A', $time_12_hour);
    } else {
        $dateTime = DateTime::createFromFormat('H:i:s', $time_12_hour);
    }

    if ($dateTime === false) {
        throw new Exception("Invalid time format: $time_12_hour");
    }

    return $dateTime->format('H:i:s');
}

function insert_relation_details($conn, $name, $appointment_id)
{
    $insert = "INSERT INTO relation (relation_name, appointment_id) VALUES (?, ?)";
    $insert_stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($insert_stmt, "si", $name, $appointment_id);

    //execute the prepared statement
    mysqli_stmt_execute($insert_stmt);
}

function update_patient_details($conn, $name, $dob, $phone, $email, $payment_status, $amount_payable, $patient_id)
{
    $update = "UPDATE patient SET patient_name = ?, patient_dob = ?, patient_phoneNo = ?, patient_email = ?, payment_status = ?, amount_payable = ? WHERE patient_id = ?";
    $update_stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($update_stmt, "ssissdi", $name, $dob, $phone, $email, $payment_status, $amount_payable, $patient_id);

    //execute the prepared statement
    mysqli_stmt_execute($update_stmt);
}

function update_appointment_details($conn, $date, $start_time, $end_time, $status, $current_time, $appointment_id)
{
    try {
        $start_time_24 = convert_to_24_hour_format($start_time);
        $end_time_24 = convert_to_24_hour_format($end_time);
    } catch (Exception $e) {
        echo "Error in time conversion: " . $e->getMessage();
        return false;
    }

    $update = "UPDATE appointment SET appointment_date = ?, appointment_start_time = ?, appointment_end_time = ?, appointment_status = ?, booked_datetime = ? WHERE appointment_id = ?";
    $update_stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($update_stmt, "sssssi", $date, $start_time_24, $end_time_24, $status, $current_time, $appointment_id);

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

function update_patient_password($conn, $password, $patient_id)
{
    $update = "UPDATE patient SET patient_password = ? WHERE patient_id = ?";
    $update_stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($update_stmt, "si", $password, $patient_id);

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
    } else {
        return false;
    }
}

function email_exists_for_other_patient($conn, $email, $patient_id)
{
    $sql = "SELECT * FROM patient WHERE patient_email = ? AND patient_id != ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "si", $email, $patient_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        return true;
    }
    return false;
}

function email_exists_for_other_user($conn, $email, $user_id)
{
    $sql = "SELECT * FROM users WHERE user_email = ? AND user_id != ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, "si", $email, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        return true;
    }
    return false;
}

function update_patient_status($conn, $status, $patient_id)
{
    $update = "UPDATE patient SET patient_status = ? WHERE patient_id = ?";
    $update_stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($update_stmt, "si", $status, $patient_id);

    //execute the prepared statement
    mysqli_stmt_execute($update_stmt);
}

function count_appointments($conn, $patient_id)
{
    // SQL query to count the number of upcoming appointments for the patient
    $query = "SELECT COUNT(*) AS appointment_count 
              FROM appointment 
              WHERE patient_id = ? AND appointment_status = 'UPCOMING'";

    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
        die('MySQL prepare error: ' . mysqli_error($conn));
    }

    // Bind the patient_id parameter
    mysqli_stmt_bind_param($stmt, "i", $patient_id);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $appointment_count);

    mysqli_stmt_fetch($stmt);

    mysqli_stmt_close($stmt);

    return $appointment_count;
}

function cancel_past_appointments($conn)
{
    // SQL query to cancel past appointments
    $query = "UPDATE appointment 
              SET appointment_status = 'CANCELLED' 
              WHERE appointment_status = 'UPCOMING' AND appointment_date < CURDATE()";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
        error_log('MySQL prepare error: ' . mysqli_error($conn));
        return false;
    }

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}

function reset_queue_number_for_next_day($conn)
{
    // Create a log file path
    $logFile = 'reset_queue.log';
    $log = fopen($logFile, 'a');

    // Log the date and time the script is run
    fwrite($log, "Running reset_queue.php at " . date('Y-m-d H:i:s') . "\n");

    $query = "UPDATE appointment SET queue_no = 0 WHERE appointment_date = CURDATE()";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
        $error = 'MySQL prepare error: ' . mysqli_error($conn);
        fwrite($log, $error . "\n");
        die($error);
    }

    if (mysqli_stmt_execute($stmt) === false) {
        $error = 'MySQL execute error: ' . mysqli_stmt_error($stmt);
        fwrite($log, $error . "\n");
        die($error);
    }

    // Log success
    fwrite($log, "Queue numbers reset successfully.\n");

    mysqli_stmt_close($stmt);

    // Log the completion time
    fwrite($log, "Script completed at " . date('Y-m-d H:i:s') . "\n\n");

    // Close the log file
    fclose($log);
}

function check_latest_queue_no($conn)
{
    $query = "SELECT MAX(queue_no) AS latest_queue_no FROM appointment WHERE appointment_date < CURDATE()";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt === false) {
        die('MySQL prepare error: ' . mysqli_error($conn));
    }

    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $latest_queue_no);

    mysqli_stmt_fetch($stmt);

    mysqli_stmt_close($stmt);

    return $latest_queue_no;
}

function getCount($conn, $query)
{
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return (int)$row[array_key_first($row)]; // Get the first key's value
    } else {
        return 0;
    }
}

function check_patient_exist_by_payment_status($conn, $patient_id)
{
    $query = "SELECT * FROM patient WHERE payment_status = 'UNPAID' AND patient_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($stmt, "i", $patient_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user_data = mysqli_fetch_assoc($result)) {
            return $user_data;
        } else {
            return false;
        }
    }
}

function update_relation_details($conn, $name, $appointment_id)
{
    $update = "UPDATE relation SET relation_name = ? WHERE appointment_id = ?";
    $update_stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($update_stmt, "si", $name, $appointment_id);

    //execute the prepared statement
    mysqli_stmt_execute($update_stmt);
}

function check_appointment_by_appointment_status($conn, $id)
{
    $query = "SELECT * FROM appointment WHERE appointment_status = 'UPCOMING' AND appointment_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user_data = mysqli_fetch_assoc($result)) {
            return $user_data;
        } else {
            return false;
        }
    }
}

function check_appointment_date_time_conflict($conn, $date, $start_time)
{
    $query = "SELECT * FROM appointment WHERE appointment_date = ? AND appointment_start_time = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $date, $start_time);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user_data = mysqli_fetch_assoc($result)) {
            return $user_data;
        } else {
            return false;
        }
    }
}

// function select_taken_time_slot($conn, $date)
// {
//     $query = "SELECT appointment_start_time FROM appointment WHERE appointment_date = ?";
//     $stmt = mysqli_prepare($conn, $query);

//     if (!$stmt) {
//         die("Failed to prepare statement");
//     } else {
//         mysqli_stmt_bind_param($stmt, "s", $date);
//         mysqli_stmt_execute($stmt);
//         $result = mysqli_stmt_get_result($stmt);

//         $takenTimeSlots = [];

//         while($row = mysqli_fetch_assoc($result)) {
//             $takenTimeSlots[] = date('h:i A', strtotime($row['appointment_start_time']));
//         }
//         return $takenTimeSlots;
//     }
// }
