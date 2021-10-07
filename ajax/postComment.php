<?php
require_once("../includes/config.php");
require_once("../includes/classes/User.php");
require_once("../includes/classes/Comment.php");

if(isset($_POST['commentText']) && isset($_POST['postedBy']) && isset($_POST['videoId'])) {

    $userLoggedInObj = new User($con, $_SESSION["userLoggedIn"]);

    $postedBy   = $_POST['postedBy'];
    $videoId    = $_POST['videoId'];
    $responseTo = isset($_POST['responseTo']) ? $_POST['responseTo'] : 0;
    $body       = $_POST['commentText'];

    $query = $con->prepare("INSERT INTO comments(posted_by, video_id, response_to, body) 
                                VALUES(:postedBy, :videoId, :responseTo, :body)");
    $query->bindParam(":postedBy", $postedBy);
    $query->bindParam(":videoId", $videoId);
    $query->bindParam(":responseTo", $responseTo);
    $query->bindParam(":body", $body);

    $query->execute();

    $lastId = $con->lastInsertId(); // get last insert id

    $newComment = new Comment($con, $lastId, $userLoggedInObj, $videoId);

    echo $newComment->create();
}
else{
    echo "One or more parameters are not passed into file";
}