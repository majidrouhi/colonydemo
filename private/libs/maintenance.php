<?php
	class Maintenance
	{
		public static function handleExceptions ($_exception, $_logLocation = DB)
		{
			http_response_code(SERVER_ERROR);

			if (!MAINTENANCE_MODE || (MAINTENANCE_MODE && LOG_ERRORS))
			{
				$log = new Log();

				$log -> error(__file__, __function__, __line__, $_exception, $_logLocation);
			}

			if (!MAINTENANCE_MODE) unset($_exception);

			die($_exception);
		}

		public static function checkIP ()
		{
			if (MAINTENANCE_MODE && !in_array($_SESSION['IP_ADDRESS'], explode(DELIMITER, VALID_IP_ADDRESS)))
			{
				http_response_code(SERVICE_UNAVAILABLE);

				die('Your IP: ' . $_SESSION['IP_ADDRESS']);
			}
		}

		public static function getViewOutput ($_view)
		{
			if (MAINTENANCE_MODE && !in_array($_SESSION['IP_ADDRESS'], explode(DELIMITER, VALID_IP_ADDRESS)))
			{
				http_response_code(SERVICE_UNAVAILABLE);

				return MAINTENANCE_VIEW;
			}
			else
			{
				http_response_code(OK);

				return $_view;
			}
		}
	}
