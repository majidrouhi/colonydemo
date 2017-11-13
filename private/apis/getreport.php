<?php
if (!User::authorize()) {
    die();
}

$userId = Token::parse(
    Common::getheaders()['Authorization']
)['userId'];

$answer = new Answer();

$result = $answer -> get($userId);

if ($result) {
    http_response_code(OK);

    echo Common::response($result);
}

die();
