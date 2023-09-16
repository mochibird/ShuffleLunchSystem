<?php

class EmployeeController extends Controller
{
    use Validator;

    public function index(): string
    {
        session_start();
        $errors = [];
        $employees = $this->databaseManager->get('Employee')->fetchAllNames();
        Token::createToken();

        return $this->render([
            'title' => '社員登録',
            'errors' => $errors,
            'employees' => $employees,
        ], 'index');
    }

    public function create(): string
    {
        session_start();
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }
        $errors = [];
        $employee = $this->databaseManager->get('Employee');
        $employees = $employee->fetchAllNames();
        $params = [
            'name' => $_POST['name'],
            'number' => $_POST['number'],
        ];
        Token::validateToken();
        $errors = $this->validateEmployeeInsertData($params, $employees);
        if (!count($errors)) {
            $employee->insert($params);
        }
        return $this->render([
            'title' => '社員登録',
            'errors' => $errors,
            'employees' => $employees,
        ], 'index');
    }

    public function edit(): string
    {
        session_start();
        $errors = [];
        $employee = $this->databaseManager->get('Employee');
        $employees = $employee->fetchAllNames();

        Token::createToken();
        return $this->render([
            'title' => '登録情報の編集',
            'errors' => $errors,
            'employees' => $employees,
        ], 'edit');
    }

    public function update(): string
    {
        session_start();
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        $errors = [];
        $employee = $this->databaseManager->get('Employee');
        $employees = $employee->fetchAllNames();

        $params = [
            'name' => $_POST['name'],
            'number' => $_POST['number'],
        ];

        Token::validateToken();
        $errors = $this->validateEmployeeUpdateData($params, $employees);
        if (!count($errors)) {
            $employee->updateName($params);
        }

        return $this->render([
            'title' => '登録情報の編集',
            'errors' => $errors,
            'employees' => $employees,
        ], 'edit');
    }
}
