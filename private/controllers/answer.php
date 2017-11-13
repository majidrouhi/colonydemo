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

    public function set($_userId, $_params)
    {
        $point = 1;

        $result = $this -> answer -> insert(
            $_userId,
            $_params['questionId'],
            $_params['answer'],
            $point
        );

        return $result;
    }

    public function getAll()
    {
        $users = $this -> user -> get();
        $all = [];

        foreach ($users as $user) {
            $answers = [];
            $this_user = [];
            $this_user_answers = $this -> answer -> getByUser(
                $user['id'],
                ['question_id', 'answer']
            );

            foreach ($this_user_answers as $value) {
                $answers[$value['question_id']] = $value['answer'];
            }

            for ($i = 1; $i < 177; $i++) {
                if (isset($answers[$i])) {
                    switch ($answers[$i]) {
                    }

                    $this_user[] = (int) $answers[$i];
                } else {
                    $this_user[] = 0;
                }
            }

            $all[] = $this_user;
        }

        return $all;
    }

    public function get($_userId)
    {
        $weights = $this -> getWeights($_userId);
        $report = $this -> analyzData($_userId, $weights);

        return $report;
    }

    private function getWeights($_userId)
    {
        $answers = $this -> answer -> getByUser(
            $_userId,
            ['question_id', 'answer']
        );

        foreach ($answers as $index => $answer) {
            $dataset = $this -> answer -> getByQuestion(
                $answer['question_id'],
                ['user_id', 'answer']
            );

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

    private function analyzData($_userId, $_data)
    {
        $maxWeight = array_sum($_data[$_userId]);
        $maxCount = count($_data[$_userId]);
        $all = [];

        foreach ($_data as $userId => $w) {
            $name = $this -> user -> get($userId)['first_name'];
            $totalQuestions = $this -> answer -> getCount($userId);

            $answerWeight = array_sum($w);
            $similarCount = count($w);
            $answerPercent = ($answerWeight * 100) / $similarCount;
            $questionPercent =
                ($similarCount * 200) / ($maxCount + $totalQuestions);
            $totalPercent = round(
                (($answerPercent * ($similarCount)) + $questionPercent * 5) /
                ($similarCount + 6), 2);

            $all[] = $answerWeight;

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

        // return $all;
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

        // $statusSet = [
        //     1 => [1 => 100, 2 => 75, 3 => 0, 4 => -75, 5 => -100],
        //     2 => [1 => 75, 2 => 100, 3 => 25, 4 => -50, 5 => -75],
        //     3 => [1 => 0, 2 => 25, 3 => 0, 4 => 25, 5 => 0],
        //     4 => [1 => -75, 2 => -50, 3 => 25, 4 => 100, 5 => 75],
        //     5 => [1 => -100, 2 => -75, 3 => 0, 4 => 75, 5 => 100]
        // ];

        return $statusSet[$_sample][$_answer];
    }
}
