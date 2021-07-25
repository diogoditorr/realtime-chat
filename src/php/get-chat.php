<?php

header('Content-Type: application/json;charset=utf-8');

session_start();

if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $outgoing_user_id = mysqli_real_escape_string($connection, $_POST['outgoing_user_id']);
    $incoming_user_id = mysqli_real_escape_string($connection, $_POST['incoming_user_id']);
    $output = "";

    $query = "
        SELECT * FROM messages
        LEFT JOIN users ON users.unique_id = messages.outgoing_user_id
        WHERE (outgoing_user_id = {$outgoing_user_id} AND incoming_user_id = {$incoming_user_id})
           OR (outgoing_user_id = {$incoming_user_id} AND incoming_user_id = {$outgoing_user_id})
        ORDER BY msg_id ASC
    ";
    $sql = mysqli_query($connection, $query);
    // $num_messages = $sql ? mysqli_num_rows($sql) : 0;
    
    // if ($num_messages > 0) {
    //     echo json_encode(
    //         $sql->fetch_all($mode=MYSQLI_ASSOC)
    //     );
    // }

    echo json_encode(
        $sql->fetch_all($mode=MYSQLI_ASSOC)
    );
} else {
    header("../login.php");
    echo json_encode(array('name' => 'User'));
}