<?php

class EmployeeController extends Controller
{
    use Validator;

    public function index(): string
    {
        $errors = [];
        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
        if ($mysqli->connect_error) {
            throw new RuntimeException('データベース接続エラー: ' . $mysqli->connect_error);
        }
        $result = $mysqli->query('SELECT name FROM employees');
        $employees = $result->fetch_all(MYSQLI_ASSOC);

        return $this->render([
            'title' => '社員登録',
            'errors' => $errors,
            'employees' => $employees,
        ], 'index');
    }

    public function create(): string
    {
        if (!$this->application->getRequest()->isPost()) {
            throw new HttpNotFoundException();
        }

        $errors = [];
        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
        if ($mysqli->connect_error) {
            throw new RuntimeException('データベース接続エラー: ' . $mysqli->connect_error);
        }

        $result = $mysqli->query('SELECT name FROM employees');
        $employees = $result->fetch_all(MYSQLI_ASSOC);

        $errors = $this->validateName($_POST['name']);
        if (!count($errors)) {
            $stmt = $mysqli->prepare('INSERT INTO employees(name) VALUES (?)');
            if ($stmt) {
                $stmt->bind_param('s', $_POST['name']);
            }
            $stmt->execute();
            $stmt->close();
            header('Location: /employee');
        }

        return $this->render([
            'title' => '社員登録',
            'errors' => $errors,
            'employees' => $employees,
        ], 'index');
    }
}
