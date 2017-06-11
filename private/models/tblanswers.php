<?php
	final class TblAnswers extends DbActionTemplate
	{
		private $id;

		public function __construct ()
		{
			parent::__construct(DB_DATA, TBL_ANSWERS);
		}

		public function insert ($_userId, $_questionId, $_answer, $_point)
		{
			return parent::_insert([
				'user_id' => $_userId,
				'question_id' => $_questionId,
				'answer' => $_answer,
				'point' => $_point]);
		}

		public function getAll($_fields = ['*'])
		{
			$join = 'users ON users.id = answers.user_id';
			$result = parent::_select($_fields, null, $join);

			while ($row = $result -> fetch(PDO::FETCH_ASSOC)) $fetchedResult[] = $row;

			return $fetchedResult;
		}

		public function getByUser ($_userId = null)
		{
			$where = null;
			$fetchedResult = [];

			if ($_userId != null) $where = Validation::isNumber($_userId) ? 'user_id = ' . $_userId : null;

			$result = parent::_select(['*'], $where);

			while ($row = $result -> fetch(PDO::FETCH_ASSOC)) $fetchedResult[] = $row;

			return $fetchedResult;
		}

		public function getByQuestion ($_questionId = null)
		{
			$where = null;
			$fetchedResult = [];

			if ($_questionId != null) $where = Validation::isNumber($_questionId) ? 'question_id = ' . $_questionId : null;

			$result = parent::_select(['*'], $where);

			while ($row = $result -> fetch(PDO::FETCH_ASSOC)) $fetchedResult[] = $row;

			return $fetchedResult;
		}
	}
?>