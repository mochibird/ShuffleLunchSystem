<?php

class DatabaseModel
{
    protected $mysqli;
    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    protected function fetchAll($sql): array
    {
        $result = $this->mysqli->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    protected function execute(string $sql, string $types, array $params):void
    {
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt) {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new MySqlException('プリペアドステートメントの作成に失敗しました: ' . $this->mysqli->error);
        }
    }

    protected function update(string $sql, string $types, array $params): void
    {
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt) {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new MySqlException('プリペアドステートメントの作成に失敗しました: ' . $this->mysqli->error);
        }
    }
}
