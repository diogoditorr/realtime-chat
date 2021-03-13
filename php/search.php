<?php

include_once "config.php";

$output = "";
$searchTerm = mysqli_real_escape_string($connection, $_POST['searchTerm']);

$sql = mysqli_query($connection, "SELECT * FROM users WHERE first_name LIKE '%{$searchTerm}%' OR last_name LIKE '%{$searchTerm}%'");
$num_rows = $sql ? mysqli_num_rows($sql) : 0;
if ($num_rows  > 0) {
    include "user_reference.php";
} else {
    $output .= "No user found related to your search term";
}

echo $output;