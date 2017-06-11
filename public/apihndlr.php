<?php
	require_once '../private/initialize.php';

	http_response_code(BAD_REQUEST);

	try
	{
		Maintenance::checkIP();

		$allowedParams = explode(DELIMITER, API_PARAMS);

		$params = Validation::get($allowedParams);

		if (!$params) die();

		$api = constant(strtoupper($params[$allowedParams[0]]) . API_PREFIX);

		if (!@include_once $api) throw new Exception(API_MSG . ' (' . $api . ')');
	}
	catch (Exception $ex)
	{
		Maintenance::handleExceptions($ex);
	}
?>