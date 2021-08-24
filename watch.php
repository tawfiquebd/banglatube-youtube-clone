<?php
require_once("includes/header.php");
require_once("includes/classes/VideoPlayer.php");

if(!isset($_GET["id"])) {
    echo "No url passed into page";
    exit();
}

$video = new Video($con, $_GET['id'], $userLoggedInObj);    // video object creating

?>

<div class="watchLeftColumn">

<?php
    $videoPlayer = new VideoPlayer($video); // passing video object
    echo $videoPlayer->create(true);
?>

</div>


<?php require_once("includes/footer.php"); ?>
