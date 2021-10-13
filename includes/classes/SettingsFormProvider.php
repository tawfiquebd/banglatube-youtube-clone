<?php
class SettingsFormProvider {

    public function createUserDetailsForm(){
        $firstNameInput = $this->createFirstNameInput(null);
        $lastNameInput = $this->createLastNameInput(null);
        $emailInput = $this->createEmailInput(null);
        $saveButton = $this->createSaveUserDetailsButton();

        return "<form action='processing.php' method='POST' enctype='multipart/form-data'>
					$firstNameInput
					$lastNameInput 
					$emailInput
					$saveButton
				</form>";
    }

    private function createFirstNameInput($value){
        if($value == null) $value = "";
        return "<div class='form-group'>
				    <input type='text' class='form-control' placeholder='First name' value='$value' name='firstName' required>
				</div>";
    }

    private function createLastNameInput($value){
        if($value == null) $value = "";
        return "<div class='form-group'>
				    <input type='text' class='form-control' placeholder='Last name' value='$value' name='lastName' required>
				</div>";
    }

    private function createEmailInput($value){
        if($value == null) $value = "";
        return "<div class='form-group'>
				    <input type='email' class='form-control' placeholder='Email' value='$value' name='email' required>
				</div>";
    }

    public function createSaveUserDetailsButton(){
        return "<button type='submit' class='btn btn-primary' name='saveDetailsButton'>Save</button>";
    }

}

?>