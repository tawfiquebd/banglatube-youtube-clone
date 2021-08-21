<?php
class Account {

    private $con;
    private $errorArray = array();

    public function __construct($con) {
        $this->con = $con;
    }

    public function register($firstName, $lastName, $username, $email, $email2, $password, $password2) {
        $this->validateFirstName($firstName);
    }

    private function validateFirstName($firstName){
        if (strlen($firstName) > 25 || strlen($firstName) < 2) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    public function getError($error) {
        if(in_array($error, $this->errorArray)){
            return "<span class='errorMessage'> $error </span>";
        }
    }

}