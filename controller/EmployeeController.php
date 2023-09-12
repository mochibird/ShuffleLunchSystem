<?php

class EmployeeController extends Controller
{
    use Validator;

    public function index(): string
    {
        $errors = [];

        $employees = $this->databaseManager->get('Employee')->fetchAllNames();

        return $this->render([
            'title' => '社員登録',
            'errors' => $errors,
            'employees' => $employees,
        ], 'index');
    }

    public function create(): string
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundException();
        }

        $errors = [];
        $employee = $this->databaseManager->get('Employee');
        $employees = $employee->fetchAllNames();

        $params = [
            'number' => (int)$_POST['number'],
            'name' => $_POST['name'],
        ];

        $errors = $this->validateName($params['name']);
        if (!count($errors)) {
            $employee->insert($params);
        }
        return $this->render([
            'title' => '社員登録',
            'errors' => $errors,
            'employees' => $employees,
        ], 'index');
    }
}
