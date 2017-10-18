<?php
final class TblLogs extends DbActionTemplate
{
    public function __construct()
    {
        parent::__construct(DB_LOG, TBL_LOGS);
    }

    public function insert($_file = null, $_function = null, $_line = null, $_message = null, $_trace = null, $_type = null)
    {
        return parent::_insert([
            'file' => $_file,
            'function' => $_function,
            'line' => $_line,
            'ip' => $_SESSION['IP_ADDRESS'],
            'url' => $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'os' => $_SESSION['PLATFORM'] . ' (' . $_SESSION['DEVICE_TYPE'] . ')',
            'browser' => $_SESSION['BROWSER'],
            'message' => $_message,
            'trace' => $_trace,
            'type' => $_type]);
    }

    public function get($_whereStr = null, $_from = 1)
    {
        $result = parent::_select(['*'], $_whereStr, $_from . ', ' . RESULT_COUNT_PER_REQUEST, 'insert_datetime DESC') -> fetch(PDO::FETCH_ASSOC);

        while ($row = $result -> fetch(PDO::FETCH_ASSOC)) {
            $fetchedResult[] = $row;
        }

        return $fetchedResult;
    }

    public function getByType($_type, $_from = 1)
    {
        $whereStr = 'type = ' . $_type;

        return self::get($whereStr, $_from);
    }

    public function getByFile($_file, $_from = 1)
    {
        $whereStr = 'file = ' . $_file;

        return self::get($whereStr, $_from);
    }

    public function getByFunction($_function, $_from = 1)
    {
        $whereStr = 'function = ' . $_function;

        return self::get($whereStr, $_from);
    }

    public function getByIp($_ip, $_from = 1)
    {
        $whereStr = 'ip = ' . $_ip;

        return self::get($whereStr, $_from);
    }

    public function getByOs($_os, $_from = 1)
    {
        $whereStr = 'os = ' . $_os;

        return self::get($whereStr, $_from);
    }

    public function getByBrowser($_browser, $_from = 1)
    {
        $whereStr = 'browser = ' . $_browser;

        return self::get($whereStr, $_from);
    }
}
