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

        $errors = $this->validateName($_POST['name']);
        if (!count($errors)) {
            $employee->insert($_POST['name']);
        }
        return $this->render([
            'title' => '社員登録',
            'errors' => $errors,
            'employees' => $employees,
        ], 'index');
    }
}
