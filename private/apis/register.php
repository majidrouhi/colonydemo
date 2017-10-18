<?php
http_response_code(BAD_REQUEST);

$allowedParams = explode(DELIMITER, REGISTER_PARAMS);
$params = Validation::get($allowedParams);

if (!$params) {
    die();
}

$params[$allowedParams[0]] = substr($params[$allowedParams[0]], 0, MAX_FIRST_NAME_LENGTH);

$user = new User();

$result = $user -> register($params);

if ($result) {
    http_response_code(OK);
} else {
    http_response_code(CONFLICT);
}

die();
