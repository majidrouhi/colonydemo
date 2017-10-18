<?php
class Answer
{
    private $answer, $user, $question;

    public function __construct()
    {
        $this -> answer = new TblAnswers();
        $this -> user = new TblUsers();
        $this -> question = new TblQuestions();
    }

    public function set($_params)
    {
        $point = 1;
        $userId = Token::parse(Common::getheaders()['Authorization'])['userId'];

        $result = $this -> answer -> insert($userId, $_params['questionId'], $_params['answer'], $point);

        return $result;
    }

    public function get($_userId = null, $_answers = null)
    {
        $userId = $_userId;

        if ((string) $userId == null) {
            $userId = Token::parse(Common::getheaders()['Authorization'])['userId'];
        }

        $weights = $this -> getWeights($userId, $_answers);
        $report = $this -> analyzData($weights, $userId);

        return $report;
    }

    public function getAnswersCount()
    {
        $userId = Token::parse(Common::getheaders()['Authorization'])['userId'];

        $answeredCount = $this -> question -> getCount();

        return ['answeredCount' => $answeredCount];
    }

    private function getWeights($_userId, $_answers = null)
    {
        $answers = $_answers;

        if ($_answers == null) {
            $answers = $this -> answer -> getByUser($_userId, ['question_id', 'answer']);
        }

        foreach ($answers as $index => $answer) {
            $dataset = $this -> answer -> getByQuestion($answer['question_id'], ['user_id', 'answer']);

            if ($_userId == 0) {
                $weights[0][$answer['question_id']] = 1;
            }

            foreach ($dataset as $data) {
                $point = self::getPoint($answer['answer'], $data['answer']);
                $weights[$data['user_id']][$answer['question_id']] = $point;
            }
        }

        return $weights;
    }

    private function analyzData($_data, $_userId)
    {
        $maxWeight = array_sum($_data[$_userId]);
        $maxCount = count($_data[$_userId]);

        foreach ($_data as $userId => $w) {
            $name = $this -> user -> get($userId)['first_name'];
            $totalQuestions = $this -> answer -> getCount($userId);

            $answerWeight = array_sum($w);
            $similarCount = count($w);
            $answerPercent = ($answerWeight * 100) / $similarCount;
            $questionPercent =  ($similarCount * 200) / ($maxCount + $totalQuestions);
            $totalPercent = round((($answerPercent * ($similarCount)) + $questionPercent * 5) / ($similarCount + 5), 2);

            if ($userId != $_userId) {
                $info[] = [
                'user_id' => $userId,
                'name' => $name,
                'answerWeight' => $answerWeight,
                'answerPercent' => round($answerPercent, 2),
                'questionPercent' => round($questionPercent, 2),
                'totalPercent' => $totalPercent,
                'totalQuestions' => $totalQuestions,
                'similarCount' => $similarCount];
            }
        }

        return array_reverse(Common::quickSort($info, 'totalPercent'));
    }

    private static function getPoint($_sample, $_answer)
    {
        $statusSet = [
            1 => [1 => 1, 2 => 0.875, 3 => 0.25, 4 => 0.125, 5 => 0],
            2 => [1 => 0.875, 2 => 1, 3 => 0.5, 4 => 0.25, 5 => 0.125],
            3 => [1 => 0.25, 2 => 0.5, 3 => 1, 4 => 0.5, 5 => 0.25],
            4 => [1 => 0.125, 2 => 0.25, 3 => 0.5, 4 => 1, 5 => 0.875],
            5 => [1 => 0, 2 => 0.125, 3 => 0.25, 4 => 0.875, 5 => 1]
        ];

        return $statusSet[$_sample][$_answer];
    }

    public function getSimpatico()
    {
        $users = $this -> user -> get();
        $user_idd=92;
        // foreach ($users as $user) {
        if (!is_null($this -> get($user_idd)[0]['totalPercent'])) {
            $commonQ = $this -> getCommonQuestions($user_idd, $this -> get($user_idd)[0]['user_id']);
            $result[$user_idd] = $this -> get(0, $commonQ);

            array_splice($result[$user_idd], 0, 1);
            array_splice($result[$user_idd], 0, 1);

            $result[$user_idd] = $result[$user_idd][0];
        }
        // }

        return $result;
    }

    private function getCommonQuestions($_user1, $_user2)
    {
        $user1Questions = $this -> answer -> getByUser($_user1, ['question_id', 'answer']);
        $user2Questions = $this -> answer -> getByUser($_user2, ['question_id', 'answer']);

        foreach ($user1Questions as $id => $answer) {
            $point = self::getPoint($answer['answer'], $user2Questions[$id]['answer']);

            if ($point == 1 || $point == 0.875) {
                $commonQuestions[$id] = $answer;
            }
        }

        return $commonQuestions;
    }
}
