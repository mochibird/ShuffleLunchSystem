<?php

require_once(__DIR__ . '/../core/Controller.php');
require_once(__DIR__ . '/../core/Validator.php');

class EmployeeController extends Controller
{
    use Validator;

    public function index()
    {
        $errors = [];
        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
        if ($mysqli->connect_error) {
            throw new RuntimeException('データベース接続エラー: ' . $mysqli->connect_error);
        }
        $result = $mysqli->query('SELECT name FROM employees');
        $employees = $result->fetch_all(MYSQLI_ASSOC);

        include(__DIR__ . '/../views/employee.php');
    }

    public function create()
    {
        $errors = [];
        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
        if ($mysqli->connect_error) {
            throw new RuntimeException('データベース接続エラー: ' . $mysqli->connect_error);
        }

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

        include(__DIR__ . '/../views/employee.php');
    }
}
