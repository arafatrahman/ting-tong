<?php
session_start();
include_once "config.php";
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
$email = escape_string($post['email']);
$password = escape_string($post['password']);
if (!empty($email) && !empty($password)) {
    $sql = "SELECT * FROM users WHERE email = '{$email}'";
    $res = db_query_execute($sql);
    if (db_query_numrow($res) > 0) {
        $row = fetch_assoc($res);
        $user_pass = md5($password);
        $enc_pass = $row['password'];
        $verifyStatus = $row['verify'];

        

        if ($user_pass === $enc_pass) {
            $status = "Active now";
            $sql2 = "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}";
            $res2 = db_query_execute($sql2);
            if ($res2) {

                if(empty($verifyStatus)){

                    echo "verify";
                   
                } else{
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success";
                }
                
            } else {
                echo "Something went wrong. Please try again!";
            }
        } else {
            echo "Email or Password is Incorrect!";
        }
    } else {
        echo "$email - This email not Exist!";
    }
} else {
    echo "All input fields are required!";
}
