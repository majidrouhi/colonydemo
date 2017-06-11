<?php
	interface iDbActionTemplate
	{
		public function _insert ($_params);
		public function _update ($_params, $_whereStr = null);
		public function _select ($_params = ['*'], $_whereStr = null, $_limitStr = null, $_orderbyStr = null);
		public function _delete ($_whereStr = null);
	}

	class DbActionTemplate implements iDbActionTemplate
	{
		protected $dbh, $dbName, $tableName;

		public function __construct ($_dbName, $_tableName)
		{
			$this -> dbName = $_dbName;
			$this -> tableName = $_tableName;
			$this -> dbh = new DBH($this -> dbName);

			$this -> dbh -> connect();
		}

		public function _insert ($_params)
		{
			$params = null;
			$fieldsName = [];

			if (empty($_params) || !is_array($_params)) return false;

			foreach ($_params as $fieldName => $value)
			{
				$params[':' . $fieldName] = $value;
				$fieldsName[] = $fieldName;
			}

			$iQuery = 'INSERT INTO ' . $this -> tableName . '(' . implode(DELIMITER, $fieldsName) . ') VALUES (:' . implode(DELIMITER . ':', $fieldsName) . ');';

			return (bool) $this -> dbh -> execute($iQuery, $params);
		}

		public function _update ($_params, $_whereStr = null)
		{
			$params = null;
			$updateStr = [];

			if (empty($_params) || !is_array($_params)) return false;

			foreach ($_params as $fieldName => $value)
			{
				$params[':' . $fieldName] = $value;
				$updateStr[] = $fieldName . ' = :' . $fieldName;
			}

			$uQuery = 'UPDATE ' . $this -> tableName . ' SET ' . implode(DELIMITER, $updateStr) . (empty($_whereStr) ? null : ' WHERE ' . $_whereStr) . ';';

			return (bool) $this -> dbh -> execute($uQuery, $params);
		}

		public function _select ($_params = ['*'], $_whereStr = null, $_joinStr = null, $_limitStr = null, $_orderbyStr = null)
		{
			if (empty($_params) || !is_array($_params)) $_params = ['*'];
			if ($_whereStr != null) $_joinStr = null;

			$sQuery = 'SELECT ' . implode(DELIMITER, $_params) . ' FROM ' . $this -> tableName . (empty($_whereStr) ? null : ' WHERE ' . $_whereStr) .  (empty($_joinStr) ? null : ' INNER JOIN ' . $_joinStr) . (empty($_limitStr) ? null : ' LIMIT ' . $_limitStr) . (empty($_orderbyStr) ? null : ' ORDER BY ' . $_orderbyStr) . ';';

			return $this -> dbh -> execute($sQuery);
		}

		public function _delete ($_whereStr = null)
		{
			$dQuery = 'DELETE FROM ' . $this -> tableName . (empty($_whereStr) ? null : ' WHERE ' . $_whereStr) . ';';

			return (bool) $this -> dbh -> execute($dQuery);
		}
	}
?>