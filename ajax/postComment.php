<?php
require_once("../includes/config.php");

if(isset($_POST['commentText']) && isset($_POST['postedBy']) && isset($_POST['videoId'])) {
    echo "Successfull";
}
else{
    echo "One or more parameters are not passed into subscribe.php file";
}