<?php
if (!User::authorize()) {
    die();
}

$answer = new Answer();

$result = $answer -> get(1);

if ($result) {
    http_response_code(OK);

    echo Common::response($result);
}

die();
