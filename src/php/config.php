<?php

$connection = mysqli_connect("localhost", "root", "usbw", "chat", 3307);

if(!$connection) {
    echo "Database not connected".mysqli_connect_error();
}