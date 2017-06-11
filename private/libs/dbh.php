<?php
	class DBH
	{
		private $host, $port, $username, $password, $charset, $dbName, $dbh;

		public function __construct ($_dbName)
		{
			$this -> host = DB_HOST;
			$this -> port = DB_PORT;
			$this -> username = DB_USERNAME;
			$this -> password = DB_PASSWORD;
			$this -> charset = DB_ChARSET;
			$this -> dbName = $_dbName;
		}

		public function __construct1 ($_host, $_port, $_username, $_password, $_charset, $_dbname)
		{
			$this -> host = $_host;
			$this -> port = $_port;
			$this -> username = $_username;
			$this -> password = $_password;
			$this -> charset = $_charset;
			$this -> dbName = $_dbName;
		}

		public function __destruct ()
		{
			$this -> dbh = null;
		}

		public function connect ()
		{
			try
			{
				$this -> dbh = new pdo('mysql:host=' . $this -> host . ';port=' . $this -> port . ';dbname=' . $this -> dbName . ';charset=' . $this -> charset . ';', $this -> username, $this -> password);

				$this -> dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $ex)
			{
				$this -> dbh = null;

				Maintenance::handleExceptions($ex, ($this -> dbName == DB_LOG) ? FILE : DB);
			}
		}

		public function execute ($_query, $_param = [])
		{
			try
			{
				if (is_null($this -> dbh)) throw new Exception(DB_CONNECTION_MSG);

				$sth = $this -> dbh -> prepare($_query);

				$sth -> execute($_param);

				return $sth;
			}
			catch (PDOException $ex)
			{
				$this -> dbh = null;

				Maintenance::handleExceptions($ex, ($this -> dbName == DB_LOG) ? FILE : DB);
			}
		}
	}
?>