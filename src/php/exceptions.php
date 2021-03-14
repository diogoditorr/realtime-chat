<?php

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

class InvalidCredentials extends Exception {}
