<?php
	final class TblAnswers extends DbActionTemplate
	{
		private $id;

		public function __construct ()
		{
			parent::__construct(DB_DATA, TBL_ANSWERS);
		}

		public function insert ($_userId, $_questionId, $_answer)
		{
			return parent::_insert([
				'user_id' => $_userId,
				'question_id' => $_questionId,
				'answer' => $_answer]);
		}

		public function getAll ($_fields = ['*'])
		{
			$join = 'users ON users.id = answers.user_id';
			$result = parent::_select($_fields, null, $join);

			while ($row = $result -> fetch(PDO::FETCH_ASSOC)) $fetchedResult[] = $row;

			return $fetchedResult;
		}

		public function getByUser ($_userId, $_fields)
		{
			$where = null;
			$fetchedResult = [];

			$where = Validation::isNumber($_userId) ? 'user_id = ' . $_userId : null;
			$result = parent::_select($_fields, $where);

			while ($row = $result -> fetch(PDO::FETCH_ASSOC)) $fetchedResult[] = $row;

			return $fetchedResult;
		}

		public function getByQuestion ($_questionId, $_fields)
		{
			$where = null;
			$fetchedResult = [];

			$where = Validation::isNumber($_questionId) ? 'question_id = ' . $_questionId : null;

			$result = parent::_select($_fields, $where, ' users ON users.id = answers.user_id');

			while ($row = $result -> fetch(PDO::FETCH_ASSOC)) $fetchedResult[] = $row;

			return $fetchedResult;
		}

		public function getCount ($_userId)
		{
			$where = Validation::isNumber($_userId) ? 'user_id = ' . $_userId : null;

			$result = parent::_select(['COUNT(*)'], $where);

			return $result -> fetchColumn();
		}

		public function update ($_answer, $_where)
		{
			return parent::_update([
				'answer' => $_answer], $_where);
		}
	}
?>