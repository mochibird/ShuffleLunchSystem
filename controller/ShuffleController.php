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
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        $employees = $this->databaseManager->get('Employee')->fetchAllNames();
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
