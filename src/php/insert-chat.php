<?php

session_start();

// Parse json data to global variable $_POST
if (preg_match('/^application\/json.*$/', $_SERVER['CONTENT_TYPE'])) {
    $_POST = json_decode(file_get_contents("php://input"), true);
}

if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $outgoing_user_id = mysqli_real_escape_string($connection, $_POST['outgoing_user_id']);
    $incoming_user_id = mysqli_real_escape_string($connection, $_POST['incoming_user_id']);
    $message = mysqli_real_escape_string($connection, $_POST['message']);

    if (!empty($message)) {
        $sql = mysqli_query($connection, "
            INSERT INTO messages (incoming_user_id, outgoing_user_id, msg)
            VALUES ({$incoming_user_id}, {$outgoing_user_id}, '{$message}')
        ") or die();
    }
} else {
    header("../login.php");
}