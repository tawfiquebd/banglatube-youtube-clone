<?php
require_once("includes/config.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/FormSanitizer.php");

$account = new Account($con);

if(isset($_POST['submitButton'])){

    $username = FormSanitizer::sanitizeFormUsername($_POST['username']);
    $password = FormSanitizer::sanitizeFormPassword($_POST['password']);

    $wasSuccessful = $account->login($username, $password);

    if ($wasSuccessful) {
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
    }

}


function getInputValue($name) {
    if(isset($_POST[$name])) {
        echo $_POST[$name];
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>VideoTube</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>

</head>
<body>

    <div class="signInContainer">
        <div class="column">
            <div class="header">
                <img src="assets/images/icons/VideoTubeLogo.png" title="logo">
                <h3>Sign In</h3>
                <span>to continue to VideoTube</span>
            </div>

            <div class="loginForm">
                <form action="signin.php" method="POST">
                    <?php echo $account->getError(Constants::$loginFailed); ?>
                    <input type="text" name="username" placeholder="Username" value="<?php getInputValue('username'); ?>" required autocomplete="off">
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" name="submitButton" value="SUBMIT">

                </form>
            </div>

            <a class="signInMessage" href="signup.php">Need an account? Sign up here!</a>
        </div>
    </div>

</body>
</html>
