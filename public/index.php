<?php
require_once '../private/initialize.php';

try {
    $view = new View();

    $view -> show(MAIN_VIEW);
} catch (Exception $ex) {
    Maintenance::handleExceptions($ex);
}
