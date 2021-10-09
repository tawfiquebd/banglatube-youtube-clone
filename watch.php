<?php
require_once("includes/header.php");
require_once("includes/classes/VideoPlayer.php");
require_once("includes/classes/VideoInfoSection.php");
require_once("includes/classes/Comment.php");
require_once("includes/classes/CommentSection.php");

if(!isset($_GET["id"])) {
    echo "No url passed into page";
    exit();
}

$video = new Video($con, $_GET['id'], $userLoggedInObj);    // video object creating
$video->incrementViews();   // increment video count

?>

<script src="assets/js/videoPlayerActions.js"></script>
<script src="assets/js/commentActions.js"></script>

<div class="watchLeftColumn">

<?php
    $videoPlayer = new VideoPlayer($video); // passing video object
    echo $videoPlayer->create(true);

    $videoInfo = new VideoInfoSection($con, $video, $userLoggedInObj); // passing video object and userloggedInObj object
    echo $videoInfo->create();

    $commentSection = new CommentSection($con, $video, $userLoggedInObj);
    echo $commentSection->create();
?>

</div>

<div class="suggestions">
    <?php
        $videoGrid = new VideoGrid($con, $userLoggedInObj);
        echo $videoGrid->create(null, null, false);

    ?>
</div>


<?php require_once("includes/footer.php"); ?>
