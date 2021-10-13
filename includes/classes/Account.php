<?php
class Account {

    private $con;
    private $errorArray = array();

    public function __construct($con) {
        $this->con = $con;
    }

    public function login($username, $password) {
        $password = hash("sha512", $password);

        $query = $this->con->prepare("SELECT * FROM users WHERE username=:username AND password=:password");

        $query->bindParam(":username", $username);
        $query->bindParam(":password", $password);

        $query->execute();

        if($query->rowCount() == 1) {
            return true;
        }
        else{
            array_push($this->errorArray, Constants::$loginFailed);
            return false;
        }

    }

    public function register($firstName, $lastName, $username, $email, $email2, $password, $password2) {
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateUsername($username);
        $this->validateEmails($email, $email2);
        $this->validatePasswords($password, $password2);

        if(empty($this->errorArray)) {
            return $this->insertUserDetails($firstName, $lastName, $username, $email, $password);
        }
        else {
            return false;
        }
    }

    public function updateDetails($fn, $ln, $em, $un) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateNewEmail($em, $un);

        if(empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET first_name = :fn, last_name = :ln, email = :em WHERE username = :un");
            $query->bindParam(":fn", $fn);
            $query->bindParam(":ln", $ln);
            $query->bindParam(":em", $em);
            $query->bindParam(":un", $un);

            return $query->execute();
        }
        else {
            return false;
        }
    }

    public function insertUserDetails($firstName, $lastName, $username, $email, $password) {

        $password = hash("sha512", $password);  // password hashing
        $profilePic = "assets/images/profilePictures/default.png";

        $query = $this->con->prepare("INSERT into users(first_name, last_name, username, email, password, profile_pic)
                                     VALUES(:fname, :lname, :uname, :email, :pwd, :pic)");

        $query->bindParam(":fname", $firstName);
        $query->bindParam(":lname", $lastName);
        $query->bindParam(":uname", $username);
        $query->bindParam(":email", $email);
        $query->bindParam(":pwd", $password);
        $query->bindParam(":pic", $profilePic);

        return $query->execute();

    }

    private function validateFirstName($firstName){
        if (strlen($firstName) > 25 || strlen($firstName) < 2) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($lastName){
        if (strlen($lastName) > 25 || strlen($lastName) < 2) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    private function validateUsername($username){
        if (strlen($username) > 25 || strlen($username) < 5) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        $query = $this->con->prepare("SELECT username FROM users WHERE username=:username");
        $query->bindParam(":username", $username);
        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

    private function validateEmails($email, $email2){
        if ($email != $email2) {
            array_push($this->errorArray, Constants::$emailsDoNotMatch);
            return;
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT email FROM users WHERE email=:email");
        $query->bindParam(":email", $email);
        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validateNewEmail($em, $un){

        if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT email FROM users WHERE email=:em AND username != :un");
        $query->bindParam(":em", $em);
        $query->bindParam(":un", $un);
        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validatePasswords($password, $password2){
        if ($password != $password2) {
            array_push($this->errorArray, Constants::$passwordsDoNotMatch);
            return;
        }

        // If except [^A-Za-z0-9] these characters found, it will show an error
        if(preg_match("/[^A-Za-z0-9]/", $password)) {
            array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
            return;
        }

        if (strlen($password) > 25 || strlen($password) < 5) {
            array_push($this->errorArray, Constants::$passwordLength);
            return;
        }
    }

    public function getError($error) {
        if(in_array($error, $this->errorArray)){
            return "<span class='errorMessage'> $error </span>";
        }
    }

    public function getFirstError() {
        if(!empty($this->errorArray)) {
            return $this->errorArray[0];
        }
        else {
            return "";
        }
    }

}