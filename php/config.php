<?php

$connection = mysqli_connect("localhost", "root", "usbw", "chat");

if(!$connection) {
    echo "Database not connected".mysqli_connect_error();
}