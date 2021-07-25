<?php

while ($user = mysqli_fetch_assoc($sql)) {
    $query = "
        SELECT * FROM messages 
        WHERE (outgoing_user_id = {$outgoing_user_id} AND incoming_user_id = {$user['unique_id']})
           OR (outgoing_user_id = {$user['unique_id']} AND incoming_user_id = {$outgoing_user_id})
        ORDER BY msg_id DESC LIMIT 1
    ";
    $sql2 = mysqli_query($connection, $query);
    
    $message = mysqli_fetch_assoc($sql2);
    $num_messages = $sql2 ? mysqli_num_rows($sql2) : 0;
    if ($num_messages > 0) {
        $result = $message['msg'];
    } else {
        $result = "No message available";
    }

    (strlen($result) > 28) ? $msg = substr($result, 0, 28).'...' : $msg = $result;

    if (isset($message)) {
        ($outgoing_user_id === $message['outgoing_user_id']) ? $you = "You: " : $you = "";
    } else {
        $you = "";
    }

    ($user['status'] == "Offline now") ? $offline = "offline" : $offline = "";

    $output .= '
        <a href="chat.php?user_id='.$user['unique_id'].'">
            <div class="content">
                <img src="php/images/'.$user['image'].'" alt="">
                <div class="details">
                    <span>'.$user['first_name']." ".$user['last_name'].'</span>
                    <p>'.$you.$msg.'</p>
                </div>
            </div>
            <div class="status-dot '.$offline.'"><i class="fas fa-circle"></i></div>
        </a>
    ';
}