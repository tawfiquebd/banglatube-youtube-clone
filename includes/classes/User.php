<?php
class User {

    private $con;
    private $sqlData;

    public function __construct($con, $username) {
        $this->con = $con;
    }
}