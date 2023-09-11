<?php

require_once(__DIR__ . '/../core/Controller.php');

class ShuffleController extends Controller
{
    public function index()
    {
        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
        if ($mysqli->connect_error) {
            throw new RuntimeException('データベース接続エラー: ' . $mysqli->connect_error);
        }
        $groups = [];

        include(__DIR__ . '/../views/index.php');
    }

    public function create()
    {
        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
        if ($mysqli->connect_error) {
            throw new RuntimeException('データベース接続エラー: ' . $mysqli->connect_error);
        }

        $result = $mysqli->query('SELECT name FROM employees');
        $employees = $result->fetch_all(MYSQLI_ASSOC);
        $groups = [];

            shuffle($employees);
            if (count($employees) % 2 === 0) {
                $groups = array_chunk($employees, 2);
            } else {
                $extra = array_pop($employees);
                $groups = array_chunk($employees, 2);
                array_push($extra, $groups);
            }

        include(__DIR__ . '/../views/index.php');
    }
}
