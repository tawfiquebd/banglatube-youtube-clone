<?php
class Video {

    private $con, $sqlData, $userLoggedInObj;

    public function __construct($con, $input, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        if(is_array($input)) {
            // if this is sql data
            $this->sqlData = $input;
        }
        else{
            // if this is video id
            $query = $this->con->prepare("SELECT * FROM videos WHERE id = :id");
            $query->bindParam(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }

    }

    public function getUsername() {
        return $this->sqlData["username"];
    }

    public function getId() {
        return $this->sqlData["id"];
    }

    public function getUploadedBy() {
        return $this->sqlData["uploadedBy"];
    }

    public function getTitle() {
        return $this->sqlData["title"];
    }

    public function getDescription() {
        return $this->sqlData["description"];
    }

    public function getPrivacy() {
        return $this->sqlData["privacy"];
    }

    public function getFilePath() {
        return $this->sqlData["filePath"];
    }

    public function getCategory() {
        return $this->sqlData["category"];
    }

    public function getUploadDate() {
        return $this->sqlData["uploadDate"];
    }

    public function getViews() {
        return $this->sqlData["views"];
    }

    public function getDuration() {
        return $this->sqlData["duration"];
    }

    public function incrementViews() {
        $videoId = $this->getId();
        $query = $this->con->prepare("UPDATE videos SET views = views+1 WHERE id = :id");
        $query->bindParam(":id",$videoId);
        $query->execute();

        $this->sqlData["views"] = $this->sqlData["views"] + 1;
    }

    public function getLikes() {
        $videoId = $this->getId();
        $query = $this->con->prepare("SELECT count(*) as count FROM likes WHERE video_id = :video_id");
        $query->bindParam(":video_id", $videoId);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data['count'];

    }

    public function getDislikes() {
        $videoId = $this->getId();
        $query = $this->con->prepare("SELECT count(*) as count FROM dislikes WHERE video_id = :video_id");
        $query->bindParam(":video_id", $videoId);
        $query->execute();

        $data = $query->fetch(PDO::FETCH_ASSOC);
        return $data['count'];

    }

    public function like() {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        if($this->wasLikedBy()){
            // If user has already liked it, then remove the like
            $query = $this->con->prepare("DELETE FROM likes WHERE username = :username AND video_id = :video_id");
            $query->bindParam(":username", $username);
            $query->bindParam(":video_id", $id);

            $query->execute();

            $result = array(
                "likes" => -1,
                "dislikes" => 0
            );
            return json_encode($result);
        }
        else{
            // If user had already disliked then remove it
            $query = $this->con->prepare("DELETE FROM dislikes WHERE username = :username AND video_id = :video_id");
            $query->bindParam(":username", $username);
            $query->bindParam(":video_id", $id);

            $query->execute();
            $count = $query->rowCount();

            // If there is not like then Insert like
            $query = $this->con->prepare("INSERT INTO likes(username, video_id) VALUES(:username, :video_id) ");
            $query->bindParam(":username", $username);
            $query->bindParam(":video_id", $id);

            $query->execute();

            $result = array(
                "likes" => 1,
                "dislikes" => 0 - $count
            );
            return json_encode($result);
        }
    }

    public function wasLikedBy() {
        $id = $this->getId();
        $username = $this->userLoggedInObj->getUsername();

        $query = $this->con->prepare("SELECT * FROM likes WHERE username = :username AND video_id = :video_id");
        $query->bindParam(":username", $username);
        $query->bindParam(":video_id", $id);

        $query->execute();

        return $query->rowCount() > 0;
    }


}