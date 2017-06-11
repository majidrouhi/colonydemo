<?php
	class Log
	{
		private $log;

		public function error ($_file, $_function, $_line, $_exception, $_mode = DB)
		{
			$trace = self::parseErrorTrace($_exception);

			if ($_mode == FILE) self::insertToFile($_file, $_function, $_line, $_exception -> getmessage(), EXCEPTION, $trace);
			else if ($_mode == DB)
			{
				$this -> log = new TblLogs();
				$this -> log -> insert($_file, $_function, $_line, $_exception -> getmessage(), $trace, EXCEPTION);
			}
		}

		public function action ($_file, $_function, $_line, $_message = null, $_mode = DB)
		{
			if ($_mode == FILE) self::insertToFile($_file, $_function, $_line, $_message, INFORMATION);
			else if ($_mode == DB)
			{
				$this -> log = new TblLogs();
				$this -> log -> insert($_file, $_function, $_line, $_message, null, INFORMATION);
			}
		}

		private static function parseErrorTrace ($_ex)
		{
			$trace = [];

			if (!method_exists($_ex, 'gettrace')) return null;

			$exTrace = array_reverse($_ex -> gettrace());

			foreach ($exTrace as $key => $err) $trace[] = '[' . $key . '] ' . $err['file'] . ' (' . $err['function'] . ':' . $err['line'] . ')';

			return implode(DELIMITER, $trace);
		}

		private static function insertToFile ($_file, $_function, $_line, $_message, $_type, $_trace = null)
		{
			error_log(
				'Date Time: ' . NOW . PHP_EOL .
				'Source: ' . $_file . ' (' . $_function . ':' . $_line . ')' . PHP_EOL .
				'IP: ' . $_SESSION['IP_ADDRESS'] . PHP_EOL .
				'URL: ' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . PHP_EOL .
				'User Agent: ' . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL .
				'OS: ' . $_SESSION['PLATFORM'] . ' (' . $_SESSION['DEVICE_TYPE'] . ')' . PHP_EOL .
				'Browser: ' . $_SESSION['BROWSER'] . PHP_EOL .
				'Message: ' . Validation::sanitizeValue($_message) . PHP_EOL .
				'Trace: ' . Validation::sanitizeValue($_trace) . PHP_EOL .
				'Type: ' . $_type . PHP_EOL .
				'---------------------------------------' . PHP_EOL, 3, ($_type == EXCEPTION) ? E_LOG_FILE : A_LOG_FILE);
		}
	}
?>