<?php
class SettingsFormProvider {

    public function createUserDetailsForm($firstName, $secondName, $email){
        $firstNameInput = $this->createFirstNameInput($firstName);
        $lastNameInput = $this->createLastNameInput($secondName);
        $emailInput = $this->createEmailInput($email);
        $saveButton = $this->createSaveUserDetailsButton();

        return "<form action='settings.php' method='POST' enctype='multipart/form-data'>
                    <span class='title'>User details</span>
					$firstNameInput
					$lastNameInput 
					$emailInput
					$saveButton
				</form>";
    }

    public function createPasswordForm(){
        $oldPasswordInput  = $this->createPasswordInput("oldPassword", "Old password");
        $newPassword1Input = $this->createPasswordInput("newPassword", "New password");
        $newPassword2Input = $this->createPasswordInput("newPassword2", "Confirm new password");
        $saveButton        = $this->createSavePasswordButton();

        return "<form action='settings.php' method='POST' enctype='multipart/form-data'>
                    <span class='title'>Update password</span>
					$oldPasswordInput
					$newPassword1Input 
					$newPassword2Input
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

    private function createPasswordInput($name, $placeholder){
        return "<div class='form-group'>
				    <input type='password' class='form-control' placeholder='$placeholder' name='$name' required>
				</div>";
    }

    public function createSavePasswordButton(){
        return "<button type='submit' class='btn btn-primary' name='savePasswordButton'>Save</button>";
    }

}

?>