<?php
	require_once dirname(__dir__) . '/private/configs/appconfigs.php';
	require_once dirname(__dir__) . '/private/configs/phpconfigs.php';

	if (MAINTENANCE_MODE && in_array($_SERVER['REMOTE_ADDR'], explode(DELIMITER, VALID_IP_ADDRESS)))
	{
		ini_set('display_errors', ENABLE);
		ini_set('display_startup_errors', ENABLE);
		ini_set('log_errors', DISABLE);
	}

	set_include_path(implode(PATH_SEPARATOR, array(LIBS_PATH, CONTROLLERS_PATH, MODELS_PATH)));
	spl_autoload_register();

	Session::set();
?>