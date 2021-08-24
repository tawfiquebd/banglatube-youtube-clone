<?php
class User {

    private $con;
    private $sqlData;

    public function __construct($con, $username) {
        $this->con = $con;

        $query = $this->con->prepare("SELECT * FROM users WHERE username=:username");
        $query->bindParam(":username", $username);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getUsername() {
        return $this->sqlData["username"];
    }

    public function getName() {
        return $this->sqlData["first_name"] ." ". $this->sqlData["last_name"];
    }

    public function getFirstName() {
        return $this->sqlData["first_name"];
    }

    public function getLastName() {
        return $this->sqlData["last_name"];
    }

    public function getEmail() {
        return $this->sqlData["email"];
    }

    public function getProfilePic() {
        return $this->sqlData["profile_pic"];
    }

    public function getSignUpDate() {
        return $this->sqlData["signup_date"];
    }
}