<?php
class ProfileData {

    private $con, $profileUserObj;

    public function __construct($con, $profileUsername) {
        $this->con = $con;
        $this->profileUserObj = new User($con, $profileUsername);
    }

    public function getProfileUsername() {
        return $this->profileUserObj->getUsername();
    }

    public function userExists() {
        $username = $this->getProfileUsername();
        $query = $this->con->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindParam(":username", $username);
        $query->execute();

        return $query->rowCount() != 0;
    }

}