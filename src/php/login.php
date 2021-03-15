<?php
session_start();

include_once "config.php";
include_once "functions.php";
include_once "exceptions.php";


class Data {
    public function __construct(mysqli $connection, string $email, string $password) {
        $this->email = mysqli_real_escape_string($connection, $email);
        $this->password = mysqli_real_escape_string($connection, $password);
        
        if (anyEmptyElement([$email, $password])) {
            throw new IncompleteData();
        }
    }
}

try {
    $data = new Data($connection, $_POST['email'], $_POST['password']);

    matchCredentials($connection, $data);

    echo "success";
} catch (IncompleteData $e) {
    echo "All input fields are required";

} catch (InvalidCredentials $e) {
    echo "Email or Password is incorrect!";
}

function matchCredentials(mysqli $connection, Data $data) {
    $sql = mysqli_query($connection, "
        SELECT * FROM users 
        WHERE email = '{$data->email}' 
        AND password = '{$data->password}'    
    ");

    $num_users = $sql ? mysqli_num_rows($sql) : 0;
    if ($num_users > 0) {
        $user = mysqli_fetch_assoc($sql); 
        
        $status = "Active now";
        $sql2 = mysqli_query($connection, "
            UPDATE users SET status = '{$status}'
            WHERE unique_id = {$user['unique_id']}
        ");

        if ($sql2) {
            $_SESSION['unique_id'] = $user['unique_id'];
        }
    } else {
        throw new InvalidCredentials();
    }
}