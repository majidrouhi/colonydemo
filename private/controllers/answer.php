<?php
	class Answer
	{
		private $answer, $user;

		public function __construct ()
		{
			$this -> answer = new TblAnswers();
			$this -> user = new TblUsers();
		}

		public function set ($_params)
		{
			$token = Validation::header(['Authorization'])['Authorization'];

			$point = 1;
			$userData = Token::parse(getallheaders()['Authorization']);

			$result = $this -> answer -> insert($userData['userId'], $_params['questionId'], $_params['answer'], $point);

			return $result;
		}

		public function getAll ()
		{
			$result = null;

			$data = $this -> answer -> getAll(['user_id', 'question_id', 'answer', 'users.first_name as name']);

			foreach($data as $value)
			{
				if ($result[$value['user_id']] == null) $result[$value['user_id']] = ['name' => $value['name'], 'answers' => [], 'nearest' => []];

				$result[$value['user_id']]['answers'][$value['question_id']] = $value['answer'];
			}

			foreach ($result as $key => $user) $result[$key]['nearest'] = $this -> findNearest($key, $result);

			return $result;
		}

		public function findNearest($_userId, $_data)
		{
			$dataset = [];

			foreach ($_data as $key => $user)
			{
				$dataset[$key] = $user['answers'];
			}

			$nearest = classification::knn($_data[$_userId]['answers'], $dataset);

			foreach($nearest as $key => $data)
			{
				$percent = round(100 - (($data * 100) / 5.9160797831), 2);
				$raw = round($data, 2);
				$result[$key] = ['raw' => $raw, 'percent' => $percent];
			}

			return $result;
		}
	}
?>