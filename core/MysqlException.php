<?php

class MySqlException extends Exception
{
    public function __construct($message = "MySQLエラー", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
