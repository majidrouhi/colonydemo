<?php
    // Status
    define('DISABLE', 0);
    define('ENABLE', 1);

    define('OK', 200);
    define('BAD_REQUEST', 400);
    define('UNAUTHORIZED', 401);
    define('NOT_FOUND', 404);
    define('CONFLICT', 409);
    define('SERVICE_UNAVAILABLE', 503);
    define('SERVER_ERROR', 500);

    define('DENIED', 0);
    define('CONFIRMED', 1);
    define('WAITING', 2);

    define('NOT_SENT', 0);
    define('SENT', 1);

    // Log Types
    define('EXCEPTION', 0);
    define('INFORMATION', 1);

    // Roles
    define('ADMIN', 0);
    define('USER', 1);

    // Log Locations
    define('DB', 0);
    define('FILE', 1);

    // Languages Code
    define('FA_LANG', 0);
    define('EN_LANG', 1);

    // Application Settings
    define('MAX_ID_LENGTH', 11);
    define('MAX_FIRST_NAME_LENGTH', 128);
    define('MAX_LAST_NAME_LENGTH', 128);
    define('MAX_USERNAME_LENGTH', 128);
    define('MAX_PASSWORD_LENGTH', 128);
    define('MAX_TOKEN_LENGTH', 149);
    define('MIN_TOKEN_LENGTH', 139);
    define('CSRF_TOKEN_LENGTH', 32);
    define('RESULT_COUNT_PER_REQUEST', 6);
    define('NOW', date('Y/m/d H:i:s'));
    define('EMAIL_VALIDATOR', '/^[\w\.\-]{1,64}\@[\w\.\-]{1,184}\.[a-zA-Z0-9]{1,4}$/');
    define('DELIMITER', ',');
    define('APPLICATION_TITLE', 'ColonyApp - Beta 2');
    define('TOKEN_SECRET', '4c061e6c9a7b16015e0847a12f41c835');
    define('LOGIN_TIMEOUT', 1800);
    define('API_PREFIX', '_API');
    define('VIEW_PREFIX', '_VIEW');
    define('CHARSET', 'UTF-8');
    define('TIME_ZONE', 'Asia/Tehran');
    define('MAINTENANCE_MODE', true);
    define('LOG_ERRORS', false);
    define('LOG_ACTIONS', false);
    define('VALID_IP_ADDRESS', '127.0.0.1,::1');

    // Paths
    define('APP_ROOT_PATH', dirname(dirname(__dir__)) . '/');
    define('PRIVATE_PATH', APP_ROOT_PATH . 'private/');
    define('PUBLIC_PATH', APP_ROOT_PATH . 'public/');
    define('APIS_PATH', PRIVATE_PATH . 'apis/');
    define('CLS_PATH', PRIVATE_PATH . 'class/');
    define('CONTROLLERS_PATH', PRIVATE_PATH . 'controllers/');
    define('MODELS_PATH', PRIVATE_PATH . 'models/');
    define('VIEWS_PATH', PRIVATE_PATH . 'views/');
    define('UPLOADED_IMAGES_PATH', APP_ROOT_PATH . 'uploads/images/');

    // Log Files
    define('E_LOG_FILE', APP_ROOT_PATH . 'e_log.log');
    define('A_LOG_FILE', APP_ROOT_PATH . 'a_log.log');

    // Views
    define('MAIN_VIEW', VIEWS_PATH . 'main.php');
    define('ENTER_VIEW', VIEWS_PATH . 'enter.php');
    define('MAINTENANCE_VIEW', VIEWS_PATH . 'maintenance.php');

    // Registered APIs
    define('GETQ_API', APIS_PATH . 'getq.php');
    define('LOGIN_API', APIS_PATH . 'login.php');
    define('LOGOUT_API', APIS_PATH . 'logout.php');
    define('REGISTER_API', APIS_PATH . 'register.php');
    define('SETANSWER_API', APIS_PATH . 'setanswer.php');
    define('GETREPORT_API', APIS_PATH . 'getreport.php');
    define('GETSIMPATICO_API', APIS_PATH . 'getsimpatico.php');

    // Allowed Parameters
    define('API_PARAMS', 'api');
    define('LOGIN_PARAMS', 'username');
    define('REGISTER_PARAMS', 'name');
    define('SETANSWER_PARAMS', 'questionId,answer');
    define('VIEW_PARAMS', 'view');

    // Messages
    define('DB_CONNECTION_MSG', 'Database Connection Error');
    define('MODULE_MSG', 'File Not Found');
    define('API_MSG', 'API Not Found');
    define('API_PARAMETERS_MSG', 'Wrong API Parameters');
    define('PERMISSION_MSG', 'Permission Denied');
    define('REQUEST_MSG', 'Error Processing Request');
    define('SERVER_ERROR_MSG', 'Server Error');
    define('INVALID_IP_MSG', 'Invalid IP Address');
    define('BLANK_FIELD_MSG', 'Can\'t Be Blank');
    define('NO_RESULT_MSG', 'No Result Found');
    define('REQUEST_SUCCESSFULL_MSG', 'Request Successfully Finished');
    define('MAINTENANCE_MSG', 'Temporarily Unavailable.');
    define('OBJECT_ERROR_MSG', 'Object Not Set');
    define('INVALID_TOKEN_ERROR', 'Invalid Token');
    define('ORIGIN_ERROR', 'Origin Not Match');
    define('TOKEN_EXPIRATION_ERROR', 'Token Expired');

    // Database Identities
    define('DB_HOST', 'localhost');
    define('DB_PORT', 3306);
    define('DB_USERNAME', 'colony_user');
    define('DB_PASSWORD', 'colony_pass');
    define('DB_CHARSET', 'utf8');

    // Databases
    define('DB_DATA', 'colony_demo');
    define('DB_LOG', 'log');

    // Tables
    define('TBL_LOGS', 'logs');
    define('TBL_QUESTIONS', 'questions');
    define('TBL_USERS', 'users');
    define('TBL_ANSWERS', 'answers');
