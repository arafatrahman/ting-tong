<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $logout_id = escape_string($get['logout_id']);
        if(isset($logout_id)){
            $status = "Offline now";
            $sql = "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}";
            $res = db_query_execute($sql);
            if($res){
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }
        }else{
            header("location: ../users.php");
        }
    }else{  
        header("location: ../login.php");
    }
?>