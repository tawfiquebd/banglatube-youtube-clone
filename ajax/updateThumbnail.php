<?php
require_once("../includes/config.php");

if(isset($_POST['videoId']) && isset($_POST['thumbnailId'])) {
    $videoId = $_POST['videoId'];
    $thumbnailId = $_POST['$thumbnailId'];

    $query->con->prepare("UPDATE thumbnails SET selected = 0 WHERE video_id = :video_id ");
    $query->bindParam(":video_id", $videoId);
    $query->execute();

    $query->con->prepare("UPDATE thumbnails SET selected = 1 WHERE id = :thumbnailId ");
    $query->bindParam(":thumbnailId", $thumbnailId);
    $query->execute();


}
else{
    echo "One or more parameter are not passed in the updateThumbnail.php file";
}
