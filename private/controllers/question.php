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

			return $result;
		}
	}
?>