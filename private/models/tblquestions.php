<?php
final class TblQuestions extends DbActionTemplate
{
    private $id;

    public function __construct()
    {
        parent::__construct(DB_DATA, TBL_QUESTIONS);
    }

    public function insert($_category, $_option1, $_option2, $_weight, $_isActive)
    {
        return parent::_insert([
            'category' => $_category,
            'option1' => $_option1,
            'option2' => $_option2,
            'weight' => $_weight,
            'is_active' => $_isActive]);
    }

    public function get($_id = null)
    {
        $where = null;
        $fetchedResult = [];

        if ($_id != null) {
            $where = Validation::isNumber($_id) ? 'id = ' . $_id : null;
        }

        $result = parent::_select(['*'], $where);

        while ($row = $result -> fetch(PDO::FETCH_ASSOC)) {
            $fetchedResult[] = $row;
        }

        return $fetchedResult;
    }

    public function getByUser($_userId)
    {
        $where = null;
        $fetchedResult = [];

        $where = Validation::isNumber($_userId) ? 'id NOT IN (SELECT question_id from answers WHERE user_id = ' . $_userId . ')' : null;

        $result = parent::_select(['*'], $where);

        while ($row = $result -> fetch(PDO::FETCH_ASSOC)) {
            $fetchedResult[] = $row;
        }

        return $fetchedResult;
    }

    public function getCount($_category = null)
    {
        if ($_category != null) {
            $where = Validation::isNumber($_category) ? 'category = ' . $_category : null;
        }

        $result = parent::_select(['COUNT(*)'], $where);

        return $result -> fetchColumn();
    }

    public function update($_id, $_params)
    {
        $where = null;

        if ($_id != null) {
            $where = Validation::isNumber($_id) ? 'id = ' . $_id : null;
        }

        return parent::_update($_params, $where);
    }
}
