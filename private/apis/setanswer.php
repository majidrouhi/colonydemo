<?php
if (!User::authorize()) {
    die();
}

$allowedParams = explode(DELIMITER, SETANSWER_PARAMS);

$params = Validation::get($allowedParams);

if (!$params) {
    die();
}

$params[$allowedParams[1]] = Validation::isNumber(
    $params[$allowedParams[1]],
    ['min' => 0, 'max' => MAX_ID_LENGTH]) ?
    $params[$allowedParams[1]] : die();
$params[$allowedParams[1]] = substr($params[$allowedParams[1]], 0, MAX_ID_LENGTH);

$answer = new Answer();

$result = $answer -> set($params);

if ($result) {
    http_response_code(OK);
}

die();
