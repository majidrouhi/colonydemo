<?php
	if (!User::authorize()) die();

	$user = new User();

	if ($user -> logout($token)) http_response_code(OK);

	die();
?>