<?php

class Employee extends DatabaseModel
{
    public function fetchAllNames(): array
    {
        return $this->fetchAll('SELECT name FROM employees');
    }

    public function insert($name): void
    {
        $this->execute('INSERT INTO employees (name) VALUES (?)', ['s', $name]);
    }
}
