<?php

function anyEmptyElement(array $elements): bool {
    $empty = false;

    foreach ($elements as $element) {
        if (empty($element)) {
            $empty = true;
            break;
        }
    }

    return $empty;
}

include_once "config.php";
$firstName = mysqli_real_escape_string($connection, $_POST['firstName']);
$lastName = mysqli_real_escape_string($connection, $_POST['lastName']);
$email = mysqli_real_escape_string($connection, $_POST['email']);
$password = mysqli_real_escape_string($connection, $_POST['password']);

if (!anyEmptyElement([$firstName, $lastName, $email, $password])) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // $sql = mysqli_query($connection, "SELECT email FROM users WHERE email = `{$email}`");
        // if (mysqli_num_rows($sql) > 0) {
        //     echo "$email - This email already exist!";
        // }
    } else {
        echo "$email - This is not a valid email";
    }

    if (isset($_FILES['image'])) {
        $img_name = $_imageS['image']['name'];
        $img_type = $_imageS['image']['type'];
        $tmp_name = $_FILES['image']['tmp_name'];

        $img_explode = explode('.', $img_name);
        $img_ext = end($img_explode);

        $extensions = ['png', 'jpeg', 'jpg'];
        if (in_array($img_ext, $extensions)) {
            $time = time();
            $new_img_name = $time.$img_name;

            if (move_uploaded_file($tmp_name, "images/".$new_img_name)) {
                $status = "Active now";
                $random_id = rand(time(), 10000000)
            }
        } else {
            echo "Select a valid Image File - jpeg, jpg, png!";
        }
    } else {
        echo "Please select an Image File!";
    }
} else {
    echo "All input field are required!";
}
