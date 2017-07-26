<!DOCTYPE html>
<html lang="en-<?php echo $_SESSION['COUNTRY']; ?>" ng-app="colonydemo">
	<head>
		<title><?php echo APPLICATION_TITLE; ?></title>
		<meta charset="<?php echo CHARSET; ?>" />
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="author" content="Mr. Python" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="/css/styles.css" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Reem+Kufi" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<script src="js/angular.min.js"></script>
		<script src="js/main.js"></script>
	</head>
	<body ng-controller="QuestionsCtrl">
		<?php
			$view = new View();

			$view -> show();

			echo PHP_EOL;
		?>
		<div id="footer">&copy; <?php echo date('Y'); ?> Colony App.</div>
	</body>
</html>