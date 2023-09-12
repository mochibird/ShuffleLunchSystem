<?php

class Employee extends DatabaseModel
{
    public function fetchAllNames(): array
    {
        return $this->fetchAll('SELECT emp_no, name FROM employees');
    }

    public function insert(array $params): void
    {
        $this->execute('INSERT INTO employees (emp_no, name) VALUES (?, ?)', ['is', $params['number'], $params['name']]);
    }
}
