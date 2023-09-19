<?php

class Employee extends DatabaseModel
{
    public function fetchAllNames(): array
    {
        return $this->fetchAll('SELECT emp_no, name FROM employees');
    }

    public function insert(array $params)
    {
        $this->execute('INSERT INTO employees (emp_no, name) VALUES (:number, :name)', [
            ':emp_no' => (int)$params['number'],
            ':name' => $params['name']]);
    }

    public function updateName(array $params)
    {
        $this->update('UPDATE employees SET name = :name WHERE emp_no = :number',  [
            ':name' => $params['name'],
            ':emp_no' => (int)$params['number']]);
    }
}
