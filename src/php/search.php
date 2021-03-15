<?php

session_start();
include_once "config.php";

$outgoing_user_id = $_SESSION['unique_id'];
$output = "";
$searchTerm = mysqli_real_escape_string($connection, $_POST['searchTerm']);

$sql = mysqli_query($connection, "
    SELECT * FROM users 
    WHERE (first_name LIKE '%{$searchTerm}%' OR last_name LIKE '%{$searchTerm}%')
        AND NOT unique_id = {$outgoing_user_id}
");
$num_users = $sql ? mysqli_num_rows($sql) : 0;
if ($num_users > 0) {
    include "user_reference.php";
} else {
    $output .= "No user found related to your search term";
}

echo $output;