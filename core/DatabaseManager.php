<?php

class DatabaseManager
{
    protected $pdo;
    protected $models;

    public function connect(array $params): void
    {
        try {
            $pdo = new PDO($params['dbSource'], $params['username'], $params['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            echo 'DBエラー: ' . $e->getMessage();
            exit();
        }

        $this->pdo = $pdo;
    }

    public function get($modelName)
    {
        if (!isset($this->models[$modelName])) {
            $model = new $modelName($this->pdo);
            $this->models[$modelName] = $model;
        }
        return $this->models[$modelName];
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
}
