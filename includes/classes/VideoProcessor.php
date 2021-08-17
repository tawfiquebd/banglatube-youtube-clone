<?php
class VideoProcessor{

    private $con;
    private $sizeLimit = 500000000; // bytes
    private $allowedTypes = array("mp4", "flv", "webm", "mkv", "vob", "ogv", "ogg", "avi", "wmv", "mov", "mpeg", "mpg" );
    private $ffmpegPath;
    private $ffprobePath;

    public function __construct($con){
        $this->con = $con;
        $this->ffmpegPath = "\"ffmpeg\\bin\\ffmpeg.exe\"";
        $this->ffprobePath = "\"ffmpeg\\bin\\ffprobe.exe\"";
    }

    public function upload($videoUploadData){
        $targetDir = "uploads/videos/";
        $videoData = $videoUploadData->videoDataArray;

        $tempFilePath = $targetDir . uniqid() . basename($videoData['name']);
        $tempFilePath = str_replace(" ","_",$tempFilePath);

        $isValidData = $this->processData($videoData, $tempFilePath);

        if(!$isValidData){
            return false;
        }
        if(move_uploaded_file($videoData["tmp_name"], $tempFilePath)){

            $finalFilePath = $targetDir . uniqid() . ".mp4";
            if(!$this->insertVideoData($videoUploadData, $finalFilePath)){
                echo "Insert query failed";
                return false;
            }

            if(!$this->convertVideoToMp4($tempFilePath, $finalFilePath)){
                echo "Converting failed!";
                return false;
            }

            if(!$this->deleteFile($tempFilePath)){
                echo "Delete failed!";
                return false;
            }

            if(!$this->generateThumbnails($finalFilePath)){
                echo "Upload failed - Couldn't generate thumbnails\n";
                return false;
            }

        }
    }

    public function processData($videoData, $filePath){
        $videoType = pathinfo($filePath, PATHINFO_EXTENSION); // built in function

        if(!$this->isValidSize($videoData)){
            echo "File too large. Can't be more than ".$this->sizeLimit ." bytes";
            return false;
        }
        else if(!$this->isValidType($videoType)){
            echo "Invalid file type";
            return false;
        }
        else if($this->hasError($videoData)){
            echo "Error code: " .$videoData["error"];
            return false;
        }
        return true;
    }

    public function isValidSize($data){
        return $data["size"] <= $this->sizeLimit;
    }

    private function isValidType($type){
        $lowercased = strtolower($type);
        return in_array($lowercased, $this->allowedTypes);
    }

    private function hasError($data){
        return $data["error"] != 0;
    }

    private function insertVideoData($uploadData, $filePath){
        $query = $this->con->prepare("INSERT INTO videos(title, uploadedBy, description, privacy, category, filePath)
                                    VALUES(:title, :uploadedBy, :description, :privacy, :category, :filePath)");
        $query->bindParam(":title", $uploadData->title);
        $query->bindParam(":uploadedBy", $uploadData->uploadedBy);
        $query->bindParam(":description", $uploadData->description);
        $query->bindParam(":privacy", $uploadData->privacy);
        $query->bindParam(":category", $uploadData->category);
        $query->bindParam(":filePath", $filePath);

        return $query->execute();
    }

    public function convertVideoToMp4($tempFilePath, $finalFilePath){
        // ffmpeg directory in project
        $cmd = "$this->ffmpegPath";
        $outputLog = array();
        exec(escapeshellcmd($cmd) . " -i $tempFilePath -c copy $finalFilePath 2>&1", $outputLog, $returnCode);
        if($returnCode != 0){
            // command failed
            foreach($outputLog as $line){
                echo $line ."<br/>";
            }
            return false;
        }
        return true;
    }

    private function deleteFile($tempFilePath){
        if(!unlink($tempFilePath)){
            echo "Could not delete file <br />";
            return false;
        }

        return true;
    }

    public function generateThumbnails($filePath){
        $thumbnailSize = "210x118";
        $numThumbnails = 3;
        $pathToThumbnail = "uploads/videos/thumbnails";
        $duration = $this->getVideoDuration($filePath);

        echo "Duration: $duration";
    }

    private function getVideoDuration($filePath){
        return shell_exec("$this->ffprobePath -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 {$filePath}");
    }

}
?>
