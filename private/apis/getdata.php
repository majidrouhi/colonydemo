<?php
	$answer = new Answer();

	$result = $answer -> getAll();

	if ($result)
	{
		http_response_code(OK);

		echo Common::response($result);
	}

	die();
?>