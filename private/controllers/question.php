<?php
	class Question
	{
		private $question;

		public function __construct ()
		{
			$this -> question = new TblQuestions();
		}

		public function get ()
		{
			$result = $this -> question -> get();

			shuffle($result);

			return $result;
		}
	}
?>