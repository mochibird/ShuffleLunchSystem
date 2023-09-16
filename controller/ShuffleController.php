<?php

class ShuffleController extends Controller
{
    public function index(): string
    {
        session_start();

        $groups = [];
        Token::createToken();

        return $this->render([
            'groups' => $groups,
        ]);
    }

    public function create(): string
    {
        session_start();
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
                array_push($extra, $groups[0]);
            }

        Token::validateToken();
        unset($_SESSION['token']);

        return $this->render([
            'groups' => $groups,
            'employees' => $employees,
        ], 'index');
    }
}
