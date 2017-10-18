<?php
final class TblUsers extends DbActionTemplate
{
    private $id;

    public function __construct()
    {
        parent::__construct(DB_DATA, TBL_USERS);
    }

    public function insert($_username, $_password, $_firstName, $_lastName)
    {
        return parent::_insert([
            'username' => strtolower($_username),
            'password' => md5($_password),
            'first_name' => ucfirst($_firstName),
            'last_name' => ucfirst($_lastName)]);
    }

    public function authenticate($_username, $_password)
    {
        $_username = strtolower($_username);
        $where = 'username = \'' . $_username . '\' AND password = \'' . md5($_password) . '\'';
        $result = parent::_select(['*'], $where);
        $fetchedResult = $result -> fetch(PDO::FETCH_ASSOC);

        return $fetchedResult;
    }

    public function get($_user = null)
    {
        $where = null;
        $fetchedResult = [];
        $_user = strtolower($_user);

        if ($_user != null) {
            $where = (Validation::isNumber($_user) ? 'id = ' . $_user . ' OR ' : null) . 'username = \'' . $_user . '\'';
        }

        $result = parent::_select(['*'], $where);

        while ($row = $result -> fetch(PDO::FETCH_ASSOC)) {
            $fetchedResult[] = $row;
        }

        if ($_user != null) {
            $fetchedResult = $fetchedResult[0];
        }

        return $fetchedResult;
    }

    public function getCount($_user = null)
    {
        $result = parent::_select(['COUNT(*)'], $where);

        return $result -> fetchColumn();
    }

    public function update($_user, $_params)
    {
        $where = null;
        $_user = strtolower($_user);

        if ($_user != null) {
            $where = (Validation::isNumber($_user) ? 'id = ' . $_user . ' OR ' : null) . 'username = \'' . $_user . '\'';
        }

        return parent::_update($_params, $where);
    }
}
