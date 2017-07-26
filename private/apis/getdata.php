<?php
	http_response_code(BAD_REQUEST);

	$answer = new Answer();

	$result = $answer -> get();

	if ($result)
	{
		http_response_code(OK);

		echo Common::response($result);
	}

	die();
?>