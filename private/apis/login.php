<?php
http_response_code(BAD_REQUEST);

$allowedParams = explode(DELIMITER, LOGIN_PARAMS);

$params = Validation::get($allowedParams);

if (!$params) {
    die();
}

    $params[$allowedParams[0]] = substr($params[$allowedParams[0]], 0, MAX_USERNAME_LENGTH);

    $user = new User();

    $result = $user -> login($params);

if ($result['token']) {
    http_response_code(OK);

    echo Common::response($result);
}

die();
