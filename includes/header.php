<!DOCTYPE html>
<html>
<head>
	<title>VideoTube</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<!-- JavaScript Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	<script type="text/javascript" src="assets/js/commonAction.js"></script>

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

				<a href="#">
					<img class="upload" src="assets/images/profilePictures/default.png">
				</a>
			</div>
		</div>

		<div id="sideNavContainer" style="display: none">
			
		</div>

		<div id="mainSectionContainer">
			
			<div id="mainContentContainer">