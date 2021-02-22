<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";
    $query = db_query_execute($sql);
    $output = "";
    if(db_query_numrow($query) == 0){
        $output .= "No users are available to chat";
    }elseif(db_query_numrow($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>