<?php
class Question
{
    private $question;

    public function __construct()
    {
        $this -> question = new TblQuestions();
    }

    public function getAll()
    {
        $result = $this -> question -> get();

        shuffle($result);

        return $result;
    }

    public function get()
    {
        $userId = Token::parse(Common::getheaders()['Authorization'])['userId'];

        $totalCount = $this -> question -> getCount();
        $result = $this -> question -> getByUser($userId);

        shuffle($result);

        return ['questions' => $result, 'totalCount' => $totalCount];
    }
}
