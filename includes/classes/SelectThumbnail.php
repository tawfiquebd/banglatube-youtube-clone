<?php
class SelectThumbnail {

    private $con, $video;

    public function __construct($con, $video) {
        $this->con = $con;
        $this->video = $video;
    }

    public function create() {
        $thumbnailData = $this->getThumbnailData();

        $html = "";

        foreach($thumbnailData as $data) {
            $html .= $this->createThumbnailItem($data);
        }

        return "<div class='thumbnailItemsContainer'>
                    $html
                </div>";
    }

    private function createThumbnailItem($data) {
        $id = $data["id"];
        $url = $data["filePath"];
        $videoId = $data["video_id"];
        $selected = $data["selected"] == 1 ? "selected" : "";

        return "<div class='thumbnailItem $selected' onclick='setNewThumbnail($id, $videoId, this)'> 
                    <img src='$url'/>
                </div>";
    }

    private function getThumbnailData() {
        $data = array();
        $videoId = $this->video->getId();

        $query = $this->con->prepare("SELECT * FROM thumbnails WHERE video_id = :video_id ");
        $query->bindParam(":video_id", $videoId);
        $query->execute();

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] =$row;
        }

        return $data;
    }

}