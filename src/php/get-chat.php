<?php

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
    $num_messages = $sql ? mysqli_num_rows($sql) : 0;
    if ($num_messages > 0) {
        while ($message = mysqli_fetch_assoc($sql)) {
            if ($message['outgoing_user_id'] === $outgoing_user_id) {
                $output .= '
                    <div class="chat outgoing">
                        <div class="details">
                            <p>'.$message['msg'].'</p>
                        </div>
                    </div>
                ';
            } else {
                $output .= '
                    <div class="chat incoming">
                        <img src="php/images/'.$message['image'].'" alt="">
                        <div class="details">
                            <p>'.$message['msg'].'</p>
                        </div>
                    </div>
                ';
            }
        }

        echo $output;
    }
    
} else {
    header("../login.php");
}