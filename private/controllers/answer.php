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

		public function getanswers ($_userId)
		{
			$questions = $this -> question -> get();
			$answers = $this -> answer -> getByUser($_userId, ['question_id', 'answer']);

			foreach ($answers as $answer) $result[$answer['question_id']] = $answer['answer'];
			foreach ($questions as $index => $q) if (!isset($result[$q['id']])) $result[$q['id']] = '-';

			return $result;
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
				$dataset = $this -> answer -> getByQuestion($answer['question_id'], ['user_id', 'first_name', 'answer']);

				foreach ($dataset as $data)
				{
					$point = self::getPoint($answer['answer'], $data['answer']);
					$weight = $point * $questions[$answer['question_id'] - 1]['weight'];
 					$weights[$data['user_id']][$answer['question_id']] = $weight;
				}
			}

			return $weights;
		}

		private function analyzData ($_data, $_userId)
		{
			$maxWeight = array_sum($_data[$_userId]);
			$maxCount = count($_data[$_userId]);

			// $maxWeight = 0;
			// $maxCount = 0;

			// foreach ($_data as $user)
			// {
			// 	$sum = array_sum($user);
			// 	$count = count($user);

			// 	if ($sum > $maxWeight) $maxWeight = $sum;
			// 	if ($count > $maxCount) $maxCount = $count;
			// }

			foreach($_data as $userId => $w)
			{
				$name = $this -> user -> get($userId)['first_name'];

				$answerWeight = array_sum($w);
				$similarCount = count($w);
				$questionWeight = $similarCount / $maxCount;
				$answerPercent = ($answerWeight * 100) / $maxWeight;
				$questionPercent = ($questionWeight * 100) / 1;
				$totalPercent = round((($answerPercent + $questionPercent) * 100) / 200, 2);
				$info[$userId] = ['name' => $name, 'answerWeight' => $answerWeight, 'answerPercent' => $answerPercent, 'questionWeight' => $questionWeight, 'questionPercent' => $questionPercent, 'totalPercent' => $totalPercent, 'similarCount' => $similarCount];
			}

			return $info;
		}

		private static function getPoint ($_sample, $_answer)
		{
			$statusSet = [
				1 => [1 => 1, 2 => 0.75, 3 => 0.5, 4 => 0.25, 5 => 0],
				2 => [1 => 0.75, 2 => 1, 3 => 0.62, 4 => 0.25, 5 => 0],
				3 => [1 => 0.5, 2 => 0.62, 3 => 1, 4 => 0.62, 5 => 0.5],
				4 => [1 => 0.25, 2 => 0.25, 3 => 0.62, 4 => 1, 5 => 0.75],
				5 => [1 => 0, 2 => 0, 3 => 0.5, 4 => 0.75, 5 => 1]
			];

			return $statusSet[$_sample][$_answer];
		}
	}
?>