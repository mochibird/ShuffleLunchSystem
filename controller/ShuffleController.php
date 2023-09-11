<?php

class ShuffleController extends Controller
{
    public function index(): string
    {
        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
        if ($mysqli->connect_error) {
            throw new RuntimeException('データベース接続エラー: ' . $mysqli->connect_error);
        }
        $groups = [];

        return $this->render([
            'groups' => $groups
        ]);
    }

    public function create(): string
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

        return $this->render([
            'groups' => $groups,
            'employees' => $employees,
        ], 'index');
    }
}
