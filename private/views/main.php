<!DOCTYPE html>
<html lang="en-<?php echo $_SESSION['COUNTRY']; ?>" ng-app="colonydemo">
	<head>
		<meta charset="<?php echo CHARSET; ?>" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="author" content="Mr. Python" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<link rel="stylesheet" href="/css/style.css" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet"> 
		<title><?php echo APPLICATION_TITLE; ?></title>
	</head>
	<body>
			<div>
				<header>
					<img id="logo" src="images/logo.jpg" />
					<h1><?php echo strtoupper(APPLICATION_TITLE); ?></h1>
				</header>
					<main>
						<?php
							$view = new View();

							$view -> show();

							echo PHP_EOL;
						?>
					</main>
			</div>
			<footer>
				<p>&copy; <?php echo date('Y') . ' ' . strtoupper($_SERVER['SERVER_NAME']); ?></p>
			</footer>
			<script type="text/javascript" src="js/angular.min.js"></script>
			<script type="text/javascript" src="js/main.js"></script>
	</body>
</html>