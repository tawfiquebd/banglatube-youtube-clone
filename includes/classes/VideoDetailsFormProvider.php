<?php
class VideoDetailsFormProvider{

	public function createUploadForm(){
		$fileInput = $this->createFileInput();
		$titleInput = $this->createTitleInput();
		$descriptionInput = $this->createDescriptionInput();
		$privacyInput = $this->createPrivacyInput();

		return "<form action='processing.php' method='POST'>
					$fileInput
					$titleInput 
					$descriptionInput
					$privacyInput
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


}

?>