<?php
session_start();
include_once "php/config.php";

if (isset($_GET['email']) && !empty($_GET['email']) and isset($_GET['hash']) && !empty($_GET['hash'])) {
    // Verify data
    $email = trim(escape_string($_GET['email']),"\'."); // Set email variable
    $getHash = escape_string($_GET['hash']); // Set hash variable
    $hash = trim($getHash,"\'.");

    $search = db_query_execute("SELECT email, id_hash, verify FROM users WHERE email='" . $email . "' AND id_hash='" . $hash . "' AND verify='0'");
    $match  = db_query_numrow($search);
    
    if ($match > 0) {
        db_query_execute("UPDATE users SET verify=1 WHERE id_hash='" . $hash . "'");
        $newURL = "http://localhost/my-chat-app/success-msg.php";
        header('Location: '.$newURL);
        die();
    } else {
        // No match -> invalid url or account has already been activated.
    }
} else {
    // Invalid approach
}

?>
