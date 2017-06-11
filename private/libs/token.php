<?php
	class Token
	{
		private $user;

		public static function verify ($_token)
		{
			$token = self::parse($_token);

			if (!$token) return false; //throw new Exception(OBJECT_ERROR_MSG)

			$user = new TblUsers();
			$userData = $user -> get($token['userId'])[0];

			try
			{
				if (!isset($userData['token']) || $userData['token'] != $_token) return false; //throw new Exception(INVALID_TOKEN_ERROR);
				if ($token['origin'] != hash('sha256', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . TOKEN_SECRET)) return false; //throw new Exception(ORIGIN_ERROR);
				if ($token['expiration'] != null && time() > $token['expiration']) return false; //throw new Exception(TOKEN_EXPIRATION_ERROR);

				return true;
			}
			catch (Exception $ex)
			{
				Maintenance::handleExceptions($ex);
			}
		}

		public static function generate ($_userId, $_expiration = null)
		{
			$salt = hash('sha256', Common::randomString(LOGIN_TOKEN_LENGTH));
			$origin = hash('sha256', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . TOKEN_SECRET);

			if ($_expiration != null) $_expiration = time() + $_expiration;

			$zeros = 9 - strlen($_userId);
			$token = $salt . $_expiration . $origin . $_userId . $zeros;

			return $token;
		}

		public static function parse ($_token)
		{
			if (!Validation::checkLength($_token, ['min' => MIN_TOKEN_LENGTH, 'max' => MAX_TOKEN_LENGTH])) return null;

			$zeros = substr($_token, strlen($_token) - 1, 1);
			$userIdLen = 9 - $zeros;
			$userId = substr($_token, strlen($_token) - $userIdLen - 1, $userIdLen);
			$origin = null;
			$expiration = null;

			if (strlen($_token) > 129 + $userIdLen) $origin = substr($_token, strlen($_token) - $userIdLen - 65, 64);
			else if (strlen($_token) > 139 + $userIdLen)
			{
				$origin = substr($_token, strlen($_token) - 74, 64);
				$expiration = substr($_token, strlen($_token) - $userIdLen - 75);
			}

			return ['userId' => $userId, 'origin' => $origin, 'expiration' => $expiration];
		}
	}
?>