<?php
require_once("includes/header.php");
require_once("includes/classes/VideoPlayer.php");
require_once("includes/classes/VideoInfoSection.php");

if(!isset($_GET["id"])) {
    echo "No url passed into page";
    exit();
}

$video = new Video($con, $_GET['id'], $userLoggedInObj);    // video object creating
$video->incrementViews();   // increment video count

?>

<script src="assets/js/videoPlayerActions.js"></script>

<div class="watchLeftColumn">

<?php
    $videoPlayer = new VideoPlayer($video); // passing video object
    echo $videoPlayer->create(true);

    $videoInfo = new VideoInfoSection($con, $video, $userLoggedInObj); // passing video object and userloggedInObj object
    echo $videoInfo->create();
?>

</div>

<div class="suggestions">

</div>


<?php require_once("includes/footer.php"); ?>
