<?php
class VideoDetailsFormProvider{

    private $con;

    public function __construct($con){
        $this->con = $con;
    }

	public function createUploadForm(){
		$fileInput = $this->createFileInput();
		$titleInput = $this->createTitleInput();
		$descriptionInput = $this->createDescriptionInput();
		$privacyInput = $this->createPrivacyInput();
		$categoriesInput = $this->createCategoriesInput();
		$uploadButton = $this->createUploadButton();

		return "<form action='processing.php' method='POST'>
					$fileInput
					$titleInput 
					$descriptionInput
					$privacyInput
					$categoriesInput
					$uploadButton
				</form>";
	}

	private function createFileInput(){
		return "<div class='form-group'>
				<label for='fileInput'>Your file</label><br />
			    <input type='file' class='form-control-file' id='fileInput' name='fileInput' required>
			  </div>";
	}

	private function createTitleInput(){
		return "<div class='form-group'>
				<input type='email' class='form-control' placeholder='Title' name='titleInput'>
				</div>";
	}

	private function createDescriptionInput(){
		return "<div class='form-group'>
				<textarea class='form-control' rows='3' placeholder='Description' name='descriptionInput' ></textarea>
				</div>";
	}

	private function createPrivacyInput(){
		return "<div class='form-group'>
					<select class='form-control' name='privacyInput'>
				  		<option value='0'>Private</option>
				  		<option value='1'>Public</option>
					</select>
				</div>";
	}

	public function createCategoriesInput(){
        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();
        $html = "<div class='form-group'>
					<select class='form-control' name='privacyInput'>";
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $id = $row['id'];
            $name = $row['name'];

            $html .= "<option value='$id'>$name</option>";
        }
        $html .=    "</select>
                </div>";

        return $html;
    }

    public function createUploadButton(){
        return "<button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button>";
    }

}

?>