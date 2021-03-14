<?php
session_start();

include_once "config.php";
$sql = mysqli_query($connection, "SELECT * FROM users");
$output = "";

$num_rows = $sql ? mysqli_num_rows($sql) : 0;
if ($num_rows == 1) {
    $output .= "No users are available to chat";
} elseif ($num_rows > 0) {
    include "user_reference.php";
}

echo $output;
