<?php
	class Validation
	{
		public static function get ($_params = [], $_sanitize = true)
		{
			$allowedParams = [];

			foreach ($_params as $param) if (isset($_GET[$param]))
			{
				if ($_sanitize) $allowedParams[$param] = self::sanitizeValue($_GET[$param]);
				else $allowedParams[$param] = $_GET[$param];
			}
			else return null;

			return $allowedParams;
		}

		public static function post ($_params = [], $_sanitize = true)
		{
			$allowedParams = [];

			foreach ($_params as $param) if (isset($_POST[$param]))
			{
				if ($_sanitize) $allowedParams[$param] = self::sanitizeValue($_POST[$param]);
				else $allowedParams[$param] = $_POST[$param];
			}
			else return null;

			return $allowedParams;
		}

		public static function header ($_params = [], $_sanitize = true)
		{
			$allowedParams = [];
			$headers = getallheaders();

			foreach ($_params as $param) if (isset($headers[$param]))
			{
				if ($_sanitize) $allowedParams[$param] = self::sanitizeValue($headers[$param]);
				else $allowedParams[$param] = $headers[$param];
			}
			else return null;

			return $allowedParams;
		}

		public static function checkLength ($_value, $_options = [])
		{
			if (isset($_options['max']) && (strlen($_value) > (int) $_options['max'])) return false;
			if (isset($_options['min']) && (strlen($_value) < (int) $_options['min'])) return false;
			if (isset($_options['exact']) && (strlen($_value) != (int) $_options['exact'])) return false;

			return true;
		}

		public static function checkFormatting ($_value, $_regex = '//', $_sanitize = true)
		{
			if ($_sanitize) return (bool) preg_match($_regex, self::sanitizeValue($_value));
			else return (bool) preg_match($_regex, $_value);
		}

		public static function isEmail ($_value)
		{
			return (bool) self::checkFormatting($_value, EMAIL_VALIDATOR, false);
		}

		public static function isNumber ($_value, $_options = [])
		{
			if (!is_numeric($_value)) return false;
			if (isset($_options['max']) && ($_value > (int) $_options['max'])) return false;
			if (isset($_options['min']) && ($_value < (int) $_options['min'])) return false;

			return true;
		}

		public static function sanitizeValue ($_value, $_stripSlashes = false)
		{
			$sanitizedValue = strip_tags(htmlspecialchars(trim($_value)));

			if ($_stripSlashes) return stripcslashes($sanitizedValue);
			else return $sanitizedValue;
		}
	}
?>
