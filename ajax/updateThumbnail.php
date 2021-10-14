<?php
require_once("../includes/config.php");

if(isset($_POST['video_id']) && isset($_POST['thumbnail_id'])) {
    $videoId = $_POST['video_id'];
    $thumbnailId = $_POST['thumbnail_id'];

    $query = $con->prepare("UPDATE thumbnails SET selected = 0 WHERE video_id = :video_id ");
    $query->bindParam(":video_id", $videoId);
    $query->execute();

    $query = $con->prepare("UPDATE thumbnails SET selected = 1 WHERE id = :thumbnail_id ");
    $query->bindParam(":thumbnail_id", $thumbnailId);
    $query->execute();

}
else{
    echo "One or more parameter are not passed in the updateThumbnail.php file";
}
