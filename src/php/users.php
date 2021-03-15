<?php
session_start();

include_once "config.php";

$output = "";

$outgoing_user_id = $_SESSION['unique_id'];

$sql = mysqli_query($connection, "SELECT * FROM users WHERE NOT unique_id = {$outgoing_user_id}");

$num_users = $sql ? mysqli_num_rows($sql) : 0;
if ($num_users == 0) {
    $output .= "No users are available to chat";
} elseif ($num_users > 0) {
    include "user_reference.php";
}

echo $output;
