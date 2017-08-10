<?php
	class Answer
	{
		private $answer, $user, $question;

		public function __construct ()
		{
			$this -> answer = new TblAnswers();
			$this -> user = new TblUsers();
			$this -> question = new TblQuestions();
		}

		public function set ($_params)
		{
			$point = 1;
			$userId = Token::parse(Common::getheaders()['Authorization'])['userId'];

			$result = $this -> answer -> insert($userId, $_params['questionId'], $_params['answer'], $point);

			return $result;
		}

		public function getAll ()
		{
			$users = $this -> user -> get();

			foreach ($users as $user) $result[$user['id']] = ['name' => $user['first_name'], 'data' => $this -> get($user['id']) /*, 'answers' => $this -> getanswers($user['id']) */];

			return $result;
		}

		public function getAnswers ()
		{
			$userId = Token::parse(Common::getheaders()['Authorization'])['userId'];

			$questions = $this -> question -> get();
			$answers = $this -> answer -> getByUser($userId, ['question_id', 'answer']);

			foreach ($answers as $answer) $result[$answer['question_id']] = $answer['answer'];
			foreach ($questions as $index => $q) if (!isset($result[$q['id']])) $result[$q['id']] = '-';

			return $result;
		}

		public function getAnswersCount ()
		{
			$userId = Token::parse(Common::getheaders()['Authorization'])['userId'];

			$answeredCount = $this -> question -> getCount();

			return ['answeredCount' => $answeredCount];
		}

		public function get ($_userId = null)
		{
			$userId = $_userId;

			if ($_userId == null) $userId = Token::parse(Common::getheaders()['Authorization'])['userId'];

			$weights = $this -> getWeights($userId);
			$report = $this -> analyzData($weights, $userId);

			return $report;
		}

		private function getWeights ($_userId)
		{
			$answers = $this -> answer -> getByUser($_userId, ['question_id', 'answer']);
			$questions = $this -> question -> get();

			foreach ($answers as $index => $answer)
			{
				$dataset = $this -> answer -> getByQuestion($answer['question_id'], ['user_id', 'answer']);

				foreach ($dataset as $data)
				{
					$point = self::getPoint($answer['answer'], $data['answer']);
					$weight = $point * 1;
					$weights[$data['user_id']][$answer['question_id']] = $weight;
				}
			}

			return $weights;
		}

		private function analyzData ($_data, $_userId)
		{
			$maxWeight = array_sum($_data[$_userId]);
			$maxCount = count($_data[$_userId]);

			foreach($_data as $userId => $w)
			{
				$name = $this -> user -> get($userId)['first_name'];
				$totalQuestions = $this -> answer -> getCount($userId);

				$answerWeight = array_sum($w);
				$similarCount = count($w);
				$answerPercent = ($answerWeight * 200) / ($maxWeight + ($totalQuestions * 1));
				$questionPercent = ($similarCount * 200) / ($maxCount + $totalQuestions);
				$totalPercent = round((($answerPercent * $similarCount) + $questionPercent) / ($similarCount + 1) , 2);

				if ($userId != $_userId) $info[] = ['name' => $name, 'answerWeight' => $answerWeight, 'answerPercent' => $answerPercent, 'questionWeight' => $questionWeight, 'questionPercent' => $questionPercent, 'totalPercent' => $totalPercent, 'totalQuestions' => $totalQuestions, 'similarCount' => $similarCount];
			}

			return array_reverse(Common::quickSort($info, 'totalPercent'));
		}

		private static function getPoint ($_sample, $_answer)
		{
			$statusSet = [
				1 => [1 => 1, 2 => 0.875, 3 => 0.25, 4 => 0.125, 5 => 0],
				2 => [1 => 0.875, 2 => 1, 3 => 0.5, 4 => 0.25, 5 => 0.125],
				3 => [1 => 0.25, 2 => 0.5, 3 => 1, 4 => 0.5, 5 => 0.25],
				4 => [1 => 0.125, 2 => 0.25, 3 => 0.50, 4 => 1, 5 => 0.875],
				5 => [1 => 0, 2 => 0.125, 3 => 0.25, 4 => 0.875, 5 => 1]
			];

			return $statusSet[$_sample][$_answer];
		}
	}
?>