<?php
session_start();

include_once "config.php";

class IncompleteData extends Exception {}

class NoImageFile extends Exception {}

class InvalidImageFile extends Exception {}

class FailedImageUpload extends Exception {}

class InvalidEmail extends Exception {}

class EmailAlreadyExists extends Exception {}

class MySqliException extends Exception {
    function __construct(string $error) {
        parent::__construct($error);
    }
}

class Data {
    public function __construct(mysqli $connection, string $firstName, string $lastName, string $email, string $password) {
        $this->firstName = mysqli_real_escape_string($connection, $firstName);
        $this->lastName = mysqli_real_escape_string($connection, $lastName);
        $this->email = mysqli_real_escape_string($connection, $email);
        $this->password = mysqli_real_escape_string($connection, $password);
        
        if (anyEmptyElement([$firstName, $lastName, $email, $password])) {
            throw new IncompleteData();
        }

        $this->image = Image::get();
    }
}

class Image {
    public function __construct(array $image) {
        date_default_timezone_set("America/Sao_Paulo");
        $this->name = $image['name'];
        $this->type = $image['type'];
        $this->tmpNamePath = $image['tmp_name'];
        
        $exploded = explode('.', $this->name);
        $this->extension = end($exploded);

        $this->nameFormated = date("H-i-s")."_".date("d-m-Y")."_".$this->name;
    }

    public static function get() {
        if (!empty($_FILES['image']['name'])) {
            return new Image($_FILES['image']);
        } else {
            throw new NoImageFile();
        }
    }
}

try {
    $data = new Data(
        $connection, 
        $_POST['firstName'], 
        $_POST['lastName'], 
        $_POST['email'], 
        $_POST['password']
    );

    validateEmail($data->email);
    verifyEmailExists($connection, $data->email);
    validateImageExtension($data->image);

    storageImage($data->image);
    registerUser($connection, $data);

    verifyUserRegistration($connection, $data);

    echo "success";

} catch (IncompleteData $e) {
    echo "All input field are required!";
    
} catch (NoImageFile $e) {
    echo "Please select an Image File!";

} catch (InvalidEmail $e) {
    echo "{$data->email} - This is not a valid email";

} catch (EmailAlreadyExists $e) {
    echo "{$data->email} - This email already exist!";

} catch (InvalidImageFile $e) {
    echo "
        Select a valid Image File - jpeg, jpg, png
        \"{$data->image->extension}\" given.
    ";

} catch (MySqliException $e) {
    echo "Something went wrong!\n{$e->message}";

} catch (FailedImageUpload $e) {
    echo "It was not possible to upload the image";

} catch (Exception $e) {
    echo "Something went wrong!";
}

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

function validateEmail(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidEmail();
    }
}

function verifyEmailExists(mysqli $connection, $email) {
    $sql = mysqli_query($connection, "SELECT email FROM users WHERE email = '{$email}'");
    
    $num_rows = $sql ? mysqli_num_rows($sql) : 0;
    if ($num_rows > 0) {
        throw new EmailAlreadyExists();
    }
}

function validateImageExtension(Image $image) {
    $extensions = ['png', 'jpeg', 'jpg'];
    if (!in_array($image->extension, $extensions)) {
        throw new InvalidImageFile();
    }
}

function storageImage(Image $image) {
    if (!move_uploaded_file($image->tmpNamePath, "images/".$image->nameFormated)) {
        throw new FailedImageUpload();
    }
}

function registerUser(mysqli $connection, Data $data) {
    $status = "Active now";
    $random_id = rand(time(), 10000000);

    $query = "
        INSERT INTO users (unique_id, first_name, last_name, email, password, image, status) 
        VALUES (
            {$random_id}, '{$data->firstName}', '{$data->lastName}', '{$data->email}', 
            '{$data->password}', '{$data->image->nameFormated}', '{$status}'
        )
    ";

    $sql = mysqli_query($connection, $query);
    if (!$sql) {
        throw new MySqliException($connection->error);
    }
}

function verifyUserRegistration(mysqli $connection, Data $data) {
    $sql = mysqli_query($connection, "SELECT * FROM users WHERE email = '{$data->email}'");
    
    $num_rows = $sql ? mysqli_num_rows($sql) : 0;
    if ($num_rows > 0) {
        $row = mysqli_fetch_assoc($sql);
        $_SESSION['unique_id'] = $row['unique_id'];
    } else {
        throw new Exception();
    }
}