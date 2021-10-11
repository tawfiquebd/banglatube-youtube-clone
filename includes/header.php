<?php
require_once("includes/config.php");
require_once("includes/classes/ButtonProvider.php");
require_once("includes/classes/User.php");
require_once("includes/classes/Video.php");
require_once("includes/classes/VideoGrid.php");
require_once("includes/classes/VideoGridItem.php");
require_once("includes/classes/SubscriptionsProvider.php");
require_once("includes/classes/NavigationMenuProvider.php");

$usernameLoggedIn = isset($_SESSION['userLoggedIn']) ? $_SESSION['userLoggedIn'] : "";
$userLoggedInObj = new User($con, $usernameLoggedIn);

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
	<script type="text/javascript" src="assets/js/commonAction.js"></script>
	<script type="text/javascript" src="assets/js/userAction.js"></script>

</head>
<body>

	<div id="pageContainer">

		<div id="mastHeadContainer">
			<button class="navShowHide">
				<img src="assets/images/icons/menu.png">
			</button>

			<a class="logoContainer" href="index.php">
				<img src="assets/images/icons/VideoTubeLogo.png" title="logo">
			</a>

			<div class="searchBarContainer">
				<form action="search.php" method="GET">
					<input type="text" class="searchBar" name="term" placeholder="Search...">
					<button class="searchButton">
						<img src="assets/images/icons/search.png" >	
					</button>
				</form>
			</div>

			<div class="rightIcons">
				<a href="upload.php">
					<img class="upload" src="assets/images/icons/upload.png">
				</a>
				<?php echo ButtonProvider::createUserProfileNavigationButton($con, $userLoggedInObj->getUsername()); ?>
			</div>
		</div>

		<div id="sideNavContainer" style="display: none">
			<?php
			    $navigationProvider = new NavigationMenuProvider($con, $userLoggedInObj);
			    echo $navigationProvider->create();
			?>
		</div>

		<div id="mainSectionContainer">
			
			<div id="mainContentContainer">