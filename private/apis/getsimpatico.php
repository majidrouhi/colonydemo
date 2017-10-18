<?php
if (!User::authorize()) {
    die();
}

$answer = new Answer();

$result = $answer -> getSimpatico();

if ($result) {
    http_response_code(OK);

    echo Common::response($result);
}

die();
