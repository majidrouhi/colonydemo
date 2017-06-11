<?php
	class CSRF
	{
		public static function verify ($_key, $_origin, $_timespan = null)
		{
			try
			{
				if (!isset($_SESSION['CSRF_' . $_key]) || !isset($_origin[$_key])) return false; //throw new Exception(OBJECT_ERROR_MSG);

				$hash = $_SESSION['CSRF_' . $_key];

				unset($_SESSION['CSRF_' . $_key]);

				if (hash('sha256', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']) != substr(base64_decode($hash), 10, 40)) return false; //throw new Exception(INVALID_TOKEN_ERROR);
				if ($_origin[$_key] != $hash) return false; //throw new Exception(ORIGIN_ERROR);
				if ($_timespan != null && is_int($_timespan) && intval(substr(base64_decode($hash), 0, 10)) + $_timespan < time()) return false; //throw new Exception(TOKEN_EXPIRATION_ERROR);

				return true;
			}
			catch (Exception $ex)
			{
				Maintenance::handleExceptions($ex);
			}
		}

		public static function generate ($_key)
		{
			$extra = hash('sha256', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
			$token = base64_encode(time() . $extra . Common::randomString(CSRF_TOKEN_LENGTH));
			$_SESSION['CSRF_' . $_key] = $token;

			return $token;
		}
	}
?>