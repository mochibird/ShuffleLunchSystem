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
            'name' => $_POST['name'],
            'number' => $_POST['number'],
        ];

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
        $errors = [];
        $employee = $this->databaseManager->get('Employee');
        $employees = $employee->fetchAllNames();

        return $this->render([
            'title' => '登録情報の編集',
            'errors' => $errors,
            'employees' => $employees,
        ], 'edit');
    }

    public function update(): string
    {
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
