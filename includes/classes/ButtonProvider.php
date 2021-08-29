<?php
class ButtonProvider {

    public static function createButton($text, $imageSrc, $action, $class) {

        $image = ($imageSrc == null) ? "" : "<img src='$imageSrc' alt='button image'>";

        // Change action if needed

        return "<button class='$class' onclick='$action'>
                    $image
                    <span class='text'>$text</span>
                </button>";
    }

    public static function createUserProfileButton($con, $username) {
        $userObj = new User($con, $username);
        $profilePic = $userObj->getProfilePic();
        $link = "profile.php?username=$username";

        return "<a href='$link' > 
                    <img src='$profilePic' class='profilePicture' alt='Profile Picture'>
                </a>";
    }


}