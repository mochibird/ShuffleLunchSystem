<?php

class Employee extends DatabaseModel
{
    public function fetchAllNames(): array
    {
        return $this->fetchAll('SELECT emp_no, name FROM employees');
    }

    public function insert(array $params)
    {
        $this->execute('INSERT INTO employees (emp_no, name) VALUES (?, ?)', 'is', [(int)$params['number'], $params['name']]);
    }

    public function updateName(array $params)
    {
        $this->update('UPDATE employees SET name = ? WHERE emp_no = ?', 'si', [$params['name'], (int)$params['number']]);
    }
}
