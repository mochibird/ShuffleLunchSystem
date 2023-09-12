<?php

class DatabaseManager
{
    protected $mysqli;
    protected $models;

    public function connect(array $params): void
    {
        $mysqli = new mysqli($params['hostname'], $params['username'], $params['password'], $params['database']);
        if ($mysqli->connect_error) {
            throw new RuntimeException();
        }

        $this->mysqli = $mysqli;
    }

    public function get($modelName)
    {
        if (!isset($this->models[$modelName])) {
            $model = new $modelName($this->mysqli);
            $this->models[$modelName] = $model;
        }
        return $this->models[$modelName];
    }

    public function __destruct()
    {
        $this->mysqli->close();
    }
}
